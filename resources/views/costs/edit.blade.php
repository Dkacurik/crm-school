@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="{{ route('costs.update', $cost->id)}}">
                    {{ method_field('PATCH') }}

                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Cost title" value="{{$cost->title}}" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control" required>{{$cost->content}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Price" value="{{$cost->price}}" required>
                    </div>

                    <button type="submit" class="btn btn-success">Edit</button>
                </form>
            </div>
        </div>
    </div>

@endsection
