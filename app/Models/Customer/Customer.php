<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer  extends Authenticatable
{
    use HasFactory;
    protected $guard = 'customer';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'customer',
        'keywords',

    ];

    protected $hidden = [
        'password',

    ];
}
