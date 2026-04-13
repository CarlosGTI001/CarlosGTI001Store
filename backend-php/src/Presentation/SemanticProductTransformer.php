<?php

declare(strict_types=1);

namespace App\Presentation;

final class SemanticProductTransformer
{
    /**
     * @param array<int, array<string, mixed>> $items
     * @param array<string, mixed>|null $recommended
     * @param array<string, mixed> $ai
     * @param array<string, mixed> $context
     * @return array<string, mixed>
     */
    public function build(array $items, ?array $recommended, array $ai, array $context = []): array
    {
        $cards = [];
        $comparisonRows = [];
        foreach ($items as $index => $item) {
            $card = $this->buildCard($item, $index + 1);
            $cards[] = $card;
            $comparisonRows[] = $this->buildComparisonRow($item, $index + 1);
        }

        $recommendedCard = null;
        if ($recommended !== null) {
            $recommendedCard = $this->buildCard($recommended, 1);
        }

        return [
            'metadata' => [
                'returnedCount' => count($items),
                'recommendedAsin' => $recommended['asin'] ?? null,
                'provider' => $ai['provider'] ?? 'heuristic',
            ],
            'queryContext' => $context,
            'recommendedCard' => $recommendedCard,
            'cards' => $cards,
            'comparisonRows' => $comparisonRows,
            'aiNarrative' => [
                'summaryLong' => $ai['summaryLong'] ?? null,
                'recommendationLong' => $ai['recommendationLong'] ?? null,
                'recommendedAsin' => $ai['recommendedAsin'] ?? null,
                'recommendedAffiliateUrl' => $ai['recommendedAffiliateUrl'] ?? null,
                'productAnalyses' => $ai['productAnalyses'] ?? [],
            ],
        ];
    }

    /**
     * @param array<string, mixed> $item
     * @return array<string, mixed>
     */
    private function buildCard(array $item, int $position): array
    {
        $badges = [];
        if (!empty($item['buyBoxWinner'])) {
            $badges[] = 'Buy Box';
        }
        if (isset($item['savingsPercentage']) && is_numeric($item['savingsPercentage']) && (float) $item['savingsPercentage'] > 0) {
            $badges[] = 'Ahorro ' . (string) ((float) $item['savingsPercentage']) . '%';
        }
        if (isset($item['condition']) && is_string($item['condition']) && strtoupper($item['condition']) === 'NEW') {
            $badges[] = 'Nuevo';
        }

        return [
            'type' => 'product-card',
            'position' => $position,
            'asin' => $item['asin'] ?? null,
            'title' => $item['title'] ?? null,
            'image' => $item['images']['primary'] ?? null,
            'gallery' => $item['images']['gallery'] ?? [],
            'affiliateUrl' => $item['affiliateUrl'] ?? null,
            'price' => $item['pricing']['current'] ?? null,
            'listPrice' => $item['pricing']['list'] ?? null,
            'savings' => $item['pricing']['savings'] ?? null,
            'availability' => $item['availability'] ?? null,
            'merchantName' => $item['merchantName'] ?? null,
            'featuresTop' => array_slice(is_array($item['features'] ?? null) ? $item['features'] : [], 0, 4),
            'score' => $item['score']['final'] ?? null,
            'aiSummary' => $item['aiSummary'] ?? null,
            'badges' => $badges,
        ];
    }

    /**
     * @param array<string, mixed> $item
     * @return array<string, mixed>
     */
    private function buildComparisonRow(array $item, int $position): array
    {
        return [
            'position' => $position,
            'asin' => $item['asin'] ?? null,
            'title' => $item['title'] ?? null,
            'affiliateUrl' => $item['affiliateUrl'] ?? null,
            'priceDisplay' => $item['displayPrice'] ?? null,
            'priceAmount' => $item['price'] ?? null,
            'currency' => $item['currency'] ?? null,
            'savingsPercentage' => $item['savingsPercentage'] ?? null,
            'featuresCount' => $item['featuresCount'] ?? null,
            'condition' => $item['condition'] ?? null,
            'availability' => $item['availability'] ?? null,
            'buyBoxWinner' => $item['buyBoxWinner'] ?? false,
            'websiteSalesRank' => $item['websiteSalesRank'] ?? null,
            'scoreFinal' => $item['score']['final'] ?? null,
            'scoreBreakdown' => $item['score'] ?? null,
        ];
    }
}
