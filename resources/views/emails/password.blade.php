@extends('layout.layout_email')

@section('email_title')
    Reset Your Password
@endsection

@section('email_content')

    <p>
        Click here to reset your password: {{ url('password/reset/'.$token) }}
    </p>

@endsection
