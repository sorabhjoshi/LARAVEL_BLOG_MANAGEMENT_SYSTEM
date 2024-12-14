<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 blog posts
        Blog::factory()->count(2)->create();
    }
}
