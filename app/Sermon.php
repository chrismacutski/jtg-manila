<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Sermon extends Model
{
    CONST SERMON_TYPE_DEFAULT = 'default';

    protected $table = 'sermons';

    protected $fillable = [
        'sermon_speaker_id', 'type', 'name', 'description', 'content', 'image_src', 'video_src', 'published_at', 'happened_at', 'file_src'
    ];

    protected $dates = [
        'published_at', 'happened_at'
    ];

    protected $appends = [
        'hash_id'
    ];

    public function getRouteKey()
    {
        return $this->hashId();
    }

    public function getRouteKeyName()
    {
        return 'hashId';
    }

    public static function findByHashId($hashId)
    {
        $id = Hashids::decode($hashId);

        if (!$id) {
            return null;
        }

        return static::find($id[0]);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function speaker()
    {
        return $this->belongsTo(SermonSpeaker::class, 'sermon_speaker_id');
    }

    public function notes()
    {
        return $this->hasMany(SermonNote::class);
    }

    public function hashId()
    {
        return Hashids::encode($this->id);
    }

    public function getHashIdAttribute()
    {
        return $this->hashId();
    }

    public function scopeIsNotPublished($query)
    {
        $query->whereNull('published_at');
    }

    public function scopeIsPublished($query)
    {
        $query->whereNotNull('published_at');
    }

    public static function addNew(array $params)
    {
        $attribs = $params;

        $attribs['type'] = Sermon::SERMON_TYPE_DEFAULT;

        return Sermon::create($attribs);
    }

}
