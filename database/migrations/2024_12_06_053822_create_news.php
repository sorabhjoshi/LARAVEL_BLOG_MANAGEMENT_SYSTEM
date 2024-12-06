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
            $table->integer('userid');
            $table->string('title');
            $table->string('image');
            $table->string('authorname');
            $table->string('description');
            $table->string('category');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
