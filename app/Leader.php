<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    protected $table = 'leaders';

    protected $fillable = [
        'first_name', 'middle_name', 'last_name',
        'position', 'brief_background', 'image_src'
    ];
}
