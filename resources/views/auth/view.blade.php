@extends('layout.layout_without_call_to_action')

@section('content')

    <div class="user-profile">
        <p class="user-label">{{ trans('gottashit.user.full_name')}}: <span class="user-data">{{ $user->full_name }}</span></p>
        <p class="user-label">{{ trans('gottashit.user.username') }}: <span class="user-data">{{ $user->username }}</span></p>

        @if($is_user)
            <a class="button edit-user" href="/user/{{ $user->id }}/edit">{{ trans('gottashit.user.edit_user') }}</a>
        @endif

        <p class="user-label">{{ trans('gottashit.user.number_of_places') }}: <span class="user-data">{{ $user->numberOfPlaces }}</span></p>

        <div class="user-label">
            @foreach($user->places as $place)
                <a class="user-link" href="/place/{{ $place->id }}">{{ $place->name }}</a>
            @endforeach
        </div>

        <p class="user-label">{{ trans('gottashit.user.number_of_places_rated') }}: <span class="user-data">{{ $user->numberOfPlacesRated }}</span></p>

    </div>

@endsection