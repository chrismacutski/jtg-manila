@extends('layouts.app')

@section('title', 'Series')

@section('content')
    <series-list :series-list="{{ json_encode($series) }}"
                 :session-filters="{{ json_encode($filters) }}"></series-list>
@stop