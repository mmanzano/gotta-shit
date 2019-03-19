@extends('layout.layout')

@section('content')
    <div class="home">
        <div class="home-help">
            <form action="{{ route('contact') }}" method="POST" id="contact-form">
                {!! csrf_field() !!}
                <input class="input" name="email" type="email" value="{{ old('email') }}" placeholder="{{ trans('gottashit.contact_form.email') }}"/>
                <input class="input" name="subject" value="{{ old('subject') }}" placeholder="{{ trans('gottashit.contact_form.subject') }}"/>
                <textarea class="textarea-home" name="body" placeholder="{{ trans('gottashit.contact_form.body') }}">{{ old('body') }}</textarea>
                <div id='recaptcha' class="g-recaptcha"
                     data-sitekey="{{ config('services.recaptcha.client_secret') }}"
                     data-callback="onSubmit"
                     data-size="invisible"></div>
                <button class="button" type="submit" id="action">{{ ucfirst(trans('gottashit.contact_form.send')) }}</button>
            </form>
            <iframe width="90%" height="315" src="https://www.youtube.com/embed/NmemOdsMtcg" frameborder="0" allowfullscreen></iframe>
            {!! trans('gottashit.home') !!}
        </div>
        <div class='home-places'>
            @include('place.places_show')
        </div>
    </div>
@endsection

@section('scripts_head_section')
    <script>
        function onSubmit(token) {
            document.getElementById('contact-form').submit();
        }

        function validate(event) {
            event.preventDefault();
            grecaptcha.execute();
        }

        function onload() {
            let element = document.getElementById('action');
            element.onclick = validate;
        }
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

@section('javascript')
    <script>
        onload();
    </script>
    <script src="{{ asset('/js/gottashit_place.js') }}"></script>
@endsection