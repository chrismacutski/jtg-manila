<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SermonSpeaker extends Model
{
    protected $table = 'sermon_speakers';

    protected $fillable = [
        'fullname', 'first_name', 'middle_name', 'last_name'
    ];

    protected static function boot()
    {
        parent::boot();

        self::created(function ($sermonSpeaker) {
            $sermonSpeaker->fullname = sprintf('%s %s %s', $sermonSpeaker->first_name, $sermonSpeaker->middle_name, $sermonSpeaker->last_name);
            $sermonSpeaker->save();
        });
    }

    public function sermons()
    {
        return $this->hasMany(Sermon::class);
    }

    public static function addNew(array $params)
    {
        return SermonSpeaker::firstOrCreate([
            'first_name' => $params['first_name'],
            'middle_name' => $params['middle_name'],
            'last_name' => $params['last_name'],
        ], [
            'is_guest' => $params['is_guest']
        ]);
    }
}
