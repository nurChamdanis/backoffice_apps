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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('produk_id', 20)->index();
            $table->string('ref_id', 50)->unique();
            $table->integer('invoice')->unique();
            $table->string('tujuan', 100)->nullable();
            $table->string('status', 20)->nullable();
            $table->string('sn')->nullable();
            $table->string('harga', 20)->nullable();
            $table->string('margin', 20)->nullable();
            $table->longText('desc')->nullable();
            $table->string('flag', 20)->nullable();
            $table->string('tipe', 20)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
