@extends('layouts.app')

@section('title', 'Events')

@section('content')
    <div class="container-fluid py-0">
        <div class="row">
            <div class="col-lg-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h4>{{ $event->name }}</h4>
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary">
                        <i class="fa fa-pencil fa-lg"></i>
                    </a>
                </div>
                <div class="card mb-4 border-0">
                    <div class="card-body p-0">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td>Description</td>
                                <td>{{ $event->description }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{ $event->address }}</td>
                            </tr>
                            <tr>
                                <td>Starting At</td>
                                <td>{{ $event->starting_at->format('M d, Y H:i A') }}</td>
                            </tr>
                            <tr>
                                <td>Ending At</td>
                                <td>{{ $event->ending_at->format('M d, Y H:i A') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-lg-8">
                <event-attendee-list :event="{{ json_encode($event) }}"></event-attendee-list>
            </div>
        </div>
    </div>
@stop