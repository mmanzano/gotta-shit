@extends('layout.layout_email')

@section('email_title')
    {{ trans('gottashit.email.new_comment_add') }}
@endsection

@section('email_content')

    <h1>{{ trans('gottashit.email.new_comment_add') }}</h1>

    <p>
        {!! trans('gottashit.email.new_comment_action', ['path' => url("$path"), 'place' => $place->name, 'username'=> $user->username, 'path_user' => url($path_user)]) !!}
    </p>

@endsection