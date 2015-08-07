@extends('layout.layout_without_disclaimer')

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
        <form method="POST" action="{{ route('password_reset') }}">
            {!! csrf_field() !!}

            <input type="hidden" name="token" value="{{ $token }}">

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
                <button class="button" type="submit">{{ ucfirst(Lang::get('gottashit.form.reset_password')) }}</button>
            </div>
        </form>
    </div>
@endsection