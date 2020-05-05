@extends('layouts.app')

@section('content')
<div class="container">
    <ul class="pager">
        <li class="btn btn-primary previous float-right"><a href="{{ route('tasks.index') }}" class="text-white">Back</a></li>
    </ul>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
               <h2>{{$task->title}}</h2>
               <h3 class="my-4">{{$client->client}}</h3>
            </div>
            <div class="form-group">
                <p>{{$task->content}}</p>
            </div>
    </div>
    </div>
</div>

@endsection
