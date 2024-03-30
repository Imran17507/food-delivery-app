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
        Schema::create('riders', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 16);
            $table->string('last_name', 16)->nullable();

            $table->string('email_address', 64)->unique();
            $table->string('contact_no', 32)->unique();
            $table->text('present_address');
            $table->text('permanent_address');

            $table->string('nid_no', 32);
            $table->string('passport_no', 32)->nullable();

            $table->string('emergency_contact_persons_name', 32);
            $table->string('emergency_contact_persons_contact_no', 32);

            $table->timestamps();
            $table->string('created_by', 32)->nullable();
            $table->string('updated_by', 32)->nullable();
            $table->softDeletes();
            $table->string('deleted_by', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riders');
    }
};
