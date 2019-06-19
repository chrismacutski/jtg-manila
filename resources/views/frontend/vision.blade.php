@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    @include('frontend.partials.about.vision.banner', [
        'vision_banner_img' =>  '/images/about.jpg'
    ])

    @include('frontend.partials.about.nav')

    @include('frontend.partials.about.vision.content')
@stop