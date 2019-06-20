@extends('layouts.frontend')

@section('title', 'JTG Manila Church')

@section('content')
    @include('frontend.partials.home.banner')

    @if (!is_null($on_going_event))
        @include('frontend.partials.home.ongoing-event', [
            'on_going_event' => $on_going_event
        ])
    @endif

    @if (is_null($on_going_event) && !is_null($upcoming_event))
        @include('frontend.partials.home.upcoming-event', [
            'upcoming_event' => $upcoming_event
        ])
    @endif

    @if ($events->count() > 0)
        @include('frontend.partials.home.more-events', [
            'upcoming_events' => $more_events
        ])
    @else
        <section class="jtg-intro py-2" style="background-image: url('/1.jpg');">
            <div class="overlay"></div>
            <div class="container">
                <div class="row d-flex align-items-center">
                    <div class="col-md-6 jtg-animate">
                        <h2><a href="#">New Event Coming Soon...</a></h2>
                    </div>
                </div>
            </div>
        </section>
    @endif


    @if ($sermons->count() > 0)
    @include('frontend.partials.home.latest-series', [
        'sermons' => $sermons
    ])
    @endif

    @include('frontend.partials.home.who-we-are')

    @include('frontend.partials.home.map', [
        'event_img' => '/images/jtg-manila-map.png'
    ])

    @include('frontend.partials.home.planning-a-visit')
@stop