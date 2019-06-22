
@extends('layouts.frontend')

@section('title', 'Giving')

@section('content')
    <giving-banner :image="{{ json_encode('/images/giving.jpg') }}"></giving-banner>

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-10 offset-1">
                <div class="card rounded-0 bg-darker mt-4 mb-4">
                    <div class="card-body">
                        <giving-form></giving-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop