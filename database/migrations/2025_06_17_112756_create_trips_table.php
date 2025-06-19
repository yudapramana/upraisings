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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();

            $table->string('trip_transaction_id')->unique()->nullable();
            
            // Informasi lokasi
            $table->string('geton_location')->nullable();
            $table->string('getoff_location')->nullable();
            
            // Geolokasi dalam format lat,long (bisa juga json atau point jika pakai extension/spatial)
            $table->decimal('geton_latitude', 10, 7)->nullable();
            $table->decimal('geton_longitude', 10, 7)->nullable();
            $table->text('geton_geolocation')->nullable();
            $table->decimal('getoff_latitude', 10, 7)->nullable();
            $table->decimal('getoff_longitude', 10, 7)->nullable();
            $table->text('getoff_geolocation')->nullable();
            
             // Informasi pendukung
            $table->timestamp('pickup_time')->nullable();
            $table->timestamp('arrival_time')->nullable();

            $table->string('license_plate')->nullable();
            $table->string('driver_name')->nullable();
            $table->text('vehicle_photo')->nullable();
            $table->string('route_number')->nullable();       // Misal: 201, 301
            $table->string('route_name')->nullable();                    // Misal: M. Yamin - Siteba
            $table->string('color')->nullable();  

            $table->decimal('distance', 7,2)->nullable();
            $table->decimal('trip_fare', 15, 2)->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // penumpang (user yang memesan trip)
            $table->unsignedBigInteger('partner_id'); // penumpang (user yang memesan trip)

            $table->enum('status', ['ongoing', 'completed', 'cancelled'])->default('ongoing');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
