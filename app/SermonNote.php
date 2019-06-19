<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SermonNote extends Model
{
    protected $table = 'sermon_notes';

    protected $fillable = ['sermon_id', 'body'];

//    public function sermon()
//    {
//        return $this->belongsTo(Sermon::class);
//    }
}
