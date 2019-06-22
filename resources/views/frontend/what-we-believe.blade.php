@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    <about-what-we-believe :image="{{ json_encode('/images/what-we-believe.jpg') }}"></about-what-we-believe>

    @include('frontend.partials.about.nav', [
        'title' => 'WHAT WE BELIEVE'
    ])

    @include('frontend.partials.about.what-we-believe.content')
@stop