<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateEventRequest;
use App\JTG\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\Process\Process;


class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('manage-events');

        $filters = session('event_filters');

        $query = Event::with('attendees');

        if (isset($filters['name']) && $filters['name'] != '') {
            $query->where('name', 'LIKE', $filters['name'] . '%');
        }

        if (isset($filters['starting_at_from']) && $filters['starting_at_from'] != '') {
            $query->where('starting_at', '>=', $filters['starting_at_from'] . ' 00:00:00');
            if (isset($filters['starting_at_to']) && $filters['starting_at_to'] != '') {
                $query->where('starting_at', '<=', $filters['starting_at_to'] . ' 23:59:59');
            }
        }

        if (isset($filters['ending_at_from']) && $filters['ending_at_from'] != '') {
            $query->where('ending_at', '>=', $filters['ending_at_from'] . ' 00:00:00');
            if (isset($filters['ending_at_to']) && $filters['ending_at_to'] != '') {
                $query->where('ending_at', '<=', $filters['ending_at_to'] . ' 23:59:59');
            }
        }

        $events = $query->latest()->paginate(20);

        if (request()->expectsJson()) {
            return $events;
        }

        return view('admin.events.index')
            ->with('filters', $filters)
            ->with('events', $events);
    }

    public function filter()
    {
        session([
            'event_filters' => [
                'name' => request('name'),
                'starting_at_from' => request('starting_at_from'),
                'starting_at_to' => request('starting_at_to'),
                'ending_at_from' => request('ending_at_from'),
                'ending_at_to' => request('ending_at_to'),
            ]
        ]);

        return redirect(route('admin.events.index'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(CreateEventRequest $request)
    {
        try {
           /** @var Event $event */
            $event = Event::addNew(request()->only('name', 'description', 'content', 'address', 'amount', 'starting_at', 'ending_at'));

            if (request()->hasFile('image_src')) {
                $image_src = request()->file('image_src');

                if ($image_src->isValid()) {
                    $file_path = $image_src->storePubliclyAs('events/' . $event->id, 'image_src_' . $event->id . '.' .$image_src->getClientOriginalExtension(), 'public');

                    $event->image_src = 'storage/' . $file_path;
                    $image_resize = Image::make($image_src->getRealPath());
                    $image_resize->resize(1440, 760);
                    $image_resize->save(storage_path('app/public/' . $file_path));
                }
            }

            if (request()->hasFile('image_thumbnail_src')) {
                $image_thumbnail_src = request()->file('image_thumbnail_src');

                if ($image_thumbnail_src->isValid()) {
                    $file_path = $image_thumbnail_src->storePubliclyAs('events/' . $event->id, 'image_thumbnail_src' . $event->id . '.' . $image_thumbnail_src->getClientOriginalExtension(), 'public');

                    $event->image_thumbnail_src = 'storage/' . $file_path;

                    $image_resize = Image::make($image_thumbnail_src->getRealPath());
                    $image_resize->resize(1440, 760);
                    $image_resize->save(storage_path('app/public/' . $file_path));
                }
            }
            $event->attachHeaderText(request('header_text', ''));
            $event->attachVideoUrl(request('video_url', ''));
            $event->attachTextContent(request('text_content', ''));
            $event->attachSliderImages(request('slider_images', []));

            $event->save();
        } catch (\Exception $e) {
            logger($e->getMessage());
            abort(500, $e->getMessage());
        }
    }

    public function edit(Event $event)
    {
        $event->load('contents');
        return view('admin.events.edit')
            ->with('event', $event);
    }

    public function update(Event $event, CreateEventRequest $request)
    {
        try {
            $event->name = request('name', '');
            $event->description = request('description', '');
            $event->address = request('address', '');

            if (request('amount') != 'null') {
                $event->amount = $amount;
            }

            $event->starting_at = request('starting_at', '');
            $event->ending_at = request('ending_at', '');

            if (request()->hasFile('image_src')) {
                $image_src = request()->file('image_src');

                if ($image_src->isValid()) {
                    $file_path = $image_src->storePubliclyAs('events/' . $event->id, 'image_src_' . $event->id . '.' .$image_src->getClientOriginalExtension(), 'public');

                    $event->image_src = 'storage/' . $file_path;
                    $image_resize = Image::make($image_src->getRealPath());
                    $image_resize->resize(1440, 760);
                    $image_resize->save(storage_path('app/public/' . $file_path));
                }
            }

            if (request()->hasFile('image_thumbnail_src')) {
                $image_thumbnail_src = request()->file('image_thumbnail_src');

                if ($image_thumbnail_src->isValid()) {
                    $file_path = $image_thumbnail_src->storePubliclyAs('events/' . $event->id, 'image_thumbnail_src' . $event->id . '.' . $image_thumbnail_src->getClientOriginalExtension(), 'public');

                    $event->image_thumbnail_src = 'storage/' . $file_path;
                    $image_resize = Image::make($image_thumbnail_src->getRealPath());
                    $image_resize->resize(1440, 760);
                    $image_resize->save(storage_path('app/public/' . $file_path));
                }
            }
            $event->updateHeaderText(request('header_text', ''));
            $event->updateVideoUrl(request('video_url', ''));
            $event->updateTextContent(request('text_content', ''));
            $event->updateSliderImages(request('slider_images', []));

            $event->save();
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    public function publish(Event $event)
    {
        try {
            $event->publish();

            $event->load('contents');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }

        return $event;
    }

    public function show(Event $event)
    {
        $event->load('contents', 'attendees');

        return view('admin.events.show')
            ->with('event', $event);
    }

    public function destroy(Event $event)
    {
        try {
            $event->attendees()->delete();
            $event->contents()->delete();

            $event->delete();
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }

        return [
            'success' => true
        ];
    }

    public function preview(Event $event)
    {
        $this->authorize('manage-events');

        $event->load('contents');

        $slider_images = $event->contents->where('type', 'slider_images')->first();
        $header_text = $event->contents->where('type', 'header_text')->first();
        $video_url = $event->contents->where('type', 'video_url')->first();
        $text_content = $event->contents->where('type', 'text_content')->first();

        return view('frontend.event.preview')
            ->with('event', $event)
            ->with('slider_images', $slider_images)
            ->with('header_text', $header_text)
            ->with('video_url', $video_url)
            ->with('text_content', $text_content);
    }
}
