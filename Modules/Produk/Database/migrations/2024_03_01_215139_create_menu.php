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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->string('screen_name', 100)->nullable();
            $table->string('type', 50)->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('ready')->default(true);
            $table->string('position', 20)->nullable();
            $table->string('icon', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
