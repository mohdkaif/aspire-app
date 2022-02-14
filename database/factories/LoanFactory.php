<?php

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;


class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    // public function definition()
    // {
        $factory->define(Loan::class, function (Faker $faker) {
            return [
                'amount' => $faker->amount,
                'duration' => $faker->duration,
                'user_id' => $faker->user_id,
                'repayment_frequency' => $faker->repayment_frequency,
                'interest_rate' => $faker->interest_rate,
                'payment_history' => $faker->payment_history,
                'amount_with_intrest' => $faker->amount_with_intrest,
                'weekly_pay_amount' => $faker->weekly_pay_amount,
                'next_payment_date' => $faker->next_payment_date,
            ];
        });
    //}
}
