
@extends('layouts.frontend')

@section('title', 'Contact')

@section('content')
    <connect-with-us-banner :image="{{ json_encode('/images/city.jpg') }}"></connect-with-us-banner>

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card rounded-0 bg-darker mt-4 mb-4">
                    <div class="card-body">
                        <contact-form></contact-form>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-4">
                @include('frontend.partials.contact.info')
            </div>
        </div>
    </div>
@stop