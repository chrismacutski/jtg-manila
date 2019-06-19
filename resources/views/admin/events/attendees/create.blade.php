@extends('layouts.app')

@section('title', 'Admin')

@section('content')
    <create-event-attendee :event="{{ $event }}"></create-event-attendee>
@stop