<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableForLoan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->double('amount', 12, 2);
            $table->string('currency')->default('USD');
            $table->integer('duration')->comment("Number of week");
            $table->integer('repayment_frequency')->comment("Number of week to make repayment");
            $table->float('interest_rate', 8, 2)->comment("Intrest Rate In %.");
            $table->double('amount_with_intrest', 12, 2);
            $table->double('weekly_pay_amount', 12, 2);
            $table->date('next_payment_date')->nullable();
            $table->json('payment_history')->nullable();
            $table->enum('status', ['request', 'approved', 'decline', 'completed'])->default('request');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Loans');
    }
}
