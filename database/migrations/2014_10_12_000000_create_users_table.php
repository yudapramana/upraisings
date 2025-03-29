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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile_phone')->nullable();
            $table->string('email')->unique();
            $table->string('city_register')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['admin', 'approval', 'partner', 'customer'])->default('customer');
            $table->string('password');
            // Informasi rekening untuk withdraw
            $table->string('bank_name')->nullable(); // Nama bank (BCA, Mandiri, dll.)
            $table->string('account_number')->nullable(); // Nomor rekening bank/e-wallet
            $table->string('account_holder')->nullable(); // Nama pemilik rekening
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
