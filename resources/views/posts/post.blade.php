@extends('layouts.app')
@section('content')
    <a href="/posts" class="btn btn-light">Go Back</a>
    <div class="well">
        <center><img style="{height:'50px'; width:'50px;'}" src="/storage/cover_image/{{$post->cover_image}}"></center>
    <h3>{{$post-> title}}</h3>
    <p>{!!$post -> body!!}</p>
    <small>Written On {{$post->created_at}}</small>
    </div>
    @if(!Auth::guest() && auth()->user()->id === $post->user_id)
    <a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a>
    {!!Form::open(['action'=> ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right'])!!}
        {!!Form::submit('Delete', ['class' => 'btn btn-danger'])!!}
        {!!Form::hidden('_method', 'DELETE')!!}
    {!!Form::close()!!}
    @endif
    <hr>   
    @if(count($comments) > 0)
    <h3>Comments</h3>
        <div class="container">
            @foreach($comments as $comment)
                <div class="row alert alert-light">
                    <div class="col-sm-1 col-md-1">
                        {{-- Profile Picture --}}
                    </div>
                    @if(auth()->user()->id == $post->user_id)
                        <div class="col-sm-9 col-md-9">
                            {{$comment->body}}
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <a href="#" class="btn btn-light">Edit</a>
                        </div>
                        <div class="col-sm-1 col-md-1">
                            {!!Form::open(['action' => ['CommentsController@destroy', $comment->id], 'method' =>'POST'])!!}
                                {!!Form::submit('Delete', ['class'=> 'btn btn-danger'])!!}
                                {!!Form::hidden('_method', 'DELETE')!!}
                            {!!Form::close()!!}
                        </div>
                        @else
                        <div class="col-sm-11 col-md-11">
                            {{$comment->body}}
                        </div>
                    @endif
                </div>
                <hr>
            @endforeach
        </div>
        @else
        <h3>No Comments Right Now.</h3>
    @endif
    @if(!Auth::guest() && auth()->user()->id !== $post->user_id)
        <h3>Post a Comment</h3>
        {!!Form::open(['action'=>'CommentsController@store', 'method' => 'POST'])!!}
        <div class="form-group">
            {!!Form::textarea('body', '' , ['class'=>'form-control'])!!}
        </div>
            {!!Form::hidden('post_id', $post->id)!!}
            {!!Form::hidden('user_id', auth()->user()->id)!!}
            {!!Form::submit('Comment', ['class'=>'btn btn-primary'])!!}
        {!!Form::close()!!}
        @else
            @if(Auth::guest())
                <h3><a href="{{ route('login') }}">Login In</a> to Comment</h3>
            @endif
    @endif
@endsection