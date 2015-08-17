@extends('layout.layout')

@section('content')
    <div class="home">
        <div class="home-help">
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