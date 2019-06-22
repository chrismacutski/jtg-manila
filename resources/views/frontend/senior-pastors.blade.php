@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    <about-senior-pastors :image="{{ json_encode('/images/our-pastors.jpg') }}"></about-senior-pastors>

    @include('frontend.partials.about.nav', [
        'title' => 'OUR SENIOR PASTORS'
    ])
    @include('frontend.partials.about.senior-pastors.content')
@stop