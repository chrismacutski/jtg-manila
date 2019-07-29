<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventAttendeeRequest;
use App\JTG\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventsController extends Controller
{
    public function index()
    {
        $filters = session('frontend_event_filters');

        $upcoming_event = Event::active()
            ->isPublished()
            ->orderBy('starting_at', 'ASC')
            ->first();

        $query = Event::active()
            ->isPublished();

        if (isset($filters['name']) && $filters['name'] != '') {
            $query->where('name', 'LIKE', $filters['name'] . '%');
        }

        if (isset($filters['starting_at_from']) && $filters['starting_at_from'] != '') {
            $query->where('starting_at', '>=', $filters['starting_at_from'] . ' 00:00:00');
            if (isset($filters['starting_at_to']) && $filters['starting_at_to'] != '') {
                $query->where('starting_at', '<=', $filters['starting_at_to'] . ' 23:59:59');
            }
        }


        $events = $query->orderBy('starting_at', 'ASC')
            ->paginate(9);

        return view('frontend.event.index')
            ->with('upcoming_event', $upcoming_event)
            ->with('events', $events)
            ->with('filters', $filters);
    }

    public function filter()
    {
        $take = request('take', 9);
        session([
            'frontend_event_filters' => [
                'name' => request('name'),
                'starting_at_from' => request('starting_at_from'),
                'starting_at_to' => request('starting_at_to'),
                'take' => $take
            ]
        ]);

        $filters = session('frontend_event_filters');

        $query = Event::active()
            ->isPublished();

        if (isset($filters['name']) && $filters['name'] != '') {
            $query->where('name', 'LIKE', $filters['name'] . '%');
        }

        if (isset($filters['starting_at_from']) && $filters['starting_at_from'] != '') {
            $query->where('starting_at', '>=', $filters['starting_at_from'] . ' 00:00:00');
            if (isset($filters['starting_at_to']) && $filters['starting_at_to'] != '') {
                $query->where('starting_at', '<=', $filters['starting_at_to'] . ' 23:59:59');
            }
        }

        $events = $query->orderBy('starting_at', 'ASC')
            ->paginate($take);

        return $events;
    }

    public function show(Event $event)
    {
        $event->load('contents');

        $slider_images = $event->contents->where('type', 'slider_images')->first();
        $header_text = $event->contents->where('type', 'header_text')->first();
        $video_url = $event->contents->where('type', 'video_url')->first();
        $text_content = $event->contents->where('type', 'text_content')->first();

        return view('frontend.event.show')
            ->with('event', $event)
            ->with('slider_images', $slider_images)
            ->with('header_text', $header_text)
            ->with('video_url', $video_url)
            ->with('text_content', $text_content);
    }

    public function guestSignUp(CreateEventAttendeeRequest $request, Event $event)
    {
        try {
            $event->signUpAttendee(NULL, request()->only('member_id', 'first_name', 'last_name', 'phone_number', 'email_address', 'message'));
        } catch (\Exception $e) {
            logger($e->getMessage());
            abort(500, $e->getMessage());
        }

        return $event;
    }
}
