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
            $table->string('slug');
            $table->integer('user_id');
            $table->string('title');
            $table->string('image');
            $table->string('authorname');
            $table->string('domain')->nullable();
            $table->longText('description');
            $table->string('category');
            $table->integer('language')->nullable();
            $table->integer('country');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
