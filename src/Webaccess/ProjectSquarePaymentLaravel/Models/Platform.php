<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $table = 'platforms';

    protected $fillable = [
        'name',
        'slug',
        'users_count',
        'status',
        'balance',
        'platform_monthly_cost',
        'user_monthly_cost',
        'node_identifier'
    ];
}