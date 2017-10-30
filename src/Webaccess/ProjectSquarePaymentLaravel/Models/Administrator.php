<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Models;

use Laravel\Cashier\Billable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrator extends Authenticatable
{
    use Billable;

    protected $table = 'administrators';

    protected $fillable = [
        'email',
        'password',
        'last_name',
        'first_name',
        'billing_address',
        'zipcode',
        'city',
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    public function platform()
    {
        return $this->belongsTo('Webaccess\ProjectSquareLaravelPayment\Models\Platform');
    }

    public function taxPercentage() {
        return 20;
    }
}