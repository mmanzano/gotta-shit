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
        <form method="POST" action="{{ route('user_register', ['language' => App::getLocale()]) }}">
            {!! csrf_field() !!}

            @include('auth.partials.user_form')

            <div>
                <button class="button" type="submit">{{ ucfirst(trans('gottashit.user.register')) }}</button>
            </div>
        </form>
    </div>
@endsection