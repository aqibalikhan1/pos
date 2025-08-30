<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'sku' => $this->faker->unique()->ean13,
            'description' => $this->faker->sentence,
            'purchase_price' => $this->faker->randomFloat(2, 5, 100),
            'trade_price' => $this->faker->randomFloat(2, 10, 200),
            'print_price' => $this->faker->randomFloat(2, 15, 300),
            'wholesale_price' => $this->faker->randomFloat(2, 8, 150),
            'stock_quantity' => $this->faker->numberBetween(0, 1000),
            'min_stock_level' => $this->faker->numberBetween(10, 50),
            'barcode' => $this->faker->ean13,
            'unit' => $this->faker->randomElement(['pcs', 'kg', 'box']),
            'is_active' => $this->faker->boolean(90),
            'packaging_type' => $this->faker->randomElement(['carton', 'bottle', 'bag']),
            'pieces_per_pack' => $this->faker->numberBetween(1, 100),
        ];
    }
}