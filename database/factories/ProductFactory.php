<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        $image = File::factory()->create();

        return [
            'category_uuid' => $category->uuid,
            'uuid' => fake()->unique()->uuid(),
            'title' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 1, 10000),
            'description' => fake()->paragraph(),
            'metadata' => [
                'brand' => $brand->uuid,
                'image' => $image->uuid,
            ],
        ];
    }
}
