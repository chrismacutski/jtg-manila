@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    <about-mission-vision :image="{{ json_encode('/images/about.jpg') }}"></about-mission-vision>

    @include('frontend.partials.about.nav', [
        'title' => 'MISSION AND VISION'
    ])

    @include('frontend.partials.about.vision.content')
@stop