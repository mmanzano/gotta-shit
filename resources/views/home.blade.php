@extends('layout.layout')

@section('content')
    <div class="home">
        <div class="home-help">
            <form action="{{ route('contact') }}" method="POST">
                {!! csrf_field() !!}
                <input class="input" name="email" type="email" value="{{ old('email') }}" placeholder="{{ trans('gottashit.contact_form.email') }}"/>
                <input class="input" name="subject" value="{{ old('subject') }}" placeholder="{{ trans('gottashit.contact_form.subject') }}"/>
                <textarea class="textarea-home" name="body" placeholder="{{ trans('gottashit.contact_form.body') }}">{{ old('body') }}</textarea>
                <button class="button" type="submit">{{ ucfirst(trans('gottashit.contact_form.send')) }}</button>
            </form>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/NmemOdsMtcg" frameborder="0" allowfullscreen></iframe>
            {!! trans('gottashit.home') !!}
        </div>
        <div class='home-places'>
            @include('place.places_show')
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('/js/gottashit_place.js') }}"></script>
@endsection