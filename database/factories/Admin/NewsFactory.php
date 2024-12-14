<?php

namespace Database\Factories\Admin;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(),
            'title' => $this->faker->sentence(),
            'user_id' => 1, 
            'image' => 'images/default.jpg', 
            'authorname' => $this->faker->name(),
            // 'email' => $this->faker->unique()->email(),
            'description' => $this->faker->paragraph(3),
            'category' => 1, 
        ];
    }
}
