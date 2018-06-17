@extends('layouts.app')
@section('content')
    <div class="app">
        <div class="jumbotron">
            <center>
                <p class="lead"><h3>Welcome to LAWLUG BLOGPOST</h3></p>
                <hr class="my-4">
                <p>
                    This is the first application of laravel
                </p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">Login</a>
                    <a class="btn btn-success btn-lg" href="{{ route('register') }}" role="button">Register</a>
                </p>
                
            </center>
        </div>
    </div>
@endsection