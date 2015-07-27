@extends('layout.layout')

@section('content')
    @include('blocks.place')
@endsection

@section('javascript')
    <script>
        @include('js/place')
    </script>
@endsection