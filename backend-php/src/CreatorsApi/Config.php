<?php

declare(strict_types=1);

namespace App\CreatorsApi;

use App\Support\Env;
use App\Support\HttpException;

final class Config
{
    private const V2_ENDPOINTS = [
        'V2.1' => 'https://creatorsapi.auth.us-east-1.amazoncognito.com/oauth2/token',
        'V2.2' => 'https://creatorsapi.auth.eu-south-2.amazoncognito.com/oauth2/token',
        'V2.3' => 'https://creatorsapi.auth.us-west-2.amazoncognito.com/oauth2/token',
    ];

    private const V3_ENDPOINTS = [
        'V3.1' => 'https://api.amazon.com/auth/o2/token',
        'V3.2' => 'https://api.amazon.co.uk/auth/o2/token',
        'V3.3' => 'https://api.amazon.co.jp/auth/o2/token',
    ];

    public function __construct(
        private string $credentialId,
        private string $credentialSecret,
        private string $version,
        private string $marketplace,
        private string $partnerTag,
        private int $requestTimeoutSeconds
    ) {
    }

    public static function fromEnv(Env $env): self
    {
        $version = strtoupper(trim((string) $env->get('VERSION', 'V3.1')));
        if (!str_starts_with($version, 'V')) {
            $version = 'V' . $version;
        }

        if (!isset(self::V2_ENDPOINTS[$version]) && !isset(self::V3_ENDPOINTS[$version])) {
            throw new HttpException(
                "VERSION no soportada: {$version}. Usa V2.1/V2.2/V2.3 o V3.1/V3.2/V3.3.",
                500
            );
        }

        $timeoutRaw = $env->get('REQUEST_TIMEOUT_SECONDS', '20');
        if (!is_numeric($timeoutRaw) || (int) $timeoutRaw <= 0) {
            throw new HttpException('REQUEST_TIMEOUT_SECONDS debe ser un entero positivo.', 500);
        }

        return new self(
            credentialId: $env->getRequired('CREDENTIAL_ID'),
            credentialSecret: $env->getRequired('CREDENTIAL_SECRET'),
            version: $version,
            marketplace: $env->getRequired('MARKETPLACE'),
            partnerTag: $env->getRequired('PARTNER_TAG'),
            requestTimeoutSeconds: (int) $timeoutRaw
        );
    }

    public function credentialId(): string
    {
        return $this->credentialId;
    }

    public function credentialSecret(): string
    {
        return $this->credentialSecret;
    }

    public function marketplace(): string
    {
        return $this->marketplace;
    }

    public function partnerTag(): string
    {
        return $this->partnerTag;
    }

    public function requestTimeoutSeconds(): int
    {
        return $this->requestTimeoutSeconds;
    }

    public function tokenEndpoint(): string
    {
        return self::V3_ENDPOINTS[$this->version] ?? self::V2_ENDPOINTS[$this->version];
    }

    public function tokenScope(): string
    {
        return $this->isV3() ? 'creatorsapi::default' : 'creatorsapi/default';
    }

    public function isV3(): bool
    {
        return str_starts_with($this->version, 'V3.');
    }

    public function authorizationVersionHeader(): ?string
    {
        if ($this->isV3()) {
            return null;
        }

        return strtolower(substr($this->version, 1));
    }

    public function apiBaseUrl(): string
    {
        return 'https://creatorsapi.amazon';
    }
}
