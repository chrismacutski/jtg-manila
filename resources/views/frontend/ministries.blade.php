@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    @include('frontend.partials.about.ministries.banner', [
        'ministry_banner_img' =>  '/images/ministry.jpg'
    ])

    @include('frontend.partials.about.nav')

    @include('frontend.partials.about.ministries.content')
@stop