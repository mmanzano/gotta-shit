@extends('layout.layout_email')

@section('email_title')
    {{ trans('gottashit.email.new_contact_form') }}
@endsection

@section('email_content')

    <h1>{{ trans('gottashit.email.new_contact_form') }}</h1>

    <p>
        Email: {{ $email }}
    </p>
    <p>
        Body: {{ $body }}
    </p>

@endsection