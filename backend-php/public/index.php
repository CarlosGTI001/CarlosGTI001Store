<?php

declare(strict_types=1);

use App\Comparison\ProductComparisonService;
use App\CreatorsApi\Client;
use App\CreatorsApi\Config;
use App\CreatorsApi\TokenProvider;
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
            'recommended' => $ranked[0] ?? null,
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

        $foundAsins = array_map(
            static fn(array $item): string => (string) ($item['asin'] ?? ''),
            $normalized
        );
        $missingAsins = array_values(array_diff($asins, $foundAsins));

        respond(200, [
            'requestedAsins' => $asins,
            'missingAsins' => $missingAsins,
            'items' => $ranked,
            'recommended' => $ranked[0] ?? null,
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
