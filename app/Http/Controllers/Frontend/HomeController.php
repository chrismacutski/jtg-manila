<?php

namespace App\Http\Controllers\Frontend;

use App\JTG\Event;
use App\Sermon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::active()
                ->upcoming()
                ->isPublished()
                ->orderBy('starting_at', 'ASC')
                ->take(3)
                ->get();

        $on_going_event = Event::onGoing()
            ->first();

        $sermons = Sermon::with('speaker')
            ->isPublished()
            ->orderBy('happened_at', 'DESC')
            ->take(3)
            ->get();

        return view('frontend.index')
            ->with('events', $events)
            ->with('upcoming_event', $events->first())
            ->with('on_going_event', $on_going_event)
            ->with('more_events', $events)
            ->with('sermons', $sermons);
    }
}
