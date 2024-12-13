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
        Schema::create('companyaddress', function (Blueprint $table) {
            $table->id();
            $table->integer('companyid');
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('mobile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companyaddress');
    }
};
