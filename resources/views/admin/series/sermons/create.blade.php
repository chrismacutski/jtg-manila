@extends('layouts.app')

@section('title', 'Create Series')

@section('content')
    <create-series-sermon :series="{{ $series }}"></create-series-sermon>
@stop