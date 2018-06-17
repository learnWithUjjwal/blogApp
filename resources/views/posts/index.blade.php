@extends('layouts.app')
@section('content')
    <h1>Posts</h1>
    @if(count($posts)>0)    
            @foreach($posts as $post)
                <div class="well">
                    <div class="row">
                        <div class="col-md-1 col-sm-1">
                            <img width="100%" src="/storage/cover_image/{{$post->cover_image}}">
                        </div>
                        <div class="col-md-11 col-sm-11">
                            <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                            <small>Wriiten On {{$post->created_at}}</small>
                            <small>Wriiten By {{$post->user->name}}</small>
                            <hr>
                        </div>
                    </div>                    
                </div>
            @endforeach 
            {{$posts->links()}}
        @else
        <p>No Post Found</p>  
    @endif
@endsection