<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'identifier',
        'amount',
        'payment_mean',
        'status',
        'bank_code',
    ];
}