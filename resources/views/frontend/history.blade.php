@extends('layouts.frontend')

@section('title', 'About')

@section('content')
    <history-banner :title="'History'"
                    :image="'/images/history.jpg'"></history-banner>
    {{--@include('frontend.partials.about.history.banner', [--}}
        {{--'history_banner_img' =>  '/images/bg_4.jpg'--}}
    {{--])--}}

    @include('frontend.partials.about.nav')

    @include('frontend.partials.about.history.content')
@stop