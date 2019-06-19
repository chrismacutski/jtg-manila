<?php

namespace App\Http\Controllers;

use App\JTG\Event;
use App\Series;
use App\Sermon;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index()
    {
        $filters = session('frontend_series_filters');

        $upcoming_event = Event::active()
            ->upcoming()
            ->isPublished()
            ->orderBy('starting_at', 'ASC')
            ->first();

        $latest_series = Series::isPublished()
            ->orderBy('happened_at', 'DESC')
            ->first();

        $query = Series::isPublished();

        if (isset($filters['name']) && $filters['name'] != '') {
            $query->where('name', 'LIKE', $filters['name'] . '%');
        }

        if (isset($filters['starting_at_from']) && $filters['starting_at_from'] != '') {
            $query->where('happened_at', '>=', $filters['starting_at_from'] . ' 00:00:00');
            if (isset($filters['starting_at_to']) && $filters['starting_at_to'] != '') {
                $query->where('happened_at', '<=', $filters['starting_at_to'] . ' 23:59:59');
            }
        }


        $series = $query->orderBy('happened_at', 'ASC')
            ->paginate(9);

        return view('frontend.series.index')
            ->with('upcoming_event', $upcoming_event)
            ->with('series', $series)
            ->with('latest_series', $latest_series)
            ->with('filters', $filters);
    }

    public function filter()
    {
        $take = request('take', 9);
        session([
            'frontend_series_filters' => [
                'name' => request('name'),
                'starting_at_from' => request('starting_at_from'),
                'starting_at_to' => request('starting_at_to'),
                'take' => $take
            ]
        ]);

        $filters = session('frontend_series_filters');

        $query = Series::isPublished();

        if (isset($filters['name']) && $filters['name'] != '') {
            $query->where('name', 'LIKE', '%' . $filters['name'] . '%');
        }

        if (isset($filters['starting_at_from']) && $filters['starting_at_from'] != '') {
            $query->where('happened_at', '>=', $filters['starting_at_from'] . ' 00:00:00');
            if (isset($filters['starting_at_to']) && $filters['starting_at_to'] != '') {
                $query->where('happened_at', '<=', $filters['starting_at_to'] . ' 23:59:59');
            }
        }

        $series = $query->orderBy('happened_at', 'DESC')
            ->paginate($take);

        return $series;
    }

    public function show(Series $series)
    {
        $upcoming_event = Event::active()
            ->upcoming()
            ->isPublished()
            ->orderBy('starting_at', 'ASC')
            ->first();

        $series->load('sermons.speaker');

        $sermons = $series->sermons;

        return view('frontend.series.show')
            ->with('upcoming_event', $upcoming_event)
            ->with('series', $series)
            ->with('sermons', $sermons);
    }
}
