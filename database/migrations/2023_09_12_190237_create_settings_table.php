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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('company')->nullable();
            $table->string('company_email')->nullable();
            $table->string('website')->nullable();
            $table->string('company_address')->nullable();
            $table->string('invoice_prefix')->nullable();
            $table->bigInteger('invoice_number')->default(0);
            $table->text('invoice_text')->nullable();
            $table->string('currency')->nullable();
            $table->double('hourly_rate', 8, 2)->default(0.00);
            $table->text('bank')->nullable();
            $table->text('bic')->nullable();
            $table->text('iban')->nullable();
            $table->text('ust_idnr')->nullable();
            $table->text('business_number')->nullable();
            $table->text('fiscal_number')->nullable();
            $table->text('note_for_email')->nullable();
            $table->string('email_premissions')->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
