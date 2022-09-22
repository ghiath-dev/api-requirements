<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProductsEndPointTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function correct_endpoint_returns_json()
    {
        $response = $this->get('/products')
            ->assertOk();

        $response->assertJson([
            'products' => []
        ]);
    }

    /** @test */
    public function correct_endpoint_returns_all_products()
    {
        $this->seed(ProductSeeder::class);

        $response = $this->get('/products')
            ->assertOk();

        $response->assertJsonCount(Product::count(), 'products');
    }

    /** @test */
    public function filter_products_via_category()
    {
        $this->seed(ProductSeeder::class);

        $response = $this->get('/products?category=insurance')
            ->assertOk();

        $this->assertEquals(
            Product::whereHas('category', fn($q) => $q->where('name', 'insurance'))->count(),
            count($response->json('products'))
        );
    }

    /** @test */
    public function products_return_with_specific_structure()
    {
        $this->seed(ProductSeeder::class);

        $response = $this->get('/products')
            ->assertOk();

        $first_products = $response->json('products')[0];

        $this->assertIsArray($first_products['price']);
        $this->assertArrayHasKey('final', $first_products['price']);
        $this->assertArrayHasKey('original', $first_products['price']);
        $this->assertArrayHasKey('discount_percentage', $first_products['price']);
        $this->assertArrayHasKey('currency', $first_products['price']);
        $this->assertArrayHasKey('category', $first_products);
        $this->assertArrayHasKey('sku', $first_products);
        $this->assertArrayHasKey('name', $first_products);
    }

}
