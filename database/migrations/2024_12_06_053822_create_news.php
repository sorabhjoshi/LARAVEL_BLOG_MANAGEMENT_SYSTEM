<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->default('default-slug'); // Default slug
            $table->integer('user_id')->default(0);         // Default user ID
            $table->string('title')->default('Untitled');   // Default title
            $table->string('image')->default('default.jpg'); // Default image
            $table->string('authorname')->default('Anonymous'); // Default author name
            $table->string('description')->default('No description available.'); // Default description
            $table->integer('category')->default(1);        // Default category ID
            $table->enum('status', ['active', 'inactive'])->default('inactive'); // Default status
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
