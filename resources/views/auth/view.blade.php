@extends('layout.layout_without_call_to_action')

@section('content')

    @if($is_user)
        <p><a class="button" href="/user/{{ $user->id }}/edit">{{ trans('gottashit.user.edit_user') }}</a></p>
    @endif
    <p>{{ $is_user }}</p>
    <p>{{ trans('gottashit.user.full_name')}}: {{ $user->full_name }}</p>
    <p>{{ trans('gottashit.user.places') }}: 5</p>


@endsection