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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('secondarycontact_id')->nullable();
            $table->string('title')->nullable();
            $table->string('unit')->nullable();
            $table->double('price', 8, 3)->default(0);
            $table->string('currency')->nullable();
            $table->double('tax', 8, 3)->default(0);
            $table->double('tax_value', 8, 3)->default(0);
            $table->double('total_price', 8, 3)->default(0);
            $table->string('street')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('box_code')->nullable();
            $table->string('client_code')->nullable();
            $table->string('deposit_code')->nullable();
            $table->string('access_phone')->nullable();
            $table->string('floor_number')->nullable();
            $table->string('house_number')->nullable();
            $table->integer('status')->default(3);
            $table->string('square_weather')->nullable();
            $table->string('room')->nullable();
            $table->string('maximal_capacity_place')->nullable();
            $table->string('wifi_name')->nullable();
            $table->string('wifi_password')->nullable();
            $table->string('balcony')->nullable();
            $table->string('regularity')->default('regular');
            $table->string('speciality')->default('normal');
            $table->boolean('is_cleaning')->default(0);
            $table->json('files')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
