@extends('layout.layout')

@section('content')
    <div class="home">
        <div class="home-help">
            <p>Welcome to Gotta Shit.</p>

            <p>You got to shit? This is your site</p>
            <p>In this site you can:
                <ul>
                    <li>Encounter the better sites to shit in your near zone</li>
                    <li>View the valoration of the place</li>
                    <li>View the opinions of the users</li>
                </ul>
            </p>
            <p>If you register</p>
                <ul>
                    <li>Can add new toilets to shit</li>
                    <li>Can add the experience on the toilets</li>
                    <li>Can evaluate other toilets and comment this</li>
                </ul>
            <p>Register now and join us.</p>
        </div>
        <div class='home-places'>
            @include('place.places_show')
        </div>
    </div>
@endsection

@section('javascript')
        @foreach($places as $place)
            @include('js.place')
        @endforeach
        @include('js.nearest')
        @include('js.hover')
@endsection