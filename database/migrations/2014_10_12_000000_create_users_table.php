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
            $table->string('mobile_phone')->unique();
            $table->string('email')->nullable();
            $table->string('city_register')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['admin', 'approval', 'partner', 'customer', 'director'])->default('customer');
            $table->string('password');
            // Informasi rekening untuk withdraw
            $table->string('bank_name')->nullable(); // Nama bank (BCA, Mandiri, dll.)
            $table->string('account_number')->nullable(); // Nomor rekening bank/e-wallet
            $table->string('account_holder')->nullable(); // Nama pemilik rekening
            $table->enum('account_verification', ['pending', 'verified', 'rejected'])->default('verified'); // Added verification status column
            $table->enum('account_status', ['active', 'inactive', 'suspended'])->default('active');

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
