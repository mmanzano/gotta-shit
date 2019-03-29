@extends('layout.layout')

@section('content')
    @include('place.places_show')
    <div class="pagination-nav">
        {!! $places->render() !!}
    </div>
@endsection

@section('javascript')
    <script src="{{ mix('/js/gottashit_place.js') }}"></script>
@endsection