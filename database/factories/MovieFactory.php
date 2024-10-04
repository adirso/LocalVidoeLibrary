<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    public function definition()
    {
        return [
            'path' => $this->faker->url,    // Fake path
            'name' => $this->faker->sentence,   // Fake movie name
            'description' => $this->faker->paragraph,  // Fake description
            'photo' => $this->faker->imageUrl,  // Fake photo URL
            'progress_time' => $this->faker->numberBetween(0, 10000),  // Fake progress time in seconds
            'category_id' => \App\Models\Category::factory(),  // Reference to category
        ];
    }

}
