@extends('layouts.app')

@section('content')
@csrf
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('tasks.create') }}" style="float: right; margin-bottom: 10px;">
                <button class="btn btn-primary">Create</button>
            </a>
            <div class="table-responsive-lg">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Task For</th>
                            <th scope="col">Title</th>
                            <th scope="col">Content</th>
                            <th scope="col">Work</th>
                            <th scope="col">State</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Task from</th>
                            <th scope="col">Edit</th>
                            <th scope="col" class="d-none d-sm-table-cell">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                        <tr>
                            <td>{{$task->name}}</td>
                            <td><a class="text-dark" href="tasks/{{$task->id}}">{{$task->title}}</a></td>
                            <td style="min-width: 200px">{{$task->content}}<a class="text-dark" href="tasks/{{$task->id}}">...</a> </td>
                            <td>{{$task->client}}</td>
                            @if($task->newtask == 1)
                            <td><i class="fa fa-times" style="font-size : 40px; color:darkred"></i></td>
                            @elseif($task->inprogress == 1)
                            <td><i class="fa fa-clock-o" style="font-size : 40px; color:#FF9900"></i></td>
                            @else
                            <td> <i class="fa fa-check" style="font-size : 40px; color:darkgreen"></i></td>
                            @endif
                            <td>{{$task->deadline}}</td>
                            <td>{{$task->taskfrom}}</td>
                            
                            <td class="d-none d-sm-table-cell"><button type="button" class="btn btn-success editTask"
                                    data-token="{{ csrf_token() }}" data-id="{{$task->id}}">Edit</button></td>

                            <td class="d-none d-sm-table-cell"><button type="button" class="btn btn-danger deleteTask"
                                    data-token="{{ csrf_token() }}" data-id="{{$task->id}}">Delete</button></td>


                            <td class="d-table-cell d-sm-none">
                                <div class="btn-group dropleft">
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">

                                    </button>
                                    <div class="dropdown-menu">
                                    <button type="button" class="btn btn-success editTask dropdown-item"
                                    data-token="{{ csrf_token() }}" data-id="{{$task->id}}">Edit</button>

                                        <button type="button" class="btn btn-danger archive deleteTask dropdown-item"
                                            data-token="{{ csrf_token() }}" data-id="{{$task->id}}">Delete</button>
                                    </div>
                                </div>
                            </td>
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
        $(".deleteTask").click(function () {
            var id = $(this).attr("data-id");
            var token = $(this).attr("data-token");
            var btn = this;

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
                        url: "tasks/" + id,
                        type: 'post',
                        data: {
                            _method: 'delete',
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
                                } else {
                                    location.reload();
                                }
                                //   $(btn).parent('note-body').css('display', 'none');
                            });

                        },
                        error: function () {
                            swal.fire({
                                title: "Error",
                                text: "You don't have permission!",
                                type: "error"
                            }).then(function (result) {
                                if (result.value) {
                                    location.reload();
                                } else {
                                    location.reload();
                                }
                                //   $(btn).parent('note-body').css('display', 'none');
                            });
                        }
                    });

                }
            })


        })
        $('.editTask').click(function () {
            var id = $(this).attr("data-id");
            var token = $(this).attr("data-token");
            var btn = this;

            $.ajax({
                    url: "tasks/" + id + "/edit",
                    type: 'get',
                    data: {
                       // _method: 'patch',
                        _token: token,
                        idckoje: id
                    },
                    success: function(data){
            $("body").html(data);
          },
        
                    error: function () {
                        swal.fire({
                            title: "Error",
                            text: "You don't have permission!",
                            type: "error"
                        })
                    }

            })
        })



    });
</script>

@endsection
