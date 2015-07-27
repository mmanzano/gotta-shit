@extends('layout.layout')

@section('content')
    <form method="POST" action="/register">
        {!! csrf_field() !!}

        <div>
            <label for="full_name">
                Full Name
            </label>
            <input type="text" name="full_name" value="{{ old('full_name') }}" id="full_name">
        </div>
        <div>
            <label for="username">
                Username
            </label>
            <input type="text" name="username" value="{{ old('username') }}" id="username">
        </div>

        <div>
            <label for="email">
                Email
            </label>
            <input type="email" name="email" value="{{ old('email') }}" id="email">
        </div>

        <div>
            <label for="password">
                Password
            </label>
            <input type="password" name="password" id="password">
        </div>

        <div>
            <label for="password_confirmation">
                Confirm Password
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation">
        </div>

        <div>
            <button type="submit">Register</button>
        </div>
    </form>
@endsection