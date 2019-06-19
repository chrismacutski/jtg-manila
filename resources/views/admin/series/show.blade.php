@extends('layouts.app')

@section('title', 'Events')

@section('content')
    <div class="container-fluid py-0">
        <div class="row">
            <div class="col-lg-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h4>{{ $series->name }}</h4>
                    <a href="{{ route('admin.series.edit', $series) }}" class="btn btn-primary">
                        <i class="fa fa-pencil fa-lg"></i>
                    </a>
                </div>
                <div class="card mb-4 border-0">
                    <div class="card-body p-0">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td>Description</td>
                                <td>{{ $series->description }}</td>
                            </tr>>
                            <tr>
                                <td>Happened At</td>
                                <td>{{ $series->happened_at->format('M d, Y H:i A') }}</td>
                            </tr>
                            <tr>
                                <td>Published At</td>
                                <td>{{ $series->published_at->format('M d, Y H:i A') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-lg-8">
                <series-sermons-list :series="{{ json_encode($series) }}"></series-sermons-list>
                {{--<series-sermons :series="{{ json_encode($series) }}"></series-sermons>--}}
            </div>
        </div>
    </div>
@stop