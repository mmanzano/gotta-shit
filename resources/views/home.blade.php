@extends('layout.layout')

@section('content')
    Welcome to ShitGuide. I love this site.

    @include('place.places_show')
@endsection

@section('javascript')
        @foreach($places as $place)
            @include('js.place')
        @endforeach
        @include('js.nearest')
        @include('js.hover')
@endsection