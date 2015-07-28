@extends('layout.layout')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        {!! csrf_field() !!}

        <div>
            <label for="email">
                Email
            </label>
            <input type="email" name="email" value="{{ old('email') }}" id="email">
        </div>

        <div>
            <label for="password">
                Password
            </label>
            <input type="password" name="password" id="password">
        </div>

        <div>
            <input type="checkbox" name="remember" id="remember"> <label for="remember" class="checkbox">Remember Me</label>
        </div>

        <div>
            <button type="submit">Login</button>
        </div>
    </form>
@endsection

