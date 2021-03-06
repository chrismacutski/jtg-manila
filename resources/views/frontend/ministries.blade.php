@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    <about-ministries :image="{{ json_encode('/images/ministry.jpg') }}"></about-ministries>

    @include('frontend.partials.about.nav', [
        'title' => 'MINISTRIES'
    ])

    <about-ministry-list></about-ministry-list>

@stop