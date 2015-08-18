@extends('layout.layout_email')

@section('email_title')
    {{ trans('gottashit.email.new_comment_add', ['place' => $place->name]) }}
@endsection

@section('email_content')

    <h1>{{ $subscriber->username }}, {{ trans('gottashit.email.new_comment_add', ['place' => $place->name]) }}</h1>

    <p>
        {!! trans('gottashit.email.new_comment_action', [
            'path' => url("$path"),
            'place' => $place->name,
            'username_author_of_comment'=> $author_of_comment->username,
            'path_author_of_comment' => url($path_author_of_comment)
            ]) !!}
    </p>

@endsection