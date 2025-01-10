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
        Schema::create('news_has_approval', function (Blueprint $table) {
            $table->id();
            $table->integer('news_id');
            $table->integer('designation_id');
            $table->integer('user_id');
            $table->integer('approval');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_has_approval');
    }
};
