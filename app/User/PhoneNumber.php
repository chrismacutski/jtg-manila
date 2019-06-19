<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhoneNumber extends Model
{
    use SoftDeletes;

    protected $table = 'user_phone_numbers';

    protected $fillable = [
        'phone_number'
    ];

    protected $dates = ['deleted_at'];
}
