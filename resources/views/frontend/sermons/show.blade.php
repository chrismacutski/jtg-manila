@extends('layouts.frontend')

@section('title', 'Messages')

@section('content')
    @include('frontend.sermons.partials.banner', [
        'sermon_img' => '/' . $sermon->image_src,
        'video_src' => $sermon->video_src,
        'series' => $sermon
    ])

    <frontend-sermon-show :sermon="{{ json_encode($sermon) }}"></frontend-sermon-show>
@stop