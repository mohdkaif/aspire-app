<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'amount',
        'duration',
        'user_id',
        'repayment_frequency',
        'interest_rate',
        'payment_history',
        'amount_with_intrest',
        'weekly_pay_amount',
        'next_payment_date',
    ];
    protected $casts = [
        'payment_history' => 'array'
    ];
}
