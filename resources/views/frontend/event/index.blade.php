@extends('layouts.frontend')

@section('title', 'JTG Manila Church')

@section('content')
    @if (!is_null($upcoming_event))
        @include('frontend.event.partials.banner', [
            'banner_img' => $upcoming_event->image_src,
            'event' => $upcoming_event
        ])
    @else
        @include('frontend.event.partials.banner', [
            'banner_img' => 'images/1.jpg',
            'event' => NULL
        ])
    @endif

    <frontend-event-list :event-list="{{ json_encode($events) }}"
                         :session-filters="{{ json_encode($filters) }}"></frontend-event-list>
@stop