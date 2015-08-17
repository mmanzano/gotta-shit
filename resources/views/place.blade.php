@extends('layout.layout')

@section('content')
    @include('place.place')
@endsection

@section('javascript')
    <script src="{{ asset('/js/gottashit_place.js') }}"></script>
@endsection