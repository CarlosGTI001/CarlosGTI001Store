<?php

declare(strict_types=1);

namespace App\Comparison;

final class ProductComparisonService
{
    /**
     * @param array<int, array<string, mixed>> $items
     * @return array<int, array<string, mixed>>
     */
    public function normalizeItems(array $items): array
    {
        $normalized = [];

        foreach ($items as $item) {
            $listing = $this->selectListing($item);
            $features = $this->extractFeatures($item);
            $priceData = $listing['price']['money'] ?? null;

            $normalized[] = [
                'asin' => (string) ($item['asin'] ?? ''),
                'title' => $item['itemInfo']['title']['displayValue'] ?? null,
                'affiliateUrl' => $item['detailPageURL'] ?? null,
                'imageUrl' => $item['images']['primary']['large']['url']
                    ?? $item['images']['primary']['medium']['url']
                    ?? $item['images']['primary']['small']['url']
                    ?? null,
                'price' => isset($priceData['amount']) && is_numeric($priceData['amount'])
                    ? (float) $priceData['amount']
                    : null,
                'currency' => $priceData['currency'] ?? null,
                'displayPrice' => $priceData['displayAmount'] ?? null,
                'features' => $features,
                'featuresCount' => count($features),
                'buyBoxWinner' => (bool) ($listing['isBuyBoxWinner'] ?? false),
                'savingsPercentage' => isset($listing['price']['savings']['percentage'])
                    ? (float) $listing['price']['savings']['percentage']
                    : null,
                'condition' => $listing['condition']['value'] ?? null,
                'websiteSalesRank' => isset($item['browseNodeInfo']['websiteSalesRank']['salesRank'])
                    ? (int) $item['browseNodeInfo']['websiteSalesRank']['salesRank']
                    : null,
                'availability' => $listing['availability']['type'] ?? null,
            ];
        }

        return $normalized;
    }

    /**
     * @param array<int, array<string, mixed>> $items
     * @param array<string, float>|null $weights
     * @return array<int, array<string, mixed>>
     */
    public function rankItems(array $items, ?array $weights = null): array
    {
        $weights = $this->normalizeWeights($weights);

        $prices = [];
        foreach ($items as $item) {
            if (isset($item['price']) && is_numeric($item['price'])) {
                $prices[] = (float) $item['price'];
            }
        }

        $minPrice = $prices !== [] ? min($prices) : null;
        $maxPrice = $prices !== [] ? max($prices) : null;

        foreach ($items as &$item) {
            $priceScore = $this->calculatePriceScore($item['price'] ?? null, $minPrice, $maxPrice);
            $featuresScore = $this->calculateFeaturesScore((int) ($item['featuresCount'] ?? 0));
            $qualityScore = $this->calculateQualityScore($item);
            $finalScore = round(
                ($priceScore * $weights['price']) +
                ($featuresScore * $weights['features']) +
                ($qualityScore * $weights['quality']),
                2
            );

            $item['score'] = [
                'price' => $priceScore,
                'features' => $featuresScore,
                'quality' => $qualityScore,
                'final' => $finalScore,
                'weights' => $weights,
            ];
            $item['aiSummary'] = $this->buildSummary($item, $finalScore);
        }
        unset($item);

        usort($items, static function (array $left, array $right): int {
            $a = (float) ($left['score']['final'] ?? 0.0);
            $b = (float) ($right['score']['final'] ?? 0.0);
            return $b <=> $a;
        });

        return $items;
    }

    /**
     * @param array<string, mixed> $item
     * @return array<string, mixed>
     */
    private function selectListing(array $item): array
    {
        $listings = $item['offersV2']['listings'] ?? [];
        if (!is_array($listings) || $listings === []) {
            return [];
        }

        foreach ($listings as $listing) {
            if (is_array($listing) && !empty($listing['isBuyBoxWinner'])) {
                return $listing;
            }
        }

        return is_array($listings[0]) ? $listings[0] : [];
    }

    /**
     * @param array<string, mixed> $item
     * @return string[]
     */
    private function extractFeatures(array $item): array
    {
        $features = $item['itemInfo']['features']['displayValues'] ?? [];
        if (!is_array($features)) {
            return [];
        }

        $clean = [];
        foreach ($features as $feature) {
            if (is_string($feature) && trim($feature) !== '') {
                $clean[] = trim($feature);
            }
        }

        return $clean;
    }

    private function calculatePriceScore(?float $price, ?float $minPrice, ?float $maxPrice): float
    {
        if ($price === null || $minPrice === null || $maxPrice === null) {
            return 0.0;
        }

        if ($maxPrice === $minPrice) {
            return 100.0;
        }

        return round((($maxPrice - $price) / ($maxPrice - $minPrice)) * 100, 2);
    }

    private function calculateFeaturesScore(int $featureCount): float
    {
        return round(min(100, ($featureCount / 10) * 100), 2);
    }

    /**
     * @param array<string, mixed> $item
     */
    private function calculateQualityScore(array $item): float
    {
        $score = 20.0;

        if (!empty($item['buyBoxWinner'])) {
            $score += 25.0;
        }

        if (isset($item['savingsPercentage']) && is_numeric($item['savingsPercentage'])) {
            $score += min(20.0, ((float) $item['savingsPercentage']) * 0.6);
        }

        if (isset($item['websiteSalesRank']) && is_numeric($item['websiteSalesRank'])) {
            $rank = (int) $item['websiteSalesRank'];
            if ($rank > 0 && $rank <= 1000) {
                $score += 25.0;
            } elseif ($rank > 0 && $rank <= 10000) {
                $score += 18.0;
            } elseif ($rank > 0 && $rank <= 50000) {
                $score += 12.0;
            } elseif ($rank > 0 && $rank <= 100000) {
                $score += 6.0;
            }
        }

        if (isset($item['condition']) && strtoupper((string) $item['condition']) === 'NEW') {
            $score += 10.0;
        }

        return round(min(100.0, $score), 2);
    }

    /**
     * @param array<string, mixed> $item
     */
    private function buildSummary(array $item, float $finalScore): string
    {
        if ($finalScore >= 80) {
            return 'Excelente equilibrio entre precio, características y señales de calidad.';
        }

        if ($finalScore >= 65) {
            return 'Buena opción general para compra informada.';
        }

        if (($item['price'] ?? null) === null) {
            return 'No hay precio disponible; conviene revisar el detalle del producto.';
        }

        return 'Opción aceptable, pero hay alternativas mejor puntuadas.';
    }

    /**
     * @param array<string, float>|null $weights
     * @return array<string, float>
     */
    private function normalizeWeights(?array $weights): array
    {
        $defaults = [
            'price' => 0.45,
            'features' => 0.25,
            'quality' => 0.30,
        ];

        if ($weights === null || $weights === []) {
            return $defaults;
        }

        $merged = array_merge($defaults, $weights);
        $sum = $merged['price'] + $merged['features'] + $merged['quality'];

        if ($sum <= 0) {
            return $defaults;
        }

        return [
            'price' => round($merged['price'] / $sum, 4),
            'features' => round($merged['features'] / $sum, 4),
            'quality' => round($merged['quality'] / $sum, 4),
        ];
    }
}
