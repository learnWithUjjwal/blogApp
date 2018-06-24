@extends('layouts.app')

@section('content')
    <table class="table table-stripped">
        @if(count($users)>0)
            <tr>
                <th>User</th>
                <th>No. of posts</th>
                <th>Delete User</th>
                <th>Edit User</th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{count($user->posts)}}</td>
                    <td>
                        {!! Form::open(['action'=>['HomeController@destroy', $user->id], 'method'=>'POST'])!!}
                        {!!Form::submit('Delete', ['class'=>'btn btn-danger'])!!}
                        {!!Form::hidden('_method', 'DELETE')!!}
                        {!!Form::close()!!}
                    </td>
                </tr>
            @endforeach
        @endif
    </table>

@endsection