@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="{{ route('clients.update', $client->id)}}">
                    {{ method_field('PATCH') }}
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Client title" value="{{ $client->client }}" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control" required>{{$client->content}}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Edit</button>
                </form>
            </div>
        </div>
    </div>

@endsection
