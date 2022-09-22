<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = json_decode(file_get_contents(resource_path('data/products.json')), true)['products'];

        foreach ($products as $product) {
            $category = Category::firstOrCreate([
                'name' => $product['category']
            ]);

            unset($product['category']);

            Product::create(array_merge($product, [
                'category_id' => $category->id,
            ]));
        }
    }
}
