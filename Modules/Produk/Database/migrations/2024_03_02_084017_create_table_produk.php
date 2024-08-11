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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->nullable()->index();
            $table->string('name', 100)->index();
            $table->longText('description')->nullable();
            $table->string('category', 50)->nullable();
            $table->string('type', 100)->nullable();
            $table->integer('price')->index();
            $table->integer('margin')->default(0);
            $table->string('discount', 10)->nullable();
            $table->integer('sale_price');
            $table->string('status', 20)->nullable();
            $table->boolean('is_promo')->default(false);
            $table->boolean('prabayar')->default(true);
            $table->string('icon', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
