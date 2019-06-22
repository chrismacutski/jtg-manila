<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table = 'visitors';

    protected $fillable = [
        'first_name', 'last_name', 'phone_number', 'email_address',
        'visiting_at', 'notified_at', 'followed_up_at'
    ];

    protected $dates = [
        'visiting_at', 'notified_at', 'followed_up_at'
    ];

    public static function addNew(array $params)
    {
        $attribs = $params;

        return Visitor::create($attribs);
    }
}
