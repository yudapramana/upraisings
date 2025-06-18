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
        Schema::create('angkot_types', function (Blueprint $table) {
            $table->id();
            $table->string('route_number')->unique();       // Misal: 201, 301
            $table->string('route_name');                   // Misal: M. Yamin - Siteba
            $table->string('color')->nullable();            // Opsional: bisa diisi warna khas trayek (merah/biru)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angkot_types');
    }
};
