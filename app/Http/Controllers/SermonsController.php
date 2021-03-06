<?php

namespace App\Http\Controllers;

use App\JTG\Event;
use App\Series;
use App\Sermon;
use Illuminate\Http\Request;

class SermonsController extends Controller
{
    public function index()
    {

        $filters = session('frontend_sermon_filters');

        $upcoming_event = Event::active()
            ->upcoming()
            ->isPublished()
            ->orderBy('starting_at', 'ASC')
            ->first();

        $latest_sermon = Sermon::with('speaker')
            ->isPublished()
            ->orderBy('happened_at', 'DESC')
            ->first();

        $query = Sermon::with('series', 'speaker')
            ->isPublished();

        if (isset($filters['name']) && $filters['name'] != '') {
            $query->where('name', 'LIKE', $filters['name'] . '%');
        }

        if (isset($filters['starting_at_from']) && $filters['starting_at_from'] != '') {
            $query->where('happened_at', '>=', $filters['starting_at_from'] . ' 00:00:00');
            if (isset($filters['starting_at_to']) && $filters['starting_at_to'] != '') {
                $query->where('happened_at', '<=', $filters['starting_at_to'] . ' 23:59:59');
            }
        }

        $sermons = $query->orderBy('happened_at', 'DESC')
            ->paginate(9);

        return view('frontend.sermons.index')
            ->with('upcoming_event', $upcoming_event)
            ->with('latest_sermon', $latest_sermon)
            ->with('sermons', $sermons)
            ->with('filters', $filters);
    }

    public function filter()
    {
        $take = request('take', 9);
        session([
            'frontend_sermon_filters' => [
                'name' => request('name'),
                'starting_at_from' => request('starting_at_from'),
                'starting_at_to' => request('starting_at_to'),
                'take' => $take
            ]
        ]);

        $filters = session('frontend_sermon_filters');

        $query = Sermon::with('series', 'speaker')
            ->isPublished();

        if (isset($filters['name']) && $filters['name'] != '') {
            $query->where('name', 'LIKE', '%' . $filters['name'] . '%');
        }

        if (isset($filters['starting_at_from']) && $filters['starting_at_from'] != '') {
            $query->where('happened_at', '>=', $filters['starting_at_from'] . ' 00:00:00');
            if (isset($filters['starting_at_to']) && $filters['starting_at_to'] != '') {
                $query->where('happened_at', '<=', $filters['starting_at_to'] . ' 23:59:59');
            }
        }

        $sermons = $query->orderBy('happened_at', 'DESC')
            ->paginate($take);

        return $sermons;
    }

    public function show(Sermon $sermon)
    {
        $sermon->load('speaker', 'series', 'notes');

        return view('frontend.sermons.show')
            ->with('sermon', $sermon);
    }
}
