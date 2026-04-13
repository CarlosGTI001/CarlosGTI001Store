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
            $savingData = $listing['price']['savings']['money'] ?? null;
            $savingBasisData = $listing['price']['savingBasis']['money'] ?? null;
            $images = $this->extractImages($item);
            $salesRanks = $this->extractSalesRanks($item);
            $merchantName = isset($listing['merchantInfo']['name']) && is_string($listing['merchantInfo']['name'])
                ? trim($listing['merchantInfo']['name'])
                : null;
            $currency = $priceData['currency'] ?? $savingData['currency'] ?? $savingBasisData['currency'] ?? null;
            $priceAmount = isset($priceData['amount']) && is_numeric($priceData['amount'])
                ? (float) $priceData['amount']
                : null;
            $savingsAmount = isset($savingData['amount']) && is_numeric($savingData['amount'])
                ? (float) $savingData['amount']
                : null;
            $listPriceAmount = isset($savingBasisData['amount']) && is_numeric($savingBasisData['amount'])
                ? (float) $savingBasisData['amount']
                : null;
            $websiteSalesRank = $salesRanks['websiteSalesRank'] ?? null;

            $normalized[] = [
                'asin' => (string) ($item['asin'] ?? ''),
                'title' => $item['itemInfo']['title']['displayValue'] ?? null,
                'affiliateUrl' => $item['detailPageURL'] ?? null,
                'imageUrl' => $images['primary']['url'] ?? null,
                'images' => $images,
                'price' => $priceAmount,
                'currency' => $currency,
                'displayPrice' => $priceData['displayAmount'] ?? null,
                'features' => $features,
                'featuresCount' => count($features),
                'buyBoxWinner' => (bool) ($listing['isBuyBoxWinner'] ?? false),
                'savingsPercentage' => isset($listing['price']['savings']['percentage'])
                    ? (float) $listing['price']['savings']['percentage']
                    : null,
                'savingsAmount' => $savingsAmount,
                'listPrice' => $listPriceAmount,
                'condition' => $listing['condition']['value'] ?? null,
                'websiteSalesRank' => $websiteSalesRank,
                'availability' => $listing['availability']['type'] ?? null,
                'merchantName' => $merchantName,
                'categoryHints' => $this->extractCategoryHints($item),
                'salesRanks' => $salesRanks,
                'pricing' => [
                    'current' => [
                        'amount' => $priceAmount,
                        'currency' => $currency,
                        'display' => $priceData['displayAmount'] ?? null,
                    ],
                    'list' => [
                        'amount' => $listPriceAmount,
                        'currency' => $currency,
                        'display' => $savingBasisData['displayAmount'] ?? null,
                    ],
                    'savings' => [
                        'amount' => $savingsAmount,
                        'currency' => $currency,
                        'display' => $savingData['displayAmount'] ?? null,
                        'percentage' => isset($listing['price']['savings']['percentage'])
                            ? (float) $listing['price']['savings']['percentage']
                            : null,
                    ],
                ],
                'qualitySignals' => [
                    'buyBoxWinner' => (bool) ($listing['isBuyBoxWinner'] ?? false),
                    'websiteSalesRank' => $websiteSalesRank,
                    'bestBrowseNodeSalesRank' => $salesRanks['bestBrowseNodeSalesRank'] ?? null,
                    'availability' => $listing['availability']['type'] ?? null,
                    'condition' => $listing['condition']['value'] ?? null,
                ],
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

    /**
     * @param array<string, mixed> $item
     * @return array<string, mixed>
     */
    private function extractImages(array $item): array
    {
        $small = $this->mapImage($item['images']['primary']['small'] ?? null);
        $medium = $this->mapImage($item['images']['primary']['medium'] ?? null);
        $large = $this->mapImage($item['images']['primary']['large'] ?? null);
        $hiRes = $this->mapImage($item['images']['primary']['hiRes'] ?? null);
        $primary = $large ?? $medium ?? $small ?? $hiRes;

        $variants = [];
        $variantNodes = $item['images']['variants'] ?? [];
        if (is_array($variantNodes)) {
            foreach ($variantNodes as $variantNode) {
                if (!is_array($variantNode)) {
                    continue;
                }

                $variant = $this->mapImage($variantNode['large'] ?? null)
                    ?? $this->mapImage($variantNode['medium'] ?? null)
                    ?? $this->mapImage($variantNode['small'] ?? null)
                    ?? $this->mapImage($variantNode['hiRes'] ?? null);
                if ($variant !== null) {
                    $variants[] = $variant;
                }
            }
        }

        return [
            'primary' => $primary,
            'sizes' => [
                'small' => $small,
                'medium' => $medium,
                'large' => $large,
                'hiRes' => $hiRes,
            ],
            'variants' => $variants,
            'gallery' => $primary !== null ? array_values(array_filter(array_merge([$primary], $variants))) : $variants,
        ];
    }

    /**
     * @param mixed $imageNode
     * @return array<string, mixed>|null
     */
    private function mapImage(mixed $imageNode): ?array
    {
        if (!is_array($imageNode)) {
            return null;
        }

        $url = isset($imageNode['url']) && is_string($imageNode['url']) ? trim($imageNode['url']) : '';
        if ($url === '') {
            return null;
        }

        return [
            'url' => $url,
            'width' => isset($imageNode['width']) && is_numeric($imageNode['width']) ? (int) $imageNode['width'] : null,
            'height' => isset($imageNode['height']) && is_numeric($imageNode['height']) ? (int) $imageNode['height'] : null,
        ];
    }

    /**
     * @param array<string, mixed> $item
     * @return array<int, array<string, mixed>>
     */
    private function extractCategoryHints(array $item): array
    {
        $result = [];
        $browseNodes = $item['browseNodeInfo']['browseNodes'] ?? [];
        if (!is_array($browseNodes)) {
            return $result;
        }

        foreach ($browseNodes as $browseNode) {
            if (!is_array($browseNode)) {
                continue;
            }

            $name = null;
            if (isset($browseNode['contextFreeName']) && is_string($browseNode['contextFreeName'])) {
                $name = trim($browseNode['contextFreeName']);
            } elseif (isset($browseNode['displayName']) && is_string($browseNode['displayName'])) {
                $name = trim($browseNode['displayName']);
            }

            if ($name === null || $name === '') {
                continue;
            }

            $result[] = [
                'id' => isset($browseNode['id']) ? (string) $browseNode['id'] : null,
                'name' => $name,
                'salesRank' => isset($browseNode['salesRank']) && is_numeric($browseNode['salesRank'])
                    ? (int) $browseNode['salesRank']
                    : null,
            ];

            if (count($result) >= 5) {
                break;
            }
        }

        return $result;
    }

    /**
     * @param array<string, mixed> $item
     * @return array<string, int|null>
     */
    private function extractSalesRanks(array $item): array
    {
        $websiteSalesRank = isset($item['browseNodeInfo']['websiteSalesRank']['salesRank'])
            && is_numeric($item['browseNodeInfo']['websiteSalesRank']['salesRank'])
            ? (int) $item['browseNodeInfo']['websiteSalesRank']['salesRank']
            : null;

        $bestBrowseNodeSalesRank = null;
        $browseNodes = $item['browseNodeInfo']['browseNodes'] ?? [];
        if (is_array($browseNodes)) {
            foreach ($browseNodes as $browseNode) {
                if (!is_array($browseNode) || !isset($browseNode['salesRank']) || !is_numeric($browseNode['salesRank'])) {
                    continue;
                }

                $salesRank = (int) $browseNode['salesRank'];
                if ($salesRank <= 0) {
                    continue;
                }

                if ($bestBrowseNodeSalesRank === null || $salesRank < $bestBrowseNodeSalesRank) {
                    $bestBrowseNodeSalesRank = $salesRank;
                }
            }
        }

        return [
            'websiteSalesRank' => $websiteSalesRank,
            'bestBrowseNodeSalesRank' => $bestBrowseNodeSalesRank,
        ];
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
