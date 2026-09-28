<?php

namespace App\Services;

use Illuminate\Support\Collection;

class ProductRecommendationService
{
    public function recommend(Collection $products, array $interactedProductIds = [], array $preferredCategoryIds = []): Collection
    {
        if ($products->isEmpty()) {
            return collect();
        }

        $eligibleProducts = $products->filter(function ($product) use ($interactedProductIds) {
            return !in_array($product->id, $interactedProductIds, true);
        });

        if ($eligibleProducts->isEmpty()) {
            return collect();
        }

        if (!empty($preferredCategoryIds)) {
            $preferred = $eligibleProducts->filter(function ($product) use ($preferredCategoryIds) {
                return in_array($product->category_id, $preferredCategoryIds, true);
            });

            if ($preferred->isNotEmpty()) {
                return $preferred->take(4);
            }
        }

        return $eligibleProducts->take(4);
    }
}
