<?php

declare(strict_types=1);

use App\AI\CohereClient;
use App\Comparison\ProductComparisonService;
use App\CreatorsApi\Client;
use App\CreatorsApi\Config;
use App\CreatorsApi\TokenProvider;
use App\Presentation\SemanticProductTransformer;
use App\Support\Env;
use App\Support\HttpException;

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
    http_response_code(204);
    exit;
}

spl_autoload_register(static function (string $className): void {
    if (!str_starts_with($className, 'App\\')) {
        return;
    }

    $relativePath = substr($className, 4);
    $relativePath = str_replace('\\', '/', $relativePath);
    $target = __DIR__ . '/../src/' . $relativePath . '.php';

    if (is_file($target)) {
        require_once $target;
    }
});

try {
    $env = Env::load(__DIR__ . '/../.env');
    $config = Config::fromEnv($env);
    $tokenProvider = new TokenProvider($config, __DIR__ . '/../storage/token-cache.json');
    $client = new Client($config, $tokenProvider);
    $comparisonService = new ProductComparisonService();
    $semanticTransformer = new SemanticProductTransformer();
    $aiProvider = strtolower(trim((string) $env->get('AI_PROVIDER', 'heuristic')));
    $cohereClient = null;

    if ($aiProvider === 'cohere') {
        $cohereApiKey = $env->getRequired('COHERE_API_KEY');
        $cohereModel = trim((string) $env->get('COHERE_MODEL', 'command-r-plus'));
        if ($cohereModel === '') {
            throw new HttpException('COHERE_MODEL no puede ser vacío cuando AI_PROVIDER=cohere.', 500);
        }

        $cohereClient = new CohereClient(
            apiKey: $cohereApiKey,
            model: $cohereModel,
            timeoutSeconds: $config->requestTimeoutSeconds()
        );
    }

    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $path = rtrim($path ?? '/', '/') ?: '/';

    if ($method === 'GET' && $path === '/health') {
        respond(200, ['status' => 'ok']);
    }

    if ($method === 'POST' && $path === '/api/search') {
        $body = readJsonBody();
        ensureSearchInputExists($body);

        $params = buildSearchParams($body);
        $response = $client->searchItems($params);

        $rawItems = $response['searchResult']['items'] ?? [];
        $normalized = $comparisonService->normalizeItems($rawItems);
        $weights = normalizeWeights($body['weights'] ?? null);
        $ranked = $comparisonService->rankItems($normalized, $weights);
        $ai = buildAiInsights($cohereClient, $ranked, [
            'operation' => 'search',
            'keywords' => $body['keywords'] ?? null,
            'searchIndex' => $body['searchIndex'] ?? null,
        ]);
        $ranked = applyAiItemInsights($ranked, $ai['productAnalyses'] ?? null);
        $recommended = selectRecommendedItem($ranked, $ai['recommendedAsin'] ?? null);
        $semantic = $semanticTransformer->build($ranked, $recommended, $ai, [
            'operation' => 'search',
            'keywords' => $body['keywords'] ?? null,
            'searchIndex' => $body['searchIndex'] ?? null,
            'marketplace' => $config->marketplace(),
        ]);

        respond(200, [
            'query' => [
                'keywords' => $body['keywords'] ?? null,
                'searchIndex' => $body['searchIndex'] ?? null,
            ],
            'search' => [
                'totalResultCount' => $response['searchResult']['totalResultCount'] ?? count($rawItems),
                'searchURL' => $response['searchResult']['searchURL'] ?? null,
            ],
            'items' => $ranked,
            'recommended' => $recommended,
            'ai' => $ai,
            'semantic' => $semantic,
            'errors' => $response['errors'] ?? [],
        ]);
    }

    if ($method === 'POST' && $path === '/api/compare') {
        $body = readJsonBody();
        $asins = normalizeAsins($body['asins'] ?? null);
        if (count($asins) < 2) {
            throw new HttpException('Debes enviar al menos 2 ASINs para comparar.', 422);
        }

        $resources = [];
        if (isset($body['resources'])) {
            if (!is_array($body['resources'])) {
                throw new HttpException('resources debe ser un arreglo de strings.', 422);
            }

            foreach ($body['resources'] as $resource) {
                if (!is_string($resource) || trim($resource) === '') {
                    throw new HttpException('resources debe contener solo strings no vacíos.', 422);
                }
                $resources[] = trim($resource);
            }
        }

        $response = $client->getItems($asins, $resources);
        $rawItems = $response['itemsResult']['items'] ?? $response['itemResults']['items'] ?? [];
        $normalized = $comparisonService->normalizeItems($rawItems);
        $weights = normalizeWeights($body['weights'] ?? null);
        $ranked = $comparisonService->rankItems($normalized, $weights);
        $ai = buildAiInsights($cohereClient, $ranked, [
            'operation' => 'compare',
            'requestedAsins' => $asins,
        ]);
        $ranked = applyAiItemInsights($ranked, $ai['productAnalyses'] ?? null);
        $recommended = selectRecommendedItem($ranked, $ai['recommendedAsin'] ?? null);
        $semantic = $semanticTransformer->build($ranked, $recommended, $ai, [
            'operation' => 'compare',
            'requestedAsins' => $asins,
            'marketplace' => $config->marketplace(),
        ]);

        $foundAsins = array_map(
            static fn(array $item): string => (string) ($item['asin'] ?? ''),
            $normalized
        );
        $missingAsins = array_values(array_diff($asins, $foundAsins));

        respond(200, [
            'requestedAsins' => $asins,
            'missingAsins' => $missingAsins,
            'items' => $ranked,
            'recommended' => $recommended,
            'ai' => $ai,
            'semantic' => $semantic,
            'errors' => $response['errors'] ?? [],
        ]);
    }

    throw new HttpException('Ruta no encontrada.', 404);
} catch (HttpException $exception) {
    respond($exception->getStatusCode(), [
        'error' => $exception->getMessage(),
        'details' => $exception->getContext(),
    ]);
} catch (Throwable $exception) {
    respond(500, [
        'error' => 'Error interno inesperado.',
        'details' => ['message' => $exception->getMessage()],
    ]);
}

function respond(int $statusCode, array $payload): void
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function readJsonBody(): array
{
    $rawBody = file_get_contents('php://input');
    if ($rawBody === false || trim($rawBody) === '') {
        return [];
    }

    $decoded = json_decode($rawBody, true);
    if (!is_array($decoded)) {
        throw new HttpException('El body debe ser JSON válido.', 400);
    }

    return $decoded;
}

function ensureSearchInputExists(array $body): void
{
    $searchFields = ['keywords', 'title', 'brand', 'actor', 'artist', 'author'];
    foreach ($searchFields as $field) {
        if (isset($body[$field]) && is_string($body[$field]) && trim($body[$field]) !== '') {
            return;
        }
    }

    throw new HttpException(
        'Debes enviar al menos uno de estos campos para buscar: keywords, title, brand, actor, artist, author.',
        422
    );
}

function buildSearchParams(array $body): array
{
    $params = [];
    $stringFields = ['keywords', 'title', 'brand', 'actor', 'artist', 'author', 'searchIndex', 'sortBy', 'condition'];

    foreach ($stringFields as $field) {
        if (isset($body[$field])) {
            if (!is_string($body[$field]) || trim($body[$field]) === '') {
                throw new HttpException("El campo {$field} debe ser string no vacío.", 422);
            }
            $params[$field] = trim($body[$field]);
        }
    }

    if (isset($body['itemCount'])) {
        $params['itemCount'] = clampInt($body['itemCount'], 1, 10, 'itemCount');
    }

    if (isset($body['itemPage'])) {
        $params['itemPage'] = clampInt($body['itemPage'], 1, 10, 'itemPage');
    }

    if (isset($body['minPrice'])) {
        $params['minPrice'] = positiveInt($body['minPrice'], 'minPrice');
    }

    if (isset($body['maxPrice'])) {
        $params['maxPrice'] = positiveInt($body['maxPrice'], 'maxPrice');
    }

    if (isset($body['resources'])) {
        if (!is_array($body['resources'])) {
            throw new HttpException('resources debe ser un arreglo de strings.', 422);
        }

        $params['resources'] = [];
        foreach ($body['resources'] as $resource) {
            if (!is_string($resource) || trim($resource) === '') {
                throw new HttpException('resources debe contener solo strings no vacíos.', 422);
            }
            $params['resources'][] = trim($resource);
        }
    }

    return $params;
}

function normalizeAsins(mixed $candidate): array
{
    if (!is_array($candidate)) {
        throw new HttpException('asins debe ser un arreglo de strings.', 422);
    }

    $normalized = [];
    foreach ($candidate as $asin) {
        if (!is_string($asin) || trim($asin) === '') {
            throw new HttpException('asins debe contener solo strings no vacíos.', 422);
        }
        $normalized[] = strtoupper(trim($asin));
    }

    $normalized = array_values(array_unique($normalized));
    if (count($normalized) > 10) {
        throw new HttpException('Se permiten máximo 10 ASINs por comparación.', 422);
    }

    return $normalized;
}

function normalizeWeights(mixed $candidate): ?array
{
    if ($candidate === null) {
        return null;
    }

    if (!is_array($candidate)) {
        throw new HttpException('weights debe ser un objeto con price, features y quality.', 422);
    }

    $keys = ['price', 'features', 'quality'];
    $weights = [];
    foreach ($keys as $key) {
        if (!array_key_exists($key, $candidate)) {
            continue;
        }

        $value = $candidate[$key];
        if (!is_numeric($value) || (float) $value < 0) {
            throw new HttpException("weights.{$key} debe ser numérico y mayor o igual a 0.", 422);
        }

        $weights[$key] = (float) $value;
    }

    return $weights;
}

function clampInt(mixed $value, int $min, int $max, string $field): int
{
    if (!is_numeric($value)) {
        throw new HttpException("{$field} debe ser numérico.", 422);
    }

    $integer = (int) $value;
    if ($integer < $min || $integer > $max) {
        throw new HttpException("{$field} debe estar entre {$min} y {$max}.", 422);
    }

    return $integer;
}

function positiveInt(mixed $value, string $field): int
{
    if (!is_numeric($value)) {
        throw new HttpException("{$field} debe ser numérico.", 422);
    }

    $integer = (int) $value;
    if ($integer <= 0) {
        throw new HttpException("{$field} debe ser un entero positivo.", 422);
    }

    return $integer;
}

/**
 * @param array<int, array<string, mixed>> $items
 * @param array<string, mixed> $context
 * @return array<string, mixed>
 */
function buildAiInsights(?CohereClient $cohereClient, array $items, array $context = []): array
{
    $fallbackAnalyses = [];
    foreach ($items as $item) {
        if (!isset($item['asin']) || !is_string($item['asin'])) {
            continue;
        }

        $fallbackAnalyses[] = [
            'asin' => strtoupper($item['asin']),
            'title' => isset($item['title']) && is_string($item['title']) ? $item['title'] : null,
            'affiliateUrl' => isset($item['affiliateUrl']) && is_string($item['affiliateUrl']) ? $item['affiliateUrl'] : null,
            'analysis' => isset($item['aiSummary']) && is_string($item['aiSummary']) ? $item['aiSummary'] : null,
        ];
    }

    if ($cohereClient === null) {
        return [
            'provider' => 'heuristic',
            'recommendedAsin' => isset($items[0]['asin']) && is_string($items[0]['asin']) ? strtoupper($items[0]['asin']) : null,
            'recommendedAffiliateUrl' => isset($items[0]['affiliateUrl']) && is_string($items[0]['affiliateUrl']) ? $items[0]['affiliateUrl'] : null,
            'summaryLong' => 'Recomendación basada en scoring heurístico de precio, características y señales de calidad.',
            'recommendationLong' => 'Activa AI_PROVIDER=cohere para obtener un informe comparativo más extenso generado por IA.',
            'productAnalyses' => $fallbackAnalyses,
        ];
    }

    try {
        $analysis = $cohereClient->analyzeRanking($items, $context);
        $recommendedAsin = isset($analysis['recommendedAsin']) && is_string($analysis['recommendedAsin'])
            ? strtoupper(trim($analysis['recommendedAsin']))
            : null;

        if ($recommendedAsin === null && isset($items[0]['asin']) && is_string($items[0]['asin'])) {
            $recommendedAsin = strtoupper($items[0]['asin']);
        }

        $recommendedAffiliateUrl = null;
        foreach ($items as $item) {
            $asin = isset($item['asin']) && is_string($item['asin']) ? strtoupper($item['asin']) : '';
            if ($asin !== '' && $asin === $recommendedAsin) {
                $recommendedAffiliateUrl = isset($item['affiliateUrl']) && is_string($item['affiliateUrl'])
                    ? $item['affiliateUrl']
                    : null;
                break;
            }
        }

        $productAnalyses = isset($analysis['productAnalyses']) && is_array($analysis['productAnalyses'])
            ? $analysis['productAnalyses']
            : $fallbackAnalyses;

        return [
            'provider' => 'cohere',
            'model' => $analysis['model'] ?? null,
            'recommendedAsin' => $recommendedAsin,
            'recommendedAffiliateUrl' => $analysis['recommendedAffiliateUrl'] ?? $recommendedAffiliateUrl,
            'summaryLong' => $analysis['summaryLong'] ?? null,
            'recommendationLong' => $analysis['recommendationLong'] ?? null,
            'productAnalyses' => $productAnalyses,
        ];
    } catch (HttpException $exception) {
        return [
            'provider' => 'cohere',
            'error' => $exception->getMessage(),
            'details' => $exception->getContext(),
            'recommendedAsin' => isset($items[0]['asin']) && is_string($items[0]['asin']) ? strtoupper($items[0]['asin']) : null,
            'recommendedAffiliateUrl' => isset($items[0]['affiliateUrl']) && is_string($items[0]['affiliateUrl']) ? $items[0]['affiliateUrl'] : null,
            'summaryLong' => 'No se pudo generar el análisis largo con Cohere en este momento. Se mantiene el ranking heurístico.',
            'recommendationLong' => null,
            'productAnalyses' => $fallbackAnalyses,
        ];
    }
}

/**
 * @param array<int, array<string, mixed>> $items
 * @param mixed $productAnalyses
 * @return array<int, array<string, mixed>>
 */
function applyAiItemInsights(array $items, mixed $productAnalyses): array
{
    if (!is_array($productAnalyses)) {
        return $items;
    }

    $insightsByAsin = [];
    foreach ($productAnalyses as $entry) {
        if (!is_array($entry)) {
            continue;
        }

        $asin = isset($entry['asin']) && is_string($entry['asin']) ? strtoupper(trim($entry['asin'])) : '';
        $text = null;
        if (isset($entry['analysis']) && is_string($entry['analysis'])) {
            $text = trim($entry['analysis']);
        } elseif (isset($entry['note']) && is_string($entry['note'])) {
            $text = trim($entry['note']);
        }

        if ($asin !== '' && is_string($text) && $text !== '') {
            $insightsByAsin[$asin] = $text;
        }
    }

    foreach ($items as &$item) {
        $asin = isset($item['asin']) && is_string($item['asin']) ? strtoupper($item['asin']) : '';
        if ($asin !== '' && isset($insightsByAsin[$asin])) {
            $item['aiSummary'] = $insightsByAsin[$asin];
        }
    }
    unset($item);

    return $items;
}

/**
 * @param array<int, array<string, mixed>> $items
 */
function selectRecommendedItem(array $items, mixed $recommendedAsin): ?array
{
    if (is_string($recommendedAsin) && trim($recommendedAsin) !== '') {
        $targetAsin = strtoupper(trim($recommendedAsin));
        foreach ($items as $item) {
            $asin = isset($item['asin']) && is_string($item['asin']) ? strtoupper($item['asin']) : '';
            if ($asin === $targetAsin) {
                return $item;
            }
        }
    }

    return $items[0] ?? null;
}
