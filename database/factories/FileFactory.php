<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileTypes = ['.png', '.jpg', '.bmp'];

        $fileTypeKey = array_rand($fileTypes);
        $fileType = $fileTypes[$fileTypeKey];

        $fileName = fake()->word() . $fileType;
        $filePath = Storage::disk('public')->path($fileName);

        return [
            'uuid' => fake()->unique()->uuid(),
            'name' => fake()->sentence(),
            'path' => $filePath,
            'size' => fake()->randomNumber(5),
            'type' => $fileType,
        ];
    }
}
