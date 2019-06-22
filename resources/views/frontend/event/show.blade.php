@extends('layouts.frontend')

@section('title', $event->name)

@section('content')
    @include('frontend.event.partials.banner', [
        'banner_img' => $event->image_src,
        'event' => $event
    ])

    @if ($event->contents->count() > 0)
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 bg-gray">
                    <section class="jtg-vision">
                        <div class="container">
                            <div class="row justify-content-center my-5">
                                <div class="col-md-8 p-5 bg-darker">
                                    <h3 class="jtg-animate" style="text-transform: uppercase">{{ $header_text->header_text }}</h3>
                                    <p class="jtg-animate" style="white-space: pre-line">
                                        {!! $text_content->text_content  !!}
                                    </p>
                                </div>
                                <div class="col-md-4 p-5">
                                    <div class="block-21 mb-4 d-flex">
                                        {{--<a class="blog-img mr-4" style="background-image: url('/images/1.jpg');"></a>--}}
                                        <div class="text">
                                            <h3 class="heading"><a href="#">START</a></h3>
                                            <div class="meta">
                                                <div><a href="#"><span class="icon-calendar"></span> {{ $event->starting_at->format('M d Y H:iA') }}</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block-21 mb-4 d-flex">
                                        {{--<a class="blog-img mr-4" style="background-image: url('/images/1.jpg');"></a>--}}
                                        <div class="text">
                                            <h3 class="heading"><a href="#">END</a></h3>
                                            <div class="meta">
                                                <div><a href="#"><span class="icon-calendar"></span> {{ $event->ending_at->format('M d Y H:iA') }}</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block-21 mb-4 d-flex">
                                        {{--<a class="blog-img mr-4" style="background-image: url('/images/1.jpg');"></a>--}}
                                        <div class="text">
                                            <h3 class="heading"><a href="#">LOCATION</a></h3>
                                            <div class="meta">
                                                <div><a href="#"><span class="icon-map"></span> {{ $event->address }}</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="block-21 mb-4 d-flex">--}}
                                        {{--<a class="blog-img mr-4" style="background-image: url('/images/1.jpg');"></a>--}}
                                        {{--<div class="text">--}}
                                            {{--<h3 class="heading"><a href="#">SHARE THIS EVENT</a></h3>--}}
                                            {{--<div class="meta">--}}
                                                {{--<div>--}}
                                                    {{--<ul class="jtg-footer-social list-unstyled">--}}
                                                        {{--<li class="jtg-animate"><a href="#"><span class="icon-twitter"></span></a></li>--}}
                                                        {{--<li class="jtg-animate"><a href="https://www.facebook.com/sharer.php?u=http://jtg-website.baz/events/1" target="_blank"><span class="icon-facebook"></span></a></li>--}}
                                                        {{--<li class="jtg-animate"><a href="#"><span class="icon-instagram"></span></a></li>--}}
                                                    {{--</ul>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        @if (!is_null($slider_images))
            <event-slider :images="{{
                json_encode($slider_images->slider_images)
            }}"></event-slider>
        @endif
        <div class="container-fluid bg-darker">
            <div class="row">
                <div class="col-md-12 mt-5 mb-5">
                    <section class="jtg-vision bg-darker">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card border-0 bg-darker jtg-animate p-0">
                                        <div class="card-body">
                                            <event-form :jtg-event="{{ $event }}"></event-form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        @if (!is_null($video_url))
            <div class="embed-responsive embed-responsive-16by9">
                <video-player :video-url="{{ json_encode($video_url->video_url) }}"></video-player>
            </div>
        @endif
    @endif

@stop