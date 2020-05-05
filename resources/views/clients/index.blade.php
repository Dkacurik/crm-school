@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <a href="{{ route('clients.create') }}" style="float: right; margin-bottom: 10px;"><button class="btn btn-primary">Create</button></a>
                <div class="table-responsive-sm">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Content</th>
                            <th scope="col">Edit</th>
                            <th scope="col" class="d-none d-sm-table-cell">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td>{{$client->client}}</td>
                                <td style="min-width: 200px">{{$client->content}}</td>
                                <td class="d-none d-sm-table-cell"><a href="/clients/{{$client->id}}/edit"><button class="btn btn-success">Edit</button></a></td>
                                @if( $client->id != 1)
                                    <!-- <td class="d-none d-sm-table-cell"><a href="/clients/{{$client->id}}"><form method="POST" action={{ route('clients.destroy', $client->id) }}>{{method_field('DELETE')}} @csrf <button type="submit" class="btn btn-danger swalDestroy">Delete</button></form></a></td> -->
                                    <td class="d-none d-sm-table-cell"><button type="button" class="btn btn-danger archive" data-token="{{ csrf_token() }}" data-id="{{$client->id}}">Delete</button></td>
                                    <td class="d-table-cell d-sm-none">
                                        <div class="btn-group dropleft">
                                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="/clients/{{$client->id}}/edit"><button class="dropdown-item">Edit</button></a>
                                                <a href="/clients/{{$client->id}}"><form method="POST" action={{ route('clients.destroy', $client->id) }}>{{method_field('DELETE')}} @csrf <button type="submit" class="dropdown-item swalDestroy">Delete</button></form></a>
                                            </div>
                                        </div>
                                    </td>
                                @else
                                    <td></td>
                                @endif
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
                        url: "/clients/"+id + "/archive",
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
    });
</script>

@endsection
