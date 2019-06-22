<?php

namespace App\Http\Controllers\Admin\Series;

use App\Http\Requests\CreateSeriesSermonRequest;
use App\Series;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SermonsController extends Controller
{
    public function create(Series $series)
    {
        return view('admin.series.sermons.create')
            ->with('series', $series);
    }

    public function store(Series $series, CreateSeriesSermonRequest $request)
    {
        try {
            $sermon = $series->attachSermon(request()->only('sermon_speaker_id', 'name', 'description', 'content', 'happened_at', 'video_src', 'file_src'));

            if (request()->hasFile('image_src')) {
                $image_src = request()->file('image_src');

                if ($image_src->isValid()) {
                    $file_path = $image_src->storePubliclyAs('sermons/' . $series->id, 'image_src_' . $series->id . '.' .$image_src->getClientOriginalExtension(), 'public');

                    $sermon->image_src = $file_path;
                }
            }

            if (request()->hasFile('image_thumbnail_src')) {
                $image_thumbnail_src = request()->file('image_thumbnail_src');

                if ($image_thumbnail_src->isValid()) {
                    $file_path = $image_thumbnail_src->storePubliclyAs('sermons/' . $sermon->id, 'image_thumbnail_src' . $sermon->id . '.' . $image_thumbnail_src->getClientOriginalExtension(), 'public');

                    $sermon->image_thumbnail_src = $file_path;
                }
            }

            $sermon->save();
        } catch (\Exception $e) {
            logger($e->getMessage());
            abort(500, $e->getMessage());
        }
    }
}
