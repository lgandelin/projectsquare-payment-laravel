<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const TRANSACTION_STATUS_IN_PROGRESS = 1;
    const TRANSACTION_STATUS_VALIDATED = 2;

    protected $table = 'transactions';

    protected $fillable = [
        'identifier',
        'amount',
        'payment_mean',
        'status',
        'bank_code',
    ];
}