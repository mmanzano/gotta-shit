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
        <form method="POST" action="{{ route('password_email') }}">
            {!! csrf_field() !!}

            <div>
                <label class="input-label" for="email">
                    {{ ucfirst(Lang::get('gottashit.form.email')) }}
                </label>
                <input class="input" type="email" name="email" value="{{ old('email') }}" id="email">
            </div>

            <div>
                <button class="button" type="submit">{{ ucfirst(Lang::get('gottashit.form.sent_password_reset')) }}</button>
            </div>
        </form>
    </div>
@endsection

