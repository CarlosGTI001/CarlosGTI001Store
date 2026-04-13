<?php

declare(strict_types=1);

namespace App\Support;

final class Env
{
    /**
     * @param array<string, string> $values
     */
    private function __construct(
        private array $values
    ) {
    }

    public static function load(string $envPath): self
    {
        $values = [];

        if (is_file($envPath)) {
            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if ($lines !== false) {
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '' || str_starts_with($line, '#')) {
                        continue;
                    }

                    $separatorPos = strpos($line, '=');
                    if ($separatorPos === false) {
                        continue;
                    }

                    $key = trim(substr($line, 0, $separatorPos));
                    $value = trim(substr($line, $separatorPos + 1));
                    if ($key === '') {
                        continue;
                    }

                    if (
                        (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                        (str_starts_with($value, "'") && str_ends_with($value, "'"))
                    ) {
                        $value = substr($value, 1, -1);
                    }

                    $values[$key] = $value;
                }
            }
        }

        return new self($values);
    }

    public function get(string $key, ?string $default = null): ?string
    {
        $value = getenv($key);
        if ($value !== false && $value !== '') {
            return $value;
        }

        if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
            return (string) $_ENV[$key];
        }

        if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') {
            return (string) $_SERVER[$key];
        }

        if (isset($this->values[$key]) && $this->values[$key] !== '') {
            return $this->values[$key];
        }

        return $default;
    }

    public function getRequired(string $key): string
    {
        $value = $this->get($key);
        if ($value === null || trim($value) === '') {
            throw new HttpException("Falta variable de entorno requerida: {$key}", 500);
        }

        return trim($value);
    }
}
