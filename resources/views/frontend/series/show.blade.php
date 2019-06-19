@extends('layouts.frontend')

@section('title', 'Series Messages')

@section('content')
    @include('frontend.series.partials.banner', [
        'series' => $series
    ])

    @if (!is_null($upcoming_event))
        @include('frontend.partials.home.upcoming-event', [
            'upcoming_event' => $upcoming_event
        ])
    @endif

    @include('frontend.series.partials.nav')

    <section class="jtg-series-section">
        <div class="container">
            <div class="row">
                @foreach($sermons as $sermon)
                    <div class="col-md-4 jtg-animate">
                        <div class="jtg-series">
                            <a href="{{ route('sermons.show', $sermon->hash_id) }}" class="img mb-3 d-flex justify-content-center align-items-center" style="background-image: url({{ '/' . $sermon->image_src }});">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="icon-play"></span>
                                </div>
                            </a>
                            <div class="text">
                                <h3><a href="{{ route('sermons.show', $sermon->hash_id) }}">{{ $sermon->name }}</a></h3>
                                <span class="position">Speaker: {{ $sermon->speaker->fullname }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection