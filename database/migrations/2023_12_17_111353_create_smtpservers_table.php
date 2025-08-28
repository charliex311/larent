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
        Schema::create('smtpservers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('hostname')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->bigInteger('port')->nullable();
            $table->string('encryption')->nullable();
            $table->string('from_address')->nullable();
            $table->bigInteger('hourly_limit')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smtpservers');
    }
};
