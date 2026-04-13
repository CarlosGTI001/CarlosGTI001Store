<?php

declare(strict_types=1);

namespace App\AI;

use App\Support\HttpException;

final class CohereClient
{
    private const CHAT_V2_URL = 'https://api.cohere.com/v2/chat';
    private const CHAT_V1_URL = 'https://api.cohere.com/v1/chat';

    public function __construct(
        private string $apiKey,
        private string $model,
        private int $timeoutSeconds
    ) {
    }

    /**
     * @param array<int, array<string, mixed>> $rankedItems
     * @param array<string, mixed> $context
     * @return array<string, mixed>
     */
    public function analyzeRanking(array $rankedItems, array $context = []): array
    {
        $trimmed = array_slice($rankedItems, 0, 8);
        $compactItems = [];
        $asinToAffiliateUrl = [];
        $asinToTitle = [];

        foreach ($trimmed as $item) {
            $asin = isset($item['asin']) && is_string($item['asin']) ? strtoupper(trim($item['asin'])) : '';
            $affiliateUrl = isset($item['affiliateUrl']) && is_string($item['affiliateUrl'])
                ? trim($item['affiliateUrl'])
                : null;
            $title = isset($item['title']) && is_string($item['title']) ? trim($item['title']) : null;

            if ($asin !== '') {
                $asinToAffiliateUrl[$asin] = $affiliateUrl;
                $asinToTitle[$asin] = $title;
            }

            $compactItems[] = [
                'asin' => $asin !== '' ? $asin : null,
                'title' => $title,
                'affiliateUrl' => $affiliateUrl,
                'price' => $item['price'] ?? null,
                'currency' => $item['currency'] ?? null,
                'featuresCount' => $item['featuresCount'] ?? 0,
                'topFeatures' => array_slice(is_array($item['features'] ?? null) ? $item['features'] : [], 0, 5),
                'buyBoxWinner' => $item['buyBoxWinner'] ?? false,
                'savingsPercentage' => $item['savingsPercentage'] ?? null,
                'websiteSalesRank' => $item['websiteSalesRank'] ?? null,
                'heuristicScore' => $item['score']['final'] ?? null,
            ];
        }

        $prompt = $this->buildPrompt($compactItems, $context);
        $response = $this->requestChat($prompt);
        $text = $this->extractText($response);

        if ($text === null || $text === '') {
            throw new HttpException('Cohere no devolvió texto para análisis.', 502, [
                'response' => $response,
            ]);
        }

        $decoded = $this->extractJsonObject($text);
        $recommendedAsin = isset($decoded['recommendedAsin']) && is_string($decoded['recommendedAsin'])
            ? strtoupper(trim($decoded['recommendedAsin']))
            : null;
        if ($recommendedAsin !== null && !isset($asinToAffiliateUrl[$recommendedAsin])) {
            $recommendedAsin = null;
        }

        $summaryLong = $this->firstNonEmptyString(
            $decoded,
            ['summaryLong', 'comparisonSummary', 'fullReport', 'explanation']
        );
        $recommendationLong = $this->firstNonEmptyString(
            $decoded,
            ['recommendationLong', 'recommendedWhy', 'bestChoiceReason']
        );

        $productAnalyses = $this->normalizeProductAnalyses($decoded, $asinToAffiliateUrl, $asinToTitle);

        return [
            'model' => $this->model,
            'recommendedAsin' => $recommendedAsin,
            'recommendedAffiliateUrl' => $recommendedAsin !== null ? ($asinToAffiliateUrl[$recommendedAsin] ?? null) : null,
            'summaryLong' => $summaryLong,
            'recommendationLong' => $recommendationLong,
            'productAnalyses' => $productAnalyses,
        ];
    }

    /**
     * @param array<int, array<string, mixed>> $items
     * @param array<string, mixed> $context
     */
    private function buildPrompt(array $items, array $context): string
    {
        $payload = [
            'context' => $context,
            'items' => $items,
        ];

        return <<<PROMPT
Eres un analista de productos de e-commerce.
Evalúa los productos y devuelve una recomendación objetiva.

Responde SOLO JSON válido con esta estructura exacta:
{
  "recommendedAsin": "ASIN",
  "summaryLong": "análisis comparativo largo en español",
  "recommendationLong": "explicación larga de por qué recomiendas el mejor",
  "productAnalyses": [
    {"asin":"ASIN","analysis":"análisis del producto"}
  ]
}

Reglas:
- recommendedAsin debe ser uno de los ASIN provistos.
- summaryLong debe ser detallado (mínimo 700 caracteres).
- recommendationLong debe ser detallado (mínimo 350 caracteres).
- productAnalyses debe incluir todos los ASIN entregados.
- En cada analysis menciona explícitamente ventajas, desventajas y valor/precio.
- No inventes enlaces: usa los affiliateUrl provistos en los datos.
- No uses markdown ni texto fuera del JSON.

Datos:
{$this->safeJsonEncode($payload)}
PROMPT;
    }

    /**
     * @return array<string, mixed>
     */
    private function requestChat(string $prompt): array
    {
        $v2Error = null;

        try {
            $response = $this->sendRequest(self::CHAT_V2_URL, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.2,
            ]);
            return $response;
        } catch (HttpException $exception) {
            $v2Error = [
                'message' => $exception->getMessage(),
                'status' => $exception->getStatusCode(),
                'details' => $exception->getContext(),
            ];
        }

        try {
            return $this->sendRequest(self::CHAT_V1_URL, [
                'model' => $this->model,
                'message' => $prompt,
                'temperature' => 0.2,
            ]);
        } catch (HttpException $exception) {
            throw new HttpException(
                'No fue posible obtener análisis desde Cohere.',
                $exception->getStatusCode(),
                [
                    'v2' => $v2Error,
                    'v1' => [
                        'message' => $exception->getMessage(),
                        'status' => $exception->getStatusCode(),
                        'details' => $exception->getContext(),
                    ],
                ]
            );
        }
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    private function sendRequest(string $url, array $payload): array
    {
        $ch = curl_init($url);
        if ($ch === false) {
            throw new HttpException('No fue posible iniciar cURL para Cohere.', 500);
        }

        $jsonPayload = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if (!is_string($jsonPayload)) {
            throw new HttpException('No fue posible serializar payload para Cohere.', 500);
        }

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => $jsonPayload,
            CURLOPT_TIMEOUT => $this->timeoutSeconds,
        ]);

        $responseBody = curl_exec($ch);
        if ($responseBody === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new HttpException('Error de red al llamar Cohere: ' . $error, 502);
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($responseBody, true);
        if (!is_array($decoded)) {
            throw new HttpException('Cohere devolvió una respuesta no JSON.', 502, [
                'status' => $statusCode,
                'body' => $responseBody,
            ]);
        }

        if ($statusCode >= 400) {
            $message = $decoded['message'] ?? $decoded['error'] ?? 'Error en la API de Cohere.';
            throw new HttpException((string) $message, $statusCode, ['response' => $decoded]);
        }

        return $decoded;
    }

    /**
     * @param array<string, mixed> $response
     */
    private function extractText(array $response): ?string
    {
        if (isset($response['text']) && is_string($response['text'])) {
            return trim($response['text']);
        }

        if (
            isset($response['message']) &&
            is_array($response['message']) &&
            isset($response['message']['content']) &&
            is_array($response['message']['content'])
        ) {
            $chunks = [];
            foreach ($response['message']['content'] as $part) {
                if (is_array($part) && isset($part['text']) && is_string($part['text'])) {
                    $chunks[] = $part['text'];
                }
            }
            if ($chunks !== []) {
                return trim(implode("\n", $chunks));
            }
        }

        if (isset($response['message']) && is_string($response['message'])) {
            return trim($response['message']);
        }

        return null;
    }

    /**
     * @return array<string, mixed>
     */
    private function extractJsonObject(string $raw): array
    {
        $clean = trim($raw);
        if (str_starts_with($clean, '```')) {
            $clean = preg_replace('/^```[a-zA-Z]*\s*/', '', $clean) ?? $clean;
            $clean = preg_replace('/\s*```$/', '', $clean) ?? $clean;
            $clean = trim($clean);
        }

        $decoded = json_decode($clean, true);
        if (is_array($decoded)) {
            return $decoded;
        }

        $firstBrace = strpos($clean, '{');
        $lastBrace = strrpos($clean, '}');
        if ($firstBrace !== false && $lastBrace !== false && $lastBrace > $firstBrace) {
            $snippet = substr($clean, $firstBrace, ($lastBrace - $firstBrace + 1));
            $decoded = json_decode($snippet, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        throw new HttpException('Cohere respondió texto sin JSON válido.', 502, ['raw' => $raw]);
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function safeJsonEncode(array $payload): string
    {
        $encoded = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if (!is_string($encoded)) {
            return '{}';
        }

        return $encoded;
    }

    /**
     * @param array<string, mixed> $decoded
     * @param string[] $keys
     */
    private function firstNonEmptyString(array $decoded, array $keys): ?string
    {
        foreach ($keys as $key) {
            if (isset($decoded[$key]) && is_string($decoded[$key])) {
                $value = trim($decoded[$key]);
                if ($value !== '') {
                    return $value;
                }
            }
        }

        return null;
    }

    /**
     * @param array<string, mixed> $decoded
     * @param array<string, string|null> $asinToAffiliateUrl
     * @param array<string, string|null> $asinToTitle
     * @return array<int, array<string, string|null>>
     */
    private function normalizeProductAnalyses(array $decoded, array $asinToAffiliateUrl, array $asinToTitle): array
    {
        $candidates = [];
        if (isset($decoded['productAnalyses']) && is_array($decoded['productAnalyses'])) {
            $candidates = $decoded['productAnalyses'];
        } elseif (isset($decoded['products']) && is_array($decoded['products'])) {
            $candidates = $decoded['products'];
        } elseif (isset($decoded['itemNotes']) && is_array($decoded['itemNotes'])) {
            $candidates = $decoded['itemNotes'];
        }

        $analyses = [];
        foreach ($candidates as $candidate) {
            if (!is_array($candidate)) {
                continue;
            }

            $asin = isset($candidate['asin']) && is_string($candidate['asin'])
                ? strtoupper(trim($candidate['asin']))
                : '';
            if ($asin === '' || !isset($asinToAffiliateUrl[$asin])) {
                continue;
            }

            $analysisText = null;
            if (isset($candidate['analysis']) && is_string($candidate['analysis'])) {
                $analysisText = trim($candidate['analysis']);
            } elseif (isset($candidate['note']) && is_string($candidate['note'])) {
                $analysisText = trim($candidate['note']);
            }

            if ($analysisText === null || $analysisText === '') {
                continue;
            }

            $analyses[] = [
                'asin' => $asin,
                'title' => $asinToTitle[$asin] ?? null,
                'affiliateUrl' => $asinToAffiliateUrl[$asin] ?? null,
                'analysis' => $analysisText,
            ];
        }

        return $analyses;
    }
}
