<?php

declare(strict_types=1);

namespace App\CreatorsApi;

use App\Support\HttpException;

final class TokenProvider
{
    public function __construct(
        private Config $config,
        private string $cacheFilePath
    ) {
    }

    public function getAccessToken(): string
    {
        $cached = $this->readCache();
        if ($cached !== null) {
            $expiresAt = (int) ($cached['expires_at'] ?? 0);
            $token = $cached['access_token'] ?? null;
            if (is_string($token) && $token !== '' && $expiresAt > (time() + 90)) {
                return $token;
            }
        }

        [$token, $expiresIn] = $this->fetchToken();
        $this->writeCache($token, $expiresIn);

        return $token;
    }

    /**
     * @return array{0: string, 1: int}
     */
    private function fetchToken(): array
    {
        $ch = curl_init($this->config->tokenEndpoint());
        if ($ch === false) {
            throw new HttpException('No fue posible iniciar cURL para generar token.', 500);
        }

        $headers = [];
        $payload = '';

        if ($this->config->isV3()) {
            $headers[] = 'Content-Type: application/json';
            $payload = json_encode([
                'grant_type' => 'client_credentials',
                'client_id' => $this->config->credentialId(),
                'client_secret' => $this->config->credentialSecret(),
                'scope' => $this->config->tokenScope(),
            ], JSON_UNESCAPED_SLASHES);
        } else {
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            $payload = http_build_query([
                'grant_type' => 'client_credentials',
                'client_id' => $this->config->credentialId(),
                'client_secret' => $this->config->credentialSecret(),
                'scope' => $this->config->tokenScope(),
            ]);
        }

        if (!is_string($payload)) {
            throw new HttpException('No fue posible serializar el payload del token.', 500);
        }

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_TIMEOUT => $this->config->requestTimeoutSeconds(),
        ]);

        $responseBody = curl_exec($ch);
        if ($responseBody === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new HttpException('Error solicitando token OAuth: ' . $error, 502);
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $json = json_decode($responseBody, true);
        if (!is_array($json)) {
            throw new HttpException('Respuesta inválida al solicitar token OAuth.', 502, [
                'status' => $statusCode,
                'body' => $responseBody,
            ]);
        }

        if ($statusCode >= 400) {
            throw new HttpException(
                'No fue posible autenticar contra Amazon.',
                $statusCode,
                ['response' => $json]
            );
        }

        $accessToken = $json['access_token'] ?? null;
        if (!is_string($accessToken) || $accessToken === '') {
            throw new HttpException('No se recibió access_token en la respuesta OAuth.', 502, [
                'response' => $json,
            ]);
        }

        $expiresIn = isset($json['expires_in']) && is_numeric($json['expires_in'])
            ? (int) $json['expires_in']
            : 3600;

        return [$accessToken, $expiresIn];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function readCache(): ?array
    {
        if (!is_file($this->cacheFilePath)) {
            return null;
        }

        $raw = file_get_contents($this->cacheFilePath);
        if (!is_string($raw) || trim($raw) === '') {
            return null;
        }

        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : null;
    }

    private function writeCache(string $token, int $expiresIn): void
    {
        $dir = dirname($this->cacheFilePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $payload = [
            'access_token' => $token,
            'expires_at' => time() + max($expiresIn, 60),
        ];

        file_put_contents(
            $this->cacheFilePath,
            json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );
    }
}
