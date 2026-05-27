<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $cost = fake()->randomFloat(2, 5, 300);

        return [
            'category_id' => Category::factory(),
            'supplier_id' => Supplier::factory(),
            'name' => fake()->words(3, true),
            'sku' => strtoupper(fake()->bothify('SKU-####??')),
            'description' => fake()->sentence(),
            'purchase_price' => $cost,
            'selling_price' => $cost * fake()->randomFloat(2, 1.1, 1.9),
            'reorder_level' => fake()->numberBetween(5, 30),
            'current_stock' => fake()->numberBetween(0, 400),
            'is_active' => true,
        ];
    }
}
