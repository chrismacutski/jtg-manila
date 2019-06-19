@extends('layouts.frontend')

@section('title', 'JTG Manila Church')

@section('content')
    @include('frontend.event.partials.banner', [
        'banner_img' => $upcoming_event->image_src,
        'event' => $upcoming_event
    ])

    <frontend-event-list :event-list="{{ json_encode($events) }}"
                         :session-filters="{{ json_encode($filters) }}"></frontend-event-list>
@stop