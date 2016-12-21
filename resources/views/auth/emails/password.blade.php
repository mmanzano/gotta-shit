@extends('layout.layout_email')

@section('email_title')
    {{ trans('gottashit.email.reset_password_subject') }}
@endsection

@section('email_content')

    <h1>{{ trans('gottashit.email.reset_password_thanks') }}</h1>

    <p>
        {!! trans('gottashit.email.reset_password_action', ['path' => url(App::getLocale() . '/password/reset/'.$token)]) !!}
    </p>

@endsection
