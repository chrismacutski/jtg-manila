@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    <about-departments :image="{{ json_encode('/images/departments.jpg') }}"></about-departments>

    @include('frontend.partials.about.nav', [
        'title' => 'DEPARTMENTS'
    ])
    <about-department-list></about-department-list>

@stop