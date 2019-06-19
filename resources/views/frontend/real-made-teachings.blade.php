@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    @include('frontend.partials.about.real-made-teachings.banner', [
        'real_made_teachings_banner_img' =>  '/images/real-made-teachings.jpg'
    ])

    @include('frontend.partials.about.nav')

    @include('frontend.partials.about.real-made-teachings.content')
@stop