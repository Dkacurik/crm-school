@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('notes.create') }}" style="float: right; margin-bottom: 10px; display: block"><button
                    class="btn btn-primary">Create</button></a>
        </div>
        @foreach($notes as $note)
        <div class="col-lg-4 my-2">
            <div class="col-lg-12">
                <div class="card note-box">
                    <a href="/notes/{{$note->id}}/edit">
                        <button class="btn note-btn-add"><img src="{{URL::asset('/public/img/feather_icons/edit.svg')}}" alt="Edit note" width="25" height="25"></button>
                    </a>
                    <button type="button" class="confirm-btn btn note-btn-delete" data-token="{{ csrf_token() }}" data-id="{{$note->id}}">
                        <img src="{{URL::asset('/public/img/feather_icons/x-square.svg')}}" alt="Delete note" width="25" height="25">
                    </button>
                    <div class="card-body note-body">
                        <h3 class="card-title">{{$note->title}}</h3>
                        <p class="card-text read-more">{{$note->content}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script>
    $(document).ready(function () {
        $(".confirm-btn").click(function () {
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
                        url: "notes/" + id,
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
    });
</script>


@endsection
