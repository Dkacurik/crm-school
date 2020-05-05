@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <a href="/jobs" style="float: right; margin-bottom: 10px;"><button class="btn btn-primary">Back</button></a>
            @if($job->percentage==50)

                <div class="col-lg-12">
                    <h2>CURRENTLY FREE: {{$job->percentage}} %</h2>
                    <form method="POST" action="{{ route('percentage', $job->id)}}">
                        {{ method_field('PATCH') }}
                        @csrf
                        <input type="text" style="display: none;" name="id" value="{{$job->id}}" required>
                        <div class="form-group">
                            <label for="client">Worker</label>
                            <select class="form-control" id="worker" name="worker"required >
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="percentage">Percentage</label>
                            <input type="number" class="form-control" id="percentage" name="percentage" placeholder="Percentage" max="{{$job->percentage}}" required>
                        </div>

                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>

            @else
                <div class="col-lg-12">
                    <h2>CURRENTLY FREE: {{$job->percentage}} %</h2>
                    @foreach($workers as $worker)
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 15px">
                            <div style="font-size: 20px">
                                <span class="col-sm-3" style="float: left; margin-right: 25px;">{{$worker->name}} </span>
                                <form class="col-sm-6" method="POST" style="float: left;" action="{{ route('jobs.repair', $job->id)}}"> @csrf {{ method_field('PATCH') }}
                                    <input type="text" name="oldpercent" value="{{$worker->userpercentage}} " style="display: none;">
                                    <input type="number" value="{{$worker->userpercentage}}" max="50" name="reppercent" class="form-control" style="width: 100px; margin-right: 25px; display: inline;"> %
                                    <input type="text" value="{{$worker->userid}}" name="userrepairid" style="display: none;">
                                        <button type="submit" class="btn btn-success float-sm-right ml-sm-0 ml-3">Repair</button>
                                </form>
                                    <form class="float-left ml-3 my-3 my-sm-0" method="POST" action={{ route('removepercentage', $job->id) }}>{{method_field('DELETE')}} @csrf
                                        <button type="submit" class="btn btn-danger">Delete</button> <input type="text" name="jobid" style="display: none" value="{{$job->id}}">
                                        <input type="text" name="useridd" value="{{$worker->userid}}" style="display:none;">
                                    </form>
                            </div>
                        </div>
                        </div>
                    @endforeach
                    <form method="POST" action="{{ route('percentage', $job->id)}}" style="margin-top: 50px">
                        {{ method_field('PATCH') }}
                        <input type="text" style="display: none;" name="id" value="{{$job->id}}">

                        @csrf
                        <div class="form-group">
                            <label for="client">Worker</label>
                            <select class="form-control" id="worker" name="worker" required>

                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Percentage</label>
                            <input type="number" class="form-control" id="percentage" name="percentage" placeholder="Percentage"  max="{{$job->percentage}}" required>
                        </div>

                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>

            @endif

        </div>
    </div>
@endsection
