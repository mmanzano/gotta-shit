@extends('layout.layout')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        {!! csrf_field() !!}

        <div>
            <label for="email">
                {{ ucfirst(Lang::get('shitguide.form.email')) }}
            </label>
            <input type="email" name="email" value="{{ old('email') }}" id="email">
        </div>

        <div>
            <label for="password">
                {{ ucfirst(Lang::get('shitguide.form.password')) }}
            </label>
            <input type="password" name="password" id="password">
        </div>

        <div>
            <input type="checkbox" name="remember" id="remember"> <label for="remember" class="checkbox">{{ ucfirst(Lang::get('shitguide.form.remember_me')) }}</label>
        </div>

        <div>
            <button type="submit">{{ ucfirst(Lang::get('shitguide.form.login')) }}</button>
        </div>
    </form>
@endsection

