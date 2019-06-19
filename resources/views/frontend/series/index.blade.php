@extends('layouts.frontend')

@section('title', 'Series')

@section('content')
    @include('frontend.series.partials.banner', [
        'series' => $latest_series
    ])

    @if ($upcoming_event)
        @include('frontend.partials.home.upcoming-event', [
           'upcoming_event' => $upcoming_event->first()
        ])
    @endif

    @include('frontend.series.partials.nav')

    <frontend-series-list :series-list="{{ json_encode($series) }}"
                          :session-filters="{{ json_encode($filters) }}"></frontend-series-list>

    {{--<section class="jtg-series-section">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-4 jtg-animate">--}}
                    {{--<div class="jtg-series">--}}
                        {{--<a href="https://vimeo.com/45830194" class="img popup-vimeo mb-3 d-flex justify-content-center align-items-center" style="background-image: url('/images/1.jpg');">--}}
                            {{--<div class="icon d-flex justify-content-center align-items-center">--}}
                                {{--<span class="icon-play"></span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                        {{--<div class="text">--}}
                            {{--<h3><a href="#">Be at Peace With One Another</a></h3>--}}
                            {{--<span class="position">Speaker: Joseph Meyer</span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-4 jtg-animate">--}}
                    {{--<div class="jtg-series">--}}
                        {{--<a href="https://vimeo.com/45830194" class="img popup-vimeo mb-3 d-flex justify-content-center align-items-center" style="background-image: url('/images/2.jpg');">--}}
                            {{--<div class="icon d-flex justify-content-center align-items-center">--}}
                                {{--<span class="icon-play"></span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                        {{--<div class="text">--}}
                            {{--<h3><a href="#">Inspirational Message of God</a></h3>--}}
                            {{--<span class="position">Pastor. Joseph Meyer</span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-4 jtg-animate">--}}
                    {{--<div class="jtg-series">--}}
                        {{--<a href="https://vimeo.com/45830194" class="img popup-vimeo mb-3 d-flex justify-content-center align-items-center" style="background-image: url('/images/3.jpg');">--}}
                            {{--<div class="icon d-flex justify-content-center align-items-center">--}}
                                {{--<span class="icon-play"></span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                        {{--<div class="text">--}}
                            {{--<h3><a href="#">Prayers, Presence, and Provision</a></h3>--}}
                            {{--<span class="position">Dave Zuleger</span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row mt-0">--}}
                {{--<div class="col text-center jtg-animate">--}}
                    {{--<p><a href="#" class="btn btn-primary btn-outline-primary p-3">SHOW MORE MESSAGES</a></p>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}
    {{--<div class="container-fluid bg-darker">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-lg-4 col-md-4 col-sm-4 mb-4 ">--}}

                    {{--<div class="sermon-wrap sermon-wrap-2 mb-4 jtg-animate">--}}
                        {{--<a href="{{ route('series.show') }}" class="img" style="background-image: url(images/bg_series.jpg);"></a>--}}
                        {{--<div class="text p-4 bg-light text-center">--}}
                            {{--<h2 class="mb-3"><a href="sermon.html">Heartbeat</a></h2>--}}
                            {{--<div class="meta">--}}
                                {{--<p>--}}
                                    {{--<span class="mr-2">Speaker: <a href="#" class="ptr">Blenn Ramos</a></span>--}}
                                    {{--<span><a href="#">On Sunday 13 Jan, 2019</a></span>--}}
                                {{--</p>--}}
                            {{--</div>--}}
                            {{--<p class="jtg-animate">--}}
                                {{--<a href="{{ route('series.show') }}" class="btn-custom mb-2 p-2 text-center popup-vimeo"><span class="icon-play"></span> Watch Message</a>--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="card img-fluid border-white border-0 h-100 jtg-animate">--}}
                        {{--<img class="card-img-top" src="/images/bg_series.jpg" style="filter: brightness(70%);height: 350px;" alt="Card image">--}}
                        {{--<div class="card-img-overlay d-flex justify-content-center align-items-center">--}}
                            {{--<a href="{{ route('series.show') }}" class="btn btn-history p-0">--}}
                                {{--<i class="fa fa-play-circle-o fa-4x"></i>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-lg-4 col-md-4 col-sm-4 mb-4 ">--}}
                    {{--<div class="sermon-wrap sermon-wrap-2 mb-4 jtg-animate">--}}
                        {{--<a href="{{ route('series.show') }}" class="img" style="background-image: url(images/bg_series.jpg);"></a>--}}
                        {{--<div class="text p-4 bg-light text-center">--}}
                            {{--<h2 class="mb-3"><a href="sermon.html">Heartbeat</a></h2>--}}
                            {{--<div class="meta">--}}
                                {{--<p>--}}
                                    {{--<span class="mr-2">Speaker: <a href="#" class="ptr">Blenn Ramos</a></span>--}}
                                    {{--<span><a href="#">On Sunday 13 Jan, 2019</a></span>--}}
                                {{--</p>--}}
                            {{--</div>--}}
                            {{--<p class="jtg-animate">--}}
                                {{--<a href="{{ route('series.show') }}" class="btn-custom mb-2 p-2 text-center popup-vimeo"><span class="icon-play"></span> Watch Message</a>--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="card img-fluid border-white border-0 h-100 jtg-animate">--}}
                        {{--<img class="card-img-top" src="/images/jtg_series2.jpg" style="filter: brightness(70%);height: 350px;" alt="Card image">--}}
                        {{--<div class="card-img-overlay d-flex justify-content-center align-items-center">--}}
                            {{--<a href="{{ route('series.show') }}" class="btn btn-history p-0">--}}
                                {{--<i class="fa fa-play-circle-o fa-4x"></i>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-lg-4 col-md-4 col-sm-4 mb-4 ">--}}
                    {{--<div class="sermon-wrap sermon-wrap-2 mb-4 jtg-animate">--}}
                        {{--<a href="{{ route('series.show') }}" class="img" style="background-image: url(images/bg_series.jpg);"></a>--}}
                        {{--<div class="text p-4 bg-light text-center">--}}
                            {{--<h2 class="mb-3"><a href="sermon.html">Heartbeat</a></h2>--}}
                            {{--<div class="meta">--}}
                                {{--<p>--}}
                                    {{--<span class="mr-2">Speaker: <a href="#" class="ptr">Blenn Ramos</a></span>--}}
                                    {{--<span><a href="#">On Sunday 13 Jan, 2019</a></span>--}}
                                {{--</p>--}}
                            {{--</div>--}}
                            {{--<p class="jtg-animate">--}}
                                {{--<a href="{{ route('series.show') }}" class="btn-custom mb-2 p-2 text-center popup-vimeo"><span class="icon-play"></span> Watch Message</a>--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="card img-fluid border-white border-0 h-100 jtg-animate">--}}
                        {{--<img class="card-img-top" src="/images/jtg_series2.jpg" style="filter: brightness(70%);height: 350px;" alt="Card image">--}}
                        {{--<div class="card-img-overlay d-flex justify-content-center align-items-center">--}}
                            {{--<a href="{{ route('series.show') }}" class="btn btn-history p-0">--}}
                                {{--<i class="fa fa-play-circle-o fa-4x"></i>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-lg-4 col-md-4 col-sm-4 mb-4 ">--}}
                    {{--<div class="sermon-wrap sermon-wrap-2 mb-4 jtg-animate">--}}
                        {{--<a href="{{ route('series.show') }}" class="img" style="background-image: url(images/bg_series.jpg);"></a>--}}
                        {{--<div class="text p-4 bg-light text-center">--}}
                            {{--<h2 class="mb-3"><a href="sermon.html">Heartbeat</a></h2>--}}
                            {{--<div class="meta">--}}
                                {{--<p>--}}
                                    {{--<span class="mr-2">Speaker: <a href="#" class="ptr">Blenn Ramos</a></span>--}}
                                    {{--<span><a href="#">On Sunday 13 Jan, 2019</a></span>--}}
                                {{--</p>--}}
                            {{--</div>--}}
                            {{--<p class="jtg-animate">--}}
                                {{--<a href="{{ route('series.show') }}" class="btn-custom mb-2 p-2 text-center popup-vimeo"><span class="icon-play"></span> Watch Message</a>--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="card img-fluid border-white border-0 h-100 jtg-animate">--}}
                        {{--<img class="card-img-top" src="/images/jtg_series2.jpg" style="filter: brightness(70%);height: 350px;" alt="Card image">--}}
                        {{--<div class="card-img-overlay d-flex justify-content-center align-items-center">--}}
                            {{--<a href="{{ route('series.show') }}" class="btn btn-history p-0">--}}
                                {{--<i class="fa fa-play-circle-o fa-4x"></i>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@stop