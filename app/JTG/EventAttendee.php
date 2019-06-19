<?php

namespace App\JTG;

use App\User;
use Illuminate\Database\Eloquent\Model;

class EventAttendee extends Model
{
    protected $table = 'jtg_event_attendees';

    protected $fillable = [
        'first_name', 'last_name', 'phone_number', 'email_address',
        'amount_paid', 'paid_at', 'member_id', 'event_id'
    ];

    protected $dates = [
        'paid_at'
    ];

    public function member()
    {
        return $this->belongsTo(User::class);
    }

    public function jtg_events()
    {
        return $this->hasMany(Event::class);
    }

    public function scopeIsMember($query)
    {
        $query->whereNotNull('member_id');
    }

    public static function isExisting(Event $event, $userId = NULL, $params = NULL)
    {
        if (is_null($userId) && is_null($params)) {
            throw new \Exception("Could not check existence of event attendee, parameters are empty");
        }

        $event_attendee = NULL;
        if (!is_null($userId)) {
            $event_attendee = EventAttendee::where([
                'member_id' => $userId,
                'event_id' => $event->id
            ])->first();
        }

        if (!is_null($params)) {
            $event_attendee = EventAttendee::where([
                'event_id' => $event->id,
                'first_name' => $params['first_name'],
                'last_name' => $params['last_name'],
                'phone_number' => $params['phone_number'],
                'email_address' => $params['email_address'],
            ])->first();
        }

        return $event_attendee;
    }
}
