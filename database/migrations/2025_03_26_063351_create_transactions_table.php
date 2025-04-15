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
            $table->unsignedInteger('ewallet_id');
            $table->string('type');
            $table->enum('method', ['system', 'bank_transfer', 'gopay', 'ovo', 'dana'])->default('system');
            $table->enum('operation', ['plus', 'minus']);
            $table->decimal('last_saldo', 15, 2);
            $table->decimal('amount', 15, 2);
            $table->text('description');
            $table->text('proof_url')->nullable();
            $table->unsignedInteger('bank_topup_id')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed'])->default('completed');
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
