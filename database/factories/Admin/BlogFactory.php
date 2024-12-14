<?php
namespace Database\Factories\Admin;
namespace Database\Factories\Admin;

use App\Models\Admin\Blog;
use App\Models\User;  // Assuming User model exists
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Blog>
 */
class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(),
            'title' => $this->faker->sentence(),
            'user_id' => function () {
                return DB::table('users')->inRandomOrder()->value('id');
            },
            'image' => 'images/default.jpg',
            'authorname' => $this->faker->name(),
            'description' => $this->faker->paragraph(3),
            'category' => 1,
        ];
    }
}
