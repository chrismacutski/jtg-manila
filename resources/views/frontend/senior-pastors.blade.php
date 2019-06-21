@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    <about-senior-pastors :image="{{ json_encode('/images/about.jpg') }}"></about-senior-pastors>

    @include('frontend.partials.about.nav')

    @include('frontend.partials.about.senior-pastors.content')
@stop