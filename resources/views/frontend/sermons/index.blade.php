@extends('layouts.frontend')

@section('title', 'Sermons')

@section('content')
    @include('frontend.sermons.partials.banner2', [
        'sermon' => $latest_sermon,
        'sermon_img' => '/' . $latest_sermon->image_src,
    ])

    @if (!is_null($upcoming_event))
        @include('frontend.partials.home.upcoming-event', [
            'upcoming_event' => $upcoming_event
        ])
    @endif

    @include('frontend.series.partials.nav')


    <frontend-sermon-list :sermon-list="{{ json_encode($sermons) }}"
                          :session-filters="{{ json_encode($filters) }}"></frontend-sermon-list>

    {{--<section class="jtg-series-section">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--@foreach($sermons as $value)--}}
                    {{--<div class="col-md-4 jtg-animate">--}}
                        {{--<div class="jtg-series">--}}
                            {{--<a href="{{ route('sermons.show', $value) }}" class="img popup-vimeo mb-3 d-flex justify-content-center align-items-center" style="background-image: url('{{ '/' . $value->image_src }}');">--}}
                                {{--<div class="icon d-flex justify-content-center align-items-center">--}}
                                    {{--<span class="icon-play"></span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                            {{--<div class="text">--}}
                                {{--<h3><a href="#">{{ $value->name }}</a></h3>--}}
                                {{--<span class="position">Speaker: {{ $value->speaker->fullname }}</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@endforeach--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}
@stop