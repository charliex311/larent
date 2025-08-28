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
        Schema::create('joblists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->timestamp('checkin')->nullable();
            $table->timestamp('checkout')->nullable();
            $table->timestamp('job_date')->nullable();
            $table->timestamp('cancel_date')->nullable();
            $table->double('total_task_hour', 8, 3)->nullable();
            $table->string('currency')->nullable();
            $table->double('hourly_rate', 8, 2)->default(0.00);
            $table->string('recurrence_type')->nullable();
            $table->string('job_status')->default('1');
            $table->json('journals')->nullable();
            $table->string('paid_status')->default('unpaid');
            $table->json('optional_product')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('secondarycontact_id')->nullable();
            $table->text('employee_message')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->text('job_address')->nullable();
            $table->integer('number_of_people')->nullable();
            $table->string('code_from_the_door')->nullable();
            $table->string('invoice_created')->default('no');
            $table->double('service_price', 8, 2)->default(0.00);
            $table->double('employee_hours', 8, 2)->default(0.00);
            $table->double('employee_price', 8, 2)->default(0.00);
            $table->double('customer_hours', 8, 2)->default(0.00);
            $table->double('customer_price', 8, 2)->default(0.00);
            $table->double('total_price', 8, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('joblists');
    }
};
