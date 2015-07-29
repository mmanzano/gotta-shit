@extends('layout.layout')

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/place">
        {!! csrf_field() !!}

        <div>
            <label for="name">
                Name
            </label>
            <input type="name" name="name" value="{{ old('name') }}" id="name">
        </div>

        <div>
            <label for="geo_lat">
                Latitude
            </label>
            <input type="text" name="geo_lat"  value="{{ old('geo_lat') }}" id="geo_lat">
        </div>

        <div>
            <label for="geo_lng">
                Longitude
            </label>
            <input type="text" name="geo_lng"  value="{{ old('geo_lng') }}" id="geo_lng">
        </div>

        <div>
            <button type="submit">Create Place</button>
        </div>
    </form>
@endsection


@section('javascript')
@endsection