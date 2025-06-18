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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('user_id')->nullable();
             // Vehicle details
            $table->unsignedInteger('angkot_type_id')->nullable();
            $table->text('vehicle_photo')->nullable(); // Foto Angkot (can store filename or URL)
            $table->string('license_plate');            // Plat Angkot
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending'); // Status verifikasi kendaraan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
