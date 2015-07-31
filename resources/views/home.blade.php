@extends('layout.layout')

@section('content')
    @include('place.places_home')
@endsection

@section('javascript')
        @foreach($places as $place)
            @include('js.place')
        @endforeach
@endsection