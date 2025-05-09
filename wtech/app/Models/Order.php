<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'status',
        'first_name',
        'last_name',
        'phone',
        'email',
        'street',
        'city',
        'postal_code',
        'created_at',
        'pay',
        'delivery',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];
}
