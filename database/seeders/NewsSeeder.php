<?php

namespace Database\Seeders;

use App\Models\Admin\News;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          News::factory()->count(10)->create();
    }
    
}
