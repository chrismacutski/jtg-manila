@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    <about-leadership :image="{{ json_encode('/images/leadership.jpg') }}"></about-leadership>

    @include('frontend.partials.about.nav')

    @include('frontend.partials.about.leadership.content')
@stop