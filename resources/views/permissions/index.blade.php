@extends('layouts.app')

@section('title', 'Permissions')

@section('content')

    <permissions
            :user-list="{{ $users }}"
            :roles="{{ $roles }}"
            :activities="{{ $activities }}"
    ></permissions>

@stop