<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = [
        'type', 'first_name', 'last_name', 'phone_number', 'email_address',
        'contacted_at', 'details'
    ];

    public static function addNew(array $params)
    {
        return Contact::create($params);
    }
}
