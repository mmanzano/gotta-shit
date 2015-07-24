@extends('layout.layout')

@section('content')
    <div class="container">
        <p>{{ Lang::get('shitguide.welcome') }}</p>
    </div>

    @include('blocks.place')
@endsection

@section('javascript')
    <script>
        @include('js/place')
    </script>
@endsection