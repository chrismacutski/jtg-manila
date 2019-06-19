@extends('layouts.app')

@section('title', 'Admin')

@section('content')
    <update-event :event="{{ $event }}"></update-event>
@stop