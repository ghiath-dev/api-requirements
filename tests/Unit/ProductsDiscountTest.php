<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProductsDiscountTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function products_in_insurance_category_have_30_percent_discount_in_final_price()
    {
        $product = Product::factory()
            ->forCategory([
                'name' => 'insurance',
            ])
            ->create([
                'price' => 10000,
            ]);

        $this->assertEquals(7000, $product->finalPrice);
    }

    /** @test */
    public function product_with_sky_000003_have_15_percent_discount_in_final_price()
    {
        $product = Product::factory()
            ->create([
                'sku' => '000003',
                'price' => 10000,
            ]);

        $this->assertEquals(8500, $product->finalPrice);
    }
    /** @test */
    public function products_in_insurance_category_have_30_percent_discount()
    {
        $product = Product::factory()
            ->forCategory([
                'name' => 'insurance',
            ])
            ->create([
                'price' => 10000,
            ]);

        $this->assertEquals('30%', $product->discountPercentage);
    }

    /** @test */
    public function product_with_sky_000003_have_15_percent_discount()
    {
        $product = Product::factory()
            ->create([
                'sku' => '000003',
            ]);

        $this->assertEquals('15%', $product->discountPercentage);
    }

    /** @test */
    public function product_with_sky_000003_and_category_insurance_category_have_45_percent_discount()
    {
        $product = Product::factory()
            ->forCategory([
                'name' => 'insurance',
            ])
            ->create([
                'sku' => '000003',
            ]);

        $this->assertEquals('45%', $product->discountPercentage);
    }

    /** @test */
    public function product_with_no_discount_final_original_are_same()
    {
        $product = Product::factory()
            ->create([
                'price' => 10000,
            ]);

        $this->assertEquals(10000, $product->finalPrice);
        $this->assertEquals(10000, $product->originalPrice);
    }

}
