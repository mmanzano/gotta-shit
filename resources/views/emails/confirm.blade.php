@extends('layout.layout_email')

@section('email_title')
    Sign Up Confirmation
@endsection

@section('email_content')

    <h1>Thanks for signing up!</h1>

    <p>
        We just need you to <a href='{{ url("register/confirm/{$user->token}") }}'>confirm your email address</a> real quick!
    </p>

@endsection