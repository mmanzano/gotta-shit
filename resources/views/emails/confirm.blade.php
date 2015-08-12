@extends('layout.layout_email')

@section('email_title')
    {{ trans('gottashit.email.confirm_email_subject') }}
@endsection

@section('email_content')

    <h1>{{ trans('gottashit.email.confirm_email_thanks') }}</h1>

    <p>
        {!! trans('gottashit.email.confirm_email_action', ['path' => url("$path")]) !!}
    </p>

@endsection