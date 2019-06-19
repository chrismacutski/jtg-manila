<?php

namespace App\JTG;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Vinkla\Hashids\Facades\Hashids;

class Event extends Model
{
    CONST EVENT_TYPE_DEFAULT = 'default';

    protected $table = 'jtg_events';

    protected $fillable = [
        'type', 'name', 'description', 'address',
        'image_src', 'image_thumbnail_src', 'amount',
        'starting_at', 'ending_at'
    ];

    protected $dates = [
        'starting_at', 'ending_at', 'published_at'
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

    public function attendees()
    {
        return $this->hasMany(EventAttendee::class);
    }

    public function contents()
    {
        return $this->hasMany(EventContent::class);
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

    public function scopeActive($query)
    {
        $query->where('ending_at', '>=', Carbon::now());
    }

    public function scopeOnGoing($query)
    {
        $query->where('starting_at', '<=', Carbon::now())
            ->where('ending_at', '>=', Carbon::now());
    }

    public function scopeUpcoming($query)
    {
        $query->where('starting_at', '>', Carbon::now());
    }

    public static function addNew(array $params)
    {
        $attribs = $params;

        $attribs['type'] = Event::EVENT_TYPE_DEFAULT;

        return Event::create($attribs);
    }

    public function attachSliderImages($sliderImages)
    {
        $slider_image_paths = [];
        foreach ($sliderImages as $slider_image) {
            /** @var UploadedFile $slider_image */
            $public_path = $slider_image->storePubliclyAs('events/' . $this->id . '/slider-images', $slider_image->getClientOriginalName(), 'public');

            $slider_image_paths[] = $public_path;
        }

        if (count($slider_image_paths) > 0) {
            $this->contents()->create([
                'type' => EventContent::TYPE_SLIDER_IMAGES,
                'slider_images' => $slider_image_paths
            ]);
        }
    }

    public function updateSliderImages($sliderImages)
    {
        $slider_image_paths = [];
        foreach ($sliderImages as $slider_image) {
            /** @var UploadedFile $slider_image */
            $public_path = $slider_image->storePubliclyAs('events/' . $this->id . '/slider-images', $slider_image->getClientOriginalName(), 'public');

            $slider_image_paths[] = $public_path;
        }

        if (count($slider_image_paths) > 0) {
            $this->contents()
                ->updateOrCreate(
                    [
                        'type' => EventContent::TYPE_SLIDER_IMAGES,
                    ], [
                        'slider_images' => $slider_image_paths
                    ]);
        }
    }


    public function attachHeaderText($headerText)
    {
        if ($headerText != '') {
            $this->contents()->create([
                'type' => EventContent::TYPE_HEADER_TEXT,
                'header_text' => $headerText
            ]);
        }
    }

    public function updateHeaderText($headerText)
    {
        if ($headerText != '') {
            $this->contents()
                ->updateOrCreate(
                    [
                        'type' => EventContent::TYPE_HEADER_TEXT,
                    ], [
                        'header_text' => $headerText
                    ]);
        }
    }

    public function attachVideoUrl($videoUrl)
    {
        if ($videoUrl != '') {
            $this->contents()->create([
                'type' => EventContent::TYPE_VIDEO_URL,
                'video_url' => $videoUrl
            ]);
        }
    }

    public function updateVideoUrl($videoUrl)
    {
        if ($videoUrl != '') {
            $this->contents()
                ->updateOrCreate(
                    [
                        'type' => EventContent::TYPE_VIDEO_URL,
                    ], [
                        'video_url' => $videoUrl
                    ]);
        }
    }


    public function attachTextContent($textContent)
    {
        if ($textContent != '') {
            $this->contents()->create([
                'type' => EventContent::TYPE_TEXT_CONTENT,
                'text_content' => $textContent
            ]);
        }
    }

    public function updateTextContent($textContent)
    {
        if ($textContent != '') {
            $this->contents()
                ->updateOrCreate(
                    [
                        'type' => EventContent::TYPE_TEXT_CONTENT,
                    ], [
                        'text_content' => $textContent
                    ]);
        }
    }

    public function publish()
    {
        Event::forgetCachedEvents();

        $this->published_at = Carbon::now();
        $this->save();

        Event::getCachedEvents();
    }

    public function signUpAttendee($userId = NULL, $params = NULL)
    {
        if (is_null($userId) && is_null($params)) {
            throw new \Exception("Could not sign up event attendee to Event ID "  . $this->id . ", empty parameters");
        }

        $isExisting = EventAttendee::isExisting($this, $userId, $params);

        if (!is_null($isExisting)) {
            throw new \Exception("You are already signed up to this event");
        }

        $attribs = NULL;

        if (!is_null($params)) {
            $attribs = [
                'member_id' => isset($params['member_id']) && $params['member_id'] != '' ? $params['member_id'] : NULL,
                'first_name' => $params['first_name'],
                'last_name' => $params['last_name'],
                'phone_number' => $params['phone_number'],
                'email_address' => $params['email_address'],
            ];
        }

        if (!is_null($userId)) {
            $user = User::find($userId);
            if ($user) {
                $attribs = [
                    'member_id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'phone_number' => $user->phone_numbers()->count() > 0 ? $user->phone_numbers()->first()->phone_number : NULL,
                    'email_address' => $user->email_addresses()->count() > 0 ? $user->email_addresses()->first()->email_address : NULL,
                ];
            }
        }

        if (is_null($attribs)) {
            throw new \Exception("Could not sign up event attendee to Event ID "  . $this->id . ", insufficient details");
        }

        $this->attendees()->create($attribs);
    }

    public static function getCachedEvents()
    {
        $key = md5('jtg.published.events');

        $data = Cache::remember($key, 86400, function () {
            return Event::isPublished()
                ->active()
                ->get();
        });

        return $data;
    }

    public static function forgetCachedEvents()
    {
        $key = md5('jtg.published.events');

        if (Cache::has($key)) {
            Cache::forget($key);
        }
    }
}
