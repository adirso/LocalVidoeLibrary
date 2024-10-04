<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Series>
 */
class SeriesFactory extends Factory
{
    public function definition()
    {
        return [
            'path' => $this->faker->url,    // Fake path
            'name' => $this->faker->sentence,   // Fake series name
            'description' => $this->faker->paragraph,  // Fake description
            'photo' => $this->faker->imageUrl,  // Fake photo URL
            'season' => $this->faker->numberBetween(1, 10),   // Fake season number
            'episode' => $this->faker->numberBetween(1, 24),  // Fake episode number
            'progress_time' => $this->faker->numberBetween(0, 10000),  // Fake progress time in seconds
            'category_id' => \App\Models\Category::factory(),  // Reference to category
        ];
    }

}

