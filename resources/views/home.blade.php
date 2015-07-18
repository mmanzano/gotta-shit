@extends('layout.layout')

@section('content')
    <div class="container">
        <p>{{ Lang::get('shitguide.welcome') }}</p>
    </div>

    @foreach($places as $place)
        <div class="place">
            <div class="place-title">
                <h2>{{ $place->name }}</h2>
                <h3>latitude: {{ $place->geo_lat }} longitude: {{ $place->geo_lng }}</h3>
                <h4>Stars: {{ $place->star }}</h4>
                <h4>Comments:</h4>
                @foreach($place->comment as $comment)
                    <h5>User: {{ $comment->user_id }}</h5>
                    <p>{{ $comment->comment }}</p>
                @endforeach

            </div>
        </div>
    @endforeach
@endsection