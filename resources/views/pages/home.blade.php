@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1>Update your profile pic</h1>
    {!! Form::open(['action' => 'HomeController@addProfilePic', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::file('profile_image'), ['class' => 'form-control']}}
        </div>
        {{Form::submit('Edit The profile pic', ['class' => "btn btn-primary"])}}
        
    {!! Form::close() !!}
        <br>
        <p></p>
                    <a href="/posts/create" class = "btn btn-primary">Create a Post</a>
                    <br><p></p>
                    <h1>Your Posts</h1>
                    <table class="table table-stripped">
                       
                        @if(count($user->posts)>0)
                        <tr>
                                <th>Posts</th>
                                <th></th>
                                <th></th>
                            </tr>
                        @foreach($user->posts as $post)
                            <tr>
                            <td>
                                <span class="row">
                                    <span class="col-md-2 col-sm-2">
                                        <img width='100%' src="/storage/cover_image/{{$post->cover_image}}">                                </span>
                                    <span class="col-md-8 col-sm-8">
                                        <a href="posts/{{$post->id}}">{{$post->title}}</a>
                                    </span>       
                                </span>                             
                            </td>
                                <td><a href="posts/{{$post->id}}/edit" class="btn btn-light">Edit</a></td>
                                <td>
                                    {!! Form::open(['action'=>['PostsController@destroy', $post->id], 'method'=>'POST'])!!}
                                    {!!Form::submit('Delete', ['class'=>'btn btn-danger'])!!}
                                    {!!Form::hidden('_method', 'DELETE')!!}
                                    {!!Form::close()!!}
                                </td>
                            </tr>    
                        @endforeach
                        @else
                        <p>No Posts Created</p>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
