@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    @include('frontend.partials.about.others.banner', [
        'real_made_teachings_banner_img' =>  '/images/about.jpg'
    ])

    @include('frontend.partials.about.nav')

    @include('frontend.partials.about.others.content')
@stop