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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('payment_id', 20)->index();
            $table->string('order_id', 50)->unique();
            $table->string('ref_id', 100)->unique()->index();
            $table->unsignedBigInteger('nominal')->index();
            $table->unsignedBigInteger('fee')->index();
            $table->unsignedBigInteger('total_payment')->index();
            $table->string('va_number')->nullable();
            $table->string('expired', 20)->nullable();
            $table->string('status', 20)->nullable();
            $table->string('callback_respon')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
