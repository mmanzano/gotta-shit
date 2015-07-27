@extends('layout.layout')

@section('content')
    @include('blocks.places_home')
@endsection

@section('javascript')
    <script>
        @foreach($places as $place)
            @include('js/place')
        @endforeach
    </script>
@endsection