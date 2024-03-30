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
        Schema::create('rider_location_histories', function (Blueprint $table) {
            $table->foreignId("rider_id")->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->id();
            $table->string('service_name', 32);
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->dateTime('capture_time');

            $table->index(['latitude', 'longitude']);
            $table->index(['service_name', 'capture_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rider_location_histories');
    }
};
