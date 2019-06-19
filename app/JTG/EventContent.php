<?php

namespace App\JTG;

use Illuminate\Database\Eloquent\Model;

class EventContent extends Model
{
    // should be a new database table that implements caching
    CONST TYPE_HEADER_TEXT = 'header_text';
    CONST TYPE_TEXT_CONTENT = 'text_content';
    CONST TYPE_VIDEO_URL = 'video_url';
    CONST TYPE_SLIDER_IMAGES = 'slider_images';

    protected $table = 'jtg_event_contents';

    protected $casts = [
        'slider_images' => 'array'
    ];

    protected $fillable = [
        'event_id', 'type', 'header_text', 'text_content',
        'video_url', 'slider_images'
    ];
}
