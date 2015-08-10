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
        <form method="POST" action="{{ route('password_email') }}">
            {!! csrf_field() !!}

            <div>
                <label class="input-label" for="email">
                    {{ ucfirst(trans('gottashit.user.email')) }}
                </label>
                <input class="input" type="email" name="email" value="{{ old('email') }}" id="email">
            </div>

            <div>
                <button class="button" type="submit">{{ ucfirst(trans('gottashit.user.sent_password_reset')) }}</button>
            </div>
        </form>
    </div>
@endsection

