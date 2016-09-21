<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
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

    public function platform()
    {
        return $this->belongsTo('Webaccess\ProjectSquareLaravelPayment\Models\Platform');
    }
}