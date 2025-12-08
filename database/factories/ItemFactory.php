<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'item' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(10000, 500000),
            'stock' => $this->faker->numberBetween(0, 50),
            'path' => null,
            'availability' => 'in_stock',
            'is_active' => true,
        ];
    }
}
