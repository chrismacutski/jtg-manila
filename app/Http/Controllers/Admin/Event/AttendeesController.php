<?php

namespace App\Http\Controllers\Admin\Event;

use App\JTG\Event;
use App\JTG\EventAttendee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Event $event)
    {
        return view('admin.events.attendees.create')
            ->with('event', $event);
    }

    public function store(Event $event)
    {
        try {
            $event->signUpAttendee(NULL, request()->only('member_id', 'first_name', 'last_name', 'phone_number', 'email_address'));
        } catch (\Exception $e) {
            logger($e->getMessage());
            abort(500, $e->getMessage());
        }

        return $event;
    }

    public function destroy(Event $event, EventAttendee $event_attendee)
    {
        try {
            $event_attendee->delete();
        } catch (\Exception $e) {
            logger($e->getMessage());
            abort(500, $e->getMessage());
        }

        return $event;
    }
}
