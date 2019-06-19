@extends('layouts.app')

@section('title', 'Events')

@section('content')
    <event-list :event-list="{{ json_encode($events) }}"
                :session-filters="{{ json_encode($filters) }}"></event-list>
@stop