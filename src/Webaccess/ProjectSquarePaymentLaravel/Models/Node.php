<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    protected $table = 'nodes';

    protected $fillable = [
        'id',
        'identifier',
        'available',
    ];
}