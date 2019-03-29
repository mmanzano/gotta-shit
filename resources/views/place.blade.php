@extends('layout.layout')

@section('content')
    @include('place.place')
@endsection

@section('javascript')
    <script src="{{ mix('/js/gottashit_place.js') }}"></script>
@endsection