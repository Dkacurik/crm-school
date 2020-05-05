@extends('layouts.app')

@section('content')

    <div class="container" >
        <div class="row">
            <div class="col-lg-4 my-3">
                <div id="newTasks" class="col-lg-12 ">
                    <h2>New Tasks</h2>
                    @foreach($tasks as $task)
                        @if($task->newtask == 1)
                        <div class="card col-12 my-3" style="background-color: #bd2130; color:white">
                            <div class="card-body text-white">
                                <h3 class="pl-0">{{$task->title}}</h3>
                                @if($task->worktaskid == 1)
                                <h5>WeRise</h5>
                                @else
                                <h5>{{$task->client}}</h5>
                                @endif
                                <p class="card-text read-more">{{$task->content}}</p>
                                <button id="send-to-inProgress" data-token="{{ csrf_token() }}" data-id="{{$task->id}}" class="btn btn-primary btn-chevron-right"><img src="{{URL::asset('/public/img/feather_icons/chevron-right-white.svg')}}" alt="" width="10" height="10" style="padding-left:2px"></button>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4 my-3">
                <div id="inProgress" class="col-lg-12">
                    <h2>Tasks in progress</h2>
                    @foreach($tasks as $task)
                        @if($task->inprogress == 1)
                        <div class="card col-12 my-3" style="background-color: #ffed4a">
                            <div class="card-body">
                                <button id="send-to-newTask" data-token="{{ csrf_token() }}" data-id="{{$task->id}}" class="btn btn-primary btn-chevron-left"><img src="{{URL::asset('/public/img/feather_icons/chevron-left-white.svg')}}" alt="" width="10" height="10" style="padding-right:2px"></button>
                                <h3 class="pl-0">{{$task->title}}</h3>
                                @if($task->worktaskid == 1)
                                    <h5>WeRise</h5>
                                    @else
                                    <h5>{{$task->client}}</h5>
                                    @endif
                                <p class="card-text read-more">{{$task->content}}</p>
                                <button id="send-to-completed" data-token="{{ csrf_token() }}" data-id="{{$task->id}}" class="btn btn-primary btn-chevron-right"><img src="{{URL::asset('/public/img/feather_icons/chevron-right-white.svg')}}" alt="" width="10" height="10" style="padding-left:2px"></button>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4 my-3">
                <div id="Completed" class="col-lg-12">
                    <h2>Completed tasks</h2>
                    @foreach($tasks as $task)
                        @if($task->completed == 1)
                        <div class="card col-12 my-3" style="background-color: #1c7430; color:white!important">
                            <div class="card-body text-white">
                                <button id="send-to-inProgress" data-token="{{ csrf_token() }}" data-id="{{$task->id}}" class="btn btn-primary btn-chevron-left"><img src="{{URL::asset('/public/img/feather_icons/chevron-left-white.svg')}}" alt="" width="10" height="10" style="padding-right:2px"></button>
                                <h3 class="pl-0">{{$task->title}}</h3>
                                @if($task->worktaskid == 1)
                                    <h5>WeRise</h5>
                                    @else
                                    <h5>{{$task->client}}</h5>
                                    @endif
                                <p class="card-text read-more">{{$task->content}}</p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(document).on('click',"#send-to-inProgress,#send-to-newTask,#send-to-completed", function(){

                let send_to = $(this).attr("id");
                let id = $(this).attr("data-id");
                let token = $(this).attr("data-token");

                $(this).parent().parent().hide();


                $.ajax({
                    url:'process/ajax',
                    dataType:'json',
                    type:'post',
                    data: {
                        id: id,
                        send_to: send_to,
                        _method: 'patch',
                        _token: token
                    },
                    success:  function () {

                        if(send_to === 'send-to-inProgress'){
                            $("#inProgress").load(location.href+" #inProgress>*","");
                        }else if(send_to === 'send-to-newTask'){
                            $("#newTasks").load(location.href+" #newTasks>*","");
                        }else if(send_to === 'send-to-completed'){
                            $("#Completed").load(location.href+" #Completed>*","");
                        }

                     // this.card.hide();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.status);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            });
        });
    </script>

@endsection
