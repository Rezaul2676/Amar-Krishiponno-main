<?php

namespace Tests\Unit;

use App\Services\ProductRecommendationService;
use PHPUnit\Framework\TestCase;

class ProductRecommendationServiceTest extends TestCase
{
    public function test_it_recommends_products_from_matching_categories_and_excludes_interacted_items(): void
    {
        $service = new ProductRecommendationService();

        $products = collect([
            (object) ['id' => 1, 'category_id' => 10, 'product_name' => 'Rice'],
            (object) ['id' => 2, 'category_id' => 10, 'product_name' => 'Wheat'],
            (object) ['id' => 3, 'category_id' => 20, 'product_name' => 'Tomato'],
            (object) ['id' => 4, 'category_id' => 10, 'product_name' => 'Dal'],
        ]);

        $recommendations = $service->recommend($products, [1, 3], [10]);

        $this->assertSame([2, 4], $recommendations->pluck('id')->all());
    }

    public function test_it_falls_back_to_available_products_when_no_preferences_exist(): void
    {
        $service = new ProductRecommendationService();

        $products = collect([
            (object) ['id' => 1, 'category_id' => 10, 'product_name' => 'Rice'],
            (object) ['id' => 2, 'category_id' => 11, 'product_name' => 'Banana'],
        ]);

        $recommendations = $service->recommend($products, [], []);

        $this->assertSame([1, 2], $recommendations->pluck('id')->all());
    }
}
