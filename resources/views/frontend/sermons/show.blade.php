@extends('layouts.frontend')

@section('title', 'Heart Beat')

@section('content')
    @include('frontend.sermons.partials.banner', [
        'sermon_img' => '/' . $sermon->image_src,
        'video_src' => $sermon->video_src,
        'series' => $sermon
    ])

    {{--@include('frontend.sermons.partials.content', [--}}
        {{--'sermon' => $sermon--}}
    {{--])--}}
    <frontend-sermon-show :sermon="{{ json_encode($sermon) }}"></frontend-sermon-show>
    {{--<div class="container-fluid">--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-12 bg-gray">--}}
                {{--<section class="jtg-vision">--}}
                    {{--<div class="container">--}}
                        {{--<div class="row justify-content-center my-5">--}}
                            {{--<div class="col-md-8 p-5 bg-darker">--}}
                                {{--<h3 class="jtg-animate d-flex justify-content-between" style="text-transform: uppercase">--}}
                                    {{--{{ $sermon->name }}--}}
                                    {{--<button type="button" class="btn btn-sm btn-primary">NOTES</button>--}}
                                {{--</h3>--}}
                                {{--<p class="jtg-animate text-justify" style="white-space: pre-line">--}}
                                    {{--{!! $sermon->content  !!}--}}
                                {{--</p>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-4 p-5">--}}
                                {{--<div class="block-21 mb-4 d-flex">--}}
                                    {{--<a class="blog-img mr-4" style="background-image: url('/images/1.jpg');"></a>--}}
                                    {{--<div class="text">--}}
                                        {{--<h3 class="heading"><a href="#">SPEAKER</a></h3>--}}
                                        {{--<div class="meta">--}}
                                            {{--<div><a href="#"><span class="icon-person"></span> {{ $sermon->speaker->fullname }}</a></div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="block-21 mb-4 d-flex">--}}
                                    {{--<a class="blog-img mr-4" style="background-image: url('/images/1.jpg');"></a>--}}
                                    {{--<div class="text">--}}
                                        {{--<h3 class="heading"><a href="#">DATE</a></h3>--}}
                                        {{--<div class="meta">--}}
                                            {{--<div><a href="#"><span class="icon-calendar"></span> {{ $sermon->happened_at->format('M d Y') }}</a></div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="block-21 mb-4 d-flex">--}}
                                    {{--<a class="blog-img mr-4" style="background-image: url('/images/1.jpg');"></a>--}}
                                    {{--<div class="text">--}}
                                        {{--<h3 class="heading"><a href="{{ $sermon->file_src }}" target="_blank" class="btn btn-primary py-3 px-4">DOWNLOAD FILE</a></h3>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</section>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@stop