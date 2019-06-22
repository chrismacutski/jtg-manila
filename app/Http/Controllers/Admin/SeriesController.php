<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateSeriesRequest;
use App\JTG\Event;
use App\Series;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('manage-series');

        $filters = session('series_filters');

        $query = Series::with('sermons');

        if (isset($filters['name']) && $filters['name'] != '') {
            $query->where('name', 'LIKE', $filters['name'] . '%');
        }

        if (isset($filters['happened_at_from']) && $filters['happened_at_from'] != '') {
            $query->where('happened_at', '>=', $filters['happened_at_from'] . ' 00:00:00');
            if (isset($filters['happened_at_to']) && $filters['happened_at_to'] != '') {
                $query->where('happened_at', '<=', $filters['happened_at_to'] . ' 23:59:59');
            }
        }

        $series = $query->latest()->paginate(20);

        if (request()->expectsJson()) {
            return $series;
        }

        return view('admin.series.index')
            ->with('filters', $filters)
            ->with('series', $series);
    }

    public function filter()
    {
        session([
            'series_filters' => [
                'name' => request('name'),
                'happened_at_from' => request('happened_at_from'),
                'happened_at_to' => request('happened_at_to'),
            ]
        ]);

        return redirect(route('admin.series.index'));
    }

    public function create()
    {
        return view('admin.series.create');
    }

    public function store(CreateSeriesRequest $request)
    {
        try {
            /** @var Series $series */
            $series = Series::addNew(request()->only('name', 'description', 'happened_at'));

            if (request()->hasFile('image_src')) {
                $image_src = request()->file('image_src');

                if ($image_src->isValid()) {
                    $file_path = $image_src->storePubliclyAs('series/' . $series->id, 'image_src_' . $series->id . '.' .$image_src->getClientOriginalExtension(), 'public');

                    $series->image_src = $file_path;
                }
            }

            if (request()->hasFile('image_thumbnail_src')) {
                $image_thumbnail_src = request()->file('image_thumbnail_src');

                if ($image_thumbnail_src->isValid()) {
                    $file_path = $image_thumbnail_src->storePubliclyAs('series/' . $series->id, 'image_thumbnail_src' . $series->id . '.' . $image_thumbnail_src->getClientOriginalExtension(), 'public');

                    $series->image_thumbnail_src = $file_path;
                }
            }

            $series->save();

        } catch (\Exception $e) {
            logger($e->getMessage());
            abort(500, $e->getMessage);
        }
        
        return $series;
    }

    public function destroy(Series $series)
    {
        try {
            $series->sermons()->delete();

            $series->delete();
        } catch (\Exception $e) {
            logger($e->getMessage());
            abort(500, $e->getMessage());
        }

        return [
            'success' => true
        ];
    }

    public function publish(Series $series)
    {
        try {
            $series->publish();

            $series->load('sermons');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }

        return $series;
    }

    public function show(Series $series)
    {
        $series->load('sermons.speaker');

        return view('admin.series.show')
            ->with('series', $series);
    }

    public function edit(Series $series)
    {

    }

    public function preview(Series $series)
    {
        $upcoming_event = Event::active()
            ->upcoming()
            ->isPublished()
            ->orderBy('starting_at', 'ASC')
            ->first();

        $series->load('sermons.speaker');

        $sermons = $series->sermons;

        return view('frontend.series.preview')
            ->with('upcoming_event', $upcoming_event)
            ->with('series', $series)
            ->with('sermons', $sermons);
    }
}
