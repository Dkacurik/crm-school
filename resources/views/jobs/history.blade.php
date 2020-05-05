@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive-md">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Client</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">FullPrice</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Done at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($jobs as $job)
                            <tr>
                                <td>{{$job->client}}</td>
                                <td>{{$job->title}}</td>
                                <td>{{$job->description}}</td>
                                <td>{{$job->fullprice}}</td>
                                <td>{{$job->created_at}}</td>
                                <td>{{$job->done_at}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
