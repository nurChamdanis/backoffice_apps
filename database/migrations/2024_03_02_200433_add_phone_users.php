<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->after('id')->default(0);
            $table->string('google_id', 100)->after('plan_id')->unique()->nullable();
            $table->string('code', 50)->after('plan_id')->nullable()->unique()->index();
            $table->string('ref_code', 50)->after('code')->default('BP-0000')->index();
            $table->unsignedBigInteger('saldo')->after('last_name')->default(0);
            $table->unsignedBigInteger('markup')->after('saldo')->default(0);
            $table->string('phone', 20)->after('email')->nullable()->unique()->index();
            $table->string('pin')->after('password')->default(Hash::make('000000'));
            $table->string('verification_code', 10)->after('pin')->unique()->nullable();
            $table->string('status', 20)->after('activated')->default('ACTIVE');
            $table->boolean('is_kyc')->after('status')->default(false);
            $table->boolean('is_outlet')->after('is_kyc')->default(false);
            $table->longText('fcm')->after('token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
