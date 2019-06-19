<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailAddress extends Model
{
    use SoftDeletes;

    protected $table = 'user_email_addresses';

    protected $fillable = [
        'email_address'
    ];

    protected $dates = ['deleted_at'];
}
