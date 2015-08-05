@extends('layout.layout')

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
        <form method="POST" action="/register">
            {!! csrf_field() !!}

            <div>
                <label class="input-label" for="full_name">
                    {{ ucfirst(Lang::get('gottashit.form.full_name')) }}
                </label>
                <input class="input" type="text" name="full_name" value="{{ old('full_name') }}" id="full_name">
            </div>
            <div>
                <label class="input-label" for="username">
                    {{ ucfirst(Lang::get('gottashit.form.username')) }}
                </label>
                <input class="input" type="text" name="username" value="{{ old('username') }}" id="username">
            </div>

            <div>
                <label class="input-label" for="email">
                    {{ ucfirst(Lang::get('gottashit.form.email')) }}
                </label>
                <input class="input" type="email" name="email" value="{{ old('email') }}" id="email">
            </div>

            <div>
                <label class="input-label" for="password">
                    {{ ucfirst(Lang::get('gottashit.form.password')) }}
                </label>
                <input class="input" type="password" name="password" id="password">
            </div>

            <div>
                <label class="input-label" for="password_confirmation">
                    {{ ucfirst(Lang::get('gottashit.form.confirm_password')) }}
                </label>
                <input class="input" type="password" name="password_confirmation" id="password_confirmation">
            </div>

            <div>
                <button class="button" type="submit">{{ ucfirst(Lang::get('gottashit.form.register')) }}</button>
            </div>
        </form>
    </div>
@endsection