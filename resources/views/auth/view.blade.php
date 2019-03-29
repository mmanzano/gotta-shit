@extends('layout.layout_without_call_to_action')

@section('content')

    <div class="user-profile">

        <p class="user-label">{{ trans('gottashit.user.username') }}: <span class="user-data">{{ $user->username }}</span></p>

        @if($is_user)
            @if($user->modified)
                <p class="user-label">{{ trans('gottashit.user.no_notifications_warning') }}</p>
            @endif

            <p class="user-label">{{ trans('gottashit.user.full_name')}}: <span class="user-data">{{ $user->full_name }}</span></p>
            <p class="user-label">{{ trans('gottashit.user.email')}}: <span class="user-data">{{ $user->email }}</span></p>
            <a class="button edit-user" href="{{ route('user.edit', ['user' => $user->id]) }}">{{ trans('gottashit.user.edit_user') }}</a>
            @if(is_null($user->twitter_id))
                <a class="button edit-user" href="{{ route('social_login', ['provider' => 'twitter']) }}">{{ trans('gottashit.user.add_twitter') }}</a>
            @endif
            @if(is_null($user->github_id))
                <a class="button edit-user" href="{{ route('social_login', ['provider' => 'github']) }}">{{ trans('gottashit.user.add_github') }}</a>
            @endif
        @endif

        <p class="user-label">{{ trans('gottashit.user.number_of_places') }}: <span class="user-data">{{ $user->number_of_places }}</span></p>

        @if($is_user)
            <div class="user-label">
                @foreach($user->places as $place)
                    <a class="user-link" href="{{ $place->path }}">{{ $place->name }}</a>
                @endforeach
            </div>
        @endif

        <p class="user-label">{{ trans('gottashit.user.number_of_archived_places') }}: <span class="user-data">{{ $user->number_of_trashed_places }}</span></p>

        @if($is_user)
            <div class="user-label">
                @foreach($user->placesTrashed as $place)
                    <a class="user-link" href="{{ $place->path }}">{{ $place->name }}</a>
                @endforeach
            </div>
        @endif


        <p class="user-label">{{ trans('gottashit.user.number_of_rated_places') }}: <span class="user-data">{{ $user->number_of_rated_places }}</span></p>

        @if($is_user)
            <div class="user-label">
                @foreach($user->stars as $star)
                    <a class="user-link" href="{{ $star->place->path }}">{{ $star->place->name }}</a>
                @endforeach
            </div>
        @endif

    </div>

@endsection