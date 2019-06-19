<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Series extends Model
{
    protected $table = 'series';

    protected $fillable = [
        'name', 'description', 'image_src', 'image_thumbnail_src', 'published_at', 'happened_at'
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

    public function sermons()
    {
        return $this->hasMany(Sermon::class);
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
        return Series::create($params);
    }

    public function publish()
    {
        $this->published_at = Carbon::now();
        $this->save();
    }

    public function attachSermon(array $params)
    {
        $attribs = $params;

        $attribs['name'] = $this->name . ' | ' . $params['name'];
        $attribs['type'] = Sermon::SERMON_TYPE_DEFAULT;

        return $this->sermons()->firstOrCreate($attribs);
    }
}
