@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    <about-ministries :image="{{ json_encode('/images/ministry.jpg') }}"></about-ministries>

    @include('frontend.partials.about.nav')

    @include('frontend.partials.about.ministries.content')
@stop