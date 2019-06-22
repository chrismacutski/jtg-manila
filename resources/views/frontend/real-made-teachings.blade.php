@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    <about-real-made-system :image="{{ json_encode('/images/real-made-teachings.jpg') }}"></about-real-made-system>

    @include('frontend.partials.about.nav', [
        'title' => 'REAL - MADE TEACHINGS'
    ])

    @include('frontend.partials.about.real-made-teachings.content')
@stop