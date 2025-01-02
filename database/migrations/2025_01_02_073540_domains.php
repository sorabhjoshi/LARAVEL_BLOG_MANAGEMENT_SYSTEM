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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('domainname')->nullable();
            $table->string('companyname')->nullable();
            $table->longText('mail_header')->nullable();
            $table->longText('mail_footer')->nullable();
            $table->string('server_address')->nullable();
            $table->integer('port')->nullable();
            $table->string('authentication')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('tomail_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
