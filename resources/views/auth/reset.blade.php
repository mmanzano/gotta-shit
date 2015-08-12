@extends('layout.layout_without_call_to_action')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="forms">
        <form method="POST" action="{{ route('user_password_reset', ['language' => App::getLocale()]) }}">
            {!! csrf_field() !!}

            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="input-label" for="email">
                    {{ ucfirst(trans('gottashit.user.email')) }}
                </label>
                <input class="input" type="email" name="email" value="{{ old('email') }}" id="email">
            </div>

            <div>
                <label class="input-label" for="password">
                    {{ ucfirst(trans('gottashit.user.password')) }}
                </label>
                <input class="input" type="password" name="password" id="password">
            </div>

            <div>
                <label class="input-label" for="password_confirmation">
                    {{ ucfirst(trans('gottashit.user.confirm_password')) }}
                </label>
                <input class="input" type="password" name="password_confirmation" id="password_confirmation">
            </div>

            <div>
                <button class="button" type="submit">{{ ucfirst(trans('gottashit.user.reset_password')) }}</button>
            </div>
        </form>
    </div>
@endsection