@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    @include('frontend.partials.about.leadership.banner', [
        'leadership_banner_img' =>  '/images/leadership.jpg'
    ])

    @include('frontend.partials.about.nav')

    @include('frontend.partials.about.leadership.content')
@stop