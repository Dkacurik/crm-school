@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="row">

                    <div class="col-lg-4">
                        <div class="card my-2">
                            <div class="card-body">
                                <h2 class="card-title">Salary</h2>
                                <h4 style="color:darkred">{{$salary->salary}} &euro;</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card my-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 my-2">
                                <div class="card" style="border: none;">
                                    <div class="card-body">
                                        <a href="/costs"><h2>Last cost</h2></a>
                                        @if($lastcost)
                                            <h4>{{$lastcost->title}}</h4>
                                            <h5>Price: {{$lastcost->price}}</h5>
                                            <p>{{$lastcost->content}}</p>
                                        @else
                                            <h4>There are no costs</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 my-2">
                                <div class="card" style="border: none;">
                                    <div class="card-body">
                                        <a href="/jobs"><h2>Last Job</h2></a>
                                        @if($lastjob)
                                            <h4>{{$lastjob->title}}</h4>
                                            <p>{{$lastjob->description}}</p>
                                        @else
                                            <h4>There are no jobs</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 my-2">
                                <div class="card" style="border: none;">
                                    <div class="card-body">
                                        <a href="/clients"><h2>Last Client</h2></a>
                                        @if($lastclient)

                                            <h4>{{$lastclient->client}}</h4>
                                            <p>{{$lastclient->content}}</p>
                                        @else
                                            <h4>There are no clients</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card my-2">
                    <div class="card-body">
                        <a href="/process"><h2>Tasks in progress</h2></a>
                        @if($inprogress)
                            @foreach($inprogress as $task)
                                <div style="background-color: #ffed4a; margin-top: 15px; padding: 15px">
                                    <h4>{{$task->title}}</h4>
                                    @if($task->worktaskid == 1)
                                        <h5>WeRise</h5>
                                    @else
                                        <h5>{{$task->client}}</h5>
                                    @endif
                                    <p>{{$task->content}}</p>
                                </div>
                            @endforeach
                        @else
                            <h4>You don't have tasks in progress</h4>
                        @endif
                    </div>
                </div>
                <div class="card my-2">
                    <div class="card-body">
                        <a href="/notes"><h2>Last note</h2></a>
                        <div class="note-box">
                            <div class="note-body">
                                @if($lastnote)
                                    <h4>{{$lastnote->title}}</h4>
                                    <div class="note-text">
                                        <p class="card-text read-more">{{$lastnote->content}}</p>
                                    </div>
                                @else
                                    <h4>You don't have notes</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
