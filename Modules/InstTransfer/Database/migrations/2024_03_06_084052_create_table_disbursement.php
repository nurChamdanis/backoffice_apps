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
        Schema::create('disbursement', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('ref_id')->unique();
            $table->char('nominal');
            $table->string('bank_code');
            $table->string('account_number');
            $table->string('account_holder_name');
            $table->string('disbursement_description');
            $table->string('status')->default('PENDING');
            $table->json('respon_json')->nullable();
            $table->json('callback_json')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disbursement');
    }
};
