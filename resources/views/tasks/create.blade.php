@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="{{ route('tasks.store')}}">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Task title" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="datepicker">Deadline: </label>
                        <input type="text"
                               class="datepicker-here"
                               data-language='sk'
                               data-position='top left' id="deadline" name="deadline" required/>

                        <label for="exampleFormControlSelect1">Selecet Client</label>
                        <select class="form-control" id="tasktype" name="worktaskid" required>
                            <!-- <option value="1">Werise</option> -->
                            @foreach($clients as $client)
                                <option value="{{$client->id}}">{{$client->client}}</option>
                            @endforeach
                            @foreach($clientsjob as $clientjob)
                            <option value="{{$clientjob->id}}">{{$clientjob->client}} - {{$clientjob->title}}</option>
                            @endforeach
                        </select>
                        <select class="form-control" id="tasktype" name="userid" required>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
