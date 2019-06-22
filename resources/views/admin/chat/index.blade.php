@extends('layouts.app')

@section('title', 'Chat')

@section('content')
    <conversations-list :app-url="{{ json_encode(config('app.url')) }}"
                        :data="{{ $conversations }}"
                        :author="{{ json_encode('admin') }}"></conversations-list>
@stop