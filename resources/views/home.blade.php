@extends('layout.layout')

@section('content')
    <div class="home">
        <div class="home-help">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/W2DAxnl2ppA" frameborder="0" allowfullscreen></iframe>
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