<?php

declare(strict_types=1);

namespace App\CreatorsApi;

use App\Support\HttpException;

final class Client
{
    private const DEFAULT_RESOURCES = [
        'images.primary.small',
        'images.primary.medium',
        'images.primary.large',
        'images.variants.medium',
        'itemInfo.title',
        'itemInfo.features',
        'offersV2.listings.price',
        'offersV2.listings.savings',
        'offersV2.listings.availability',
        'offersV2.listings.condition',
        'offersV2.listings.isBuyBoxWinner',
        'offersV2.listings.merchantInfo',
        'browseNodeInfo.browseNodes',
        'browseNodeInfo.browseNodes.salesRank',
        'browseNodeInfo.websiteSalesRank',
    ];

    public function __construct(
        private Config $config,
        private TokenProvider $tokenProvider
    ) {
    }

    /**
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function searchItems(array $params): array
    {
        if (!isset($params['resources']) || !is_array($params['resources']) || $params['resources'] === []) {
            $params['resources'] = self::DEFAULT_RESOURCES;
        }

        $payload = array_merge($params, [
            'marketplace' => $this->config->marketplace(),
            'partnerTag' => $this->config->partnerTag(),
        ]);

        return $this->post('/catalog/v1/searchItems', $payload);
    }

    /**
     * @param string[] $itemIds
     * @param string[] $resources
     * @return array<string, mixed>
     */
    public function getItems(array $itemIds, array $resources = []): array
    {
        if ($resources === []) {
            $resources = self::DEFAULT_RESOURCES;
        }

        $payload = [
            'itemIds' => array_values($itemIds),
            'itemIdType' => 'ASIN',
            'marketplace' => $this->config->marketplace(),
            'partnerTag' => $this->config->partnerTag(),
            'resources' => array_values($resources),
        ];

        return $this->post('/catalog/v1/getItems', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    private function post(string $path, array $payload): array
    {
        $url = rtrim($this->config->apiBaseUrl(), '/') . $path;
        $ch = curl_init($url);
        if ($ch === false) {
            throw new HttpException('No fue posible iniciar cURL para llamada a Creators API.', 500);
        }

        $token = $this->tokenProvider->getAccessToken();
        $authHeader = 'Authorization: Bearer ' . $token;
        $credentialVersion = $this->config->authorizationVersionHeader();
        if ($credentialVersion !== null) {
            $authHeader .= ', Version ' . $credentialVersion;
        }

        $jsonPayload = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if (!is_string($jsonPayload)) {
            throw new HttpException('No fue posible serializar payload de Creators API.', 500);
        }

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                $authHeader,
                'Content-Type: application/json',
                'x-marketplace: ' . $this->config->marketplace(),
            ],
            CURLOPT_POSTFIELDS => $jsonPayload,
            CURLOPT_TIMEOUT => $this->config->requestTimeoutSeconds(),
        ]);

        $responseBody = curl_exec($ch);
        if ($responseBody === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new HttpException('Error de red al llamar Creators API: ' . $error, 502);
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $json = json_decode($responseBody, true);
        if (!is_array($json)) {
            throw new HttpException('Creators API devolvió una respuesta no JSON.', 502, [
                'status' => $statusCode,
                'body' => $responseBody,
            ]);
        }

        if ($statusCode >= 400) {
            $message = $json['message'] ?? $json['error_description'] ?? 'Error de Creators API.';
            throw new HttpException((string) $message, $statusCode, ['response' => $json]);
        }

        return $json;
    }
}
