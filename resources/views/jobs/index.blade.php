@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <a href="{{ route('jobs.create') }}" style="float: right; margin-bottom: 10px;"><button class="btn btn-primary">Create</button></a>
                <div class="table-responsive-md">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Client</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">FullPrice</th>
                            <th scope="col">Workers</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                            <th scope="col">Complete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($jobs as $job)
                            <tr>
                                <td>{{$job->client}}</td>
                                <td>{{$job->title}}</td>
                                <td style="min-width: 200px">{{$job->description}}</td>
                                <td>{{$job->fullprice}}</td>
                                <td><a href="/jobs/{{$job->id}}"><button class="btn btn-info">Team</button></a></td>
                                <td><a href="/jobs/{{$job->id}}/edit"><button class="btn btn-warning text-white">Edit</button></a></td>
                               <!-- <td><form method="POST" action={{ route('jobs.destroy', $job->id) }}>{{method_field('DELETE')}} @csrf <button type="submit" class="btn btn-danger swalDestroy">Delete</button></form></td>-->
                                <td><button type="button" class="btn btn-danger archive" data-token="{{ csrf_token() }}" data-id="{{$job->id}}">Delete</button></td>
                                <td><button type="button" class="btn btn-success done" data-token="{{ csrf_token() }}" data-id="{{$job->id}}">Done</button></td>
                                <!-- <td><a href="/jobs/{{$job->id}}/complete"><form method="POST" action={{ route('jobs.complete', $job->id) }}>{{method_field('PATCH')}} @csrf <button type="submit" class="btn btn-success" >Done</button></form></a></td> -->
                                @error('nope')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script>
    $(document).ready(function () {
        $(".archive").click(function () {
            var id = $(this).attr("data-id");
            var token = $(this).attr("data-token");
            //console.log("id: " + id + " token: " + token);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {

                    $.ajax({
                        url: "/jobs/"+id + "/archive",
                        type: 'post',
                        data: {
                            _method: 'patch',
                            _token: token
                        },
                        success: function () {
                            console.log('deleted');
                            swal.fire({
                                title: "Good job",
                                text: "You clicked the button!",
                                type: "success"
                            }).then(function (result) {
                                if (result.value) {
                                    location.reload();
                                } else{
                                    location.reload();
                                }
                             //   $(btn).parent('note-body').css('display', 'none');
                            });

                        }
                    });

                }
            })


        })

        $(".done").click(function () {
            var id = $(this).attr("data-id");
            var token = $(this).attr("data-token");
            //console.log("id: " + id + " token: " + token);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {

                    $.ajax({
                        url: "/jobs/"+id + "/complete",
                        type: 'post',
                        data: {
                            _method: 'patch',
                            _token: token
                        },
                        success: function () {
                            console.log('done');
                            swal.fire({
                                title: "Good job",
                                text: "Job was completed successfully",
                                type: "success"
                            }).then(function (result) {
                                if (result.value) {
                                    location.reload();
                                } else{
                                    location.reload();
                                }
                             //   $(btn).parent('note-body').css('display', 'none');
                            });

                        },
                        error: function(){
                            swal.fire({
                                title: "Error",
                                text: "There are still tasks for this job",
                                type: "error"
                            }).then(function (result) {
                                // if (result.value) {
                                //     location.reload();
                                // } else{
                                //     location.reload();
                                // }
                             //   $(btn).parent('note-body').css('display', 'none');
                            });

                        }
                    });

                }
            })


        })
    });
</script>

@endsection
