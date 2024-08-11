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
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('provider', 20)->index();
            $table->string('key')->unique()->index();
            $table->string('secret')->nullable();
            $table->string('username', 100)->nullable();
            $table->string('ip_address', 20)->nullable();
            $table->string('api_url')->nullable();
            $table->string('callback_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }
};
