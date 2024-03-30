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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();

            $table->string('title', 64);
            $table->string('email_address', 64)->unique();
            $table->string('contact_no', 32)->unique();
            $table->text('address');

            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);

            $table->string('owners_name', 32)->nullable();
            $table->string('owners_email_address', 64)->unique();
            $table->string('owners_contact_no', 32);
            $table->text('owners_present_address');

            $table->timestamps();
            $table->string('created_by', 32)->nullable();
            $table->string('updated_by', 32)->nullable();
            $table->softDeletes();
            $table->string('deleted_by', 32)->nullable();

            $table->index(['latitude', 'longitude']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
