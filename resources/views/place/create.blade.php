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
    <div class="forms">
        <form method="POST" action="/place">
            {!! csrf_field() !!}

            <div>
                <label for="name">
                    {{ ucfirst(Lang::get('gottatoshit.place.name')) }}
                </label>
                <input type="name" name="name" value="{{ old('name') }}" id="name">
            </div>

            <div>
                <input type="text" name="city" value="{{ old('city') }}" id="place-loc">
                <div id="place-map-error"></div>
                <div id="place-map" style="width:80%;height:300px"></div>
            </div>
            <div>
                <input type="hidden" name="geo_lat"  value="{{ old('geo_lat') }}" id="geo_lat">
            </div>

            <div>
                <input type="hidden" name="geo_lng"  value="{{ old('geo_lng') }}" id="geo_lng">
            </div>

            <div>
                <label for="stars">
                    {{ ucfirst(Lang::get('gottatoshit.place.stars')) }}
                </label>
                <input type="radio" name="stars" value="0" @if(old('stars') == 0) checked @endif> <label for="stars"  class="radio">0</label>
                <input type="radio" name="stars" value="1" @if(old('stars') == 1) checked @endif> <label for="stars" class="radio">1</label>
                <input type="radio" name="stars" value="2" @if(old('stars') == 2) checked @endif> <label for="stars" class="radio">2</label>
                <input type="radio" name="stars" value="3" @if(old('stars') == 3) checked @endif> <label for="stars" class="radio">3</label>
                <input type="radio" name="stars" value="4" @if(old('stars') == 4) checked @endif> <label for="stars" class="radio">4</label>
                <input type="radio" name="stars" value="5" @if(old('stars') == 5) checked @endif> <label for="stars" class="radio">5</label>
            </div>
            <div>
                <button type="submit">{{ ucfirst(Lang::get('gottatoshit.place.create_place')) }}</button>
            </div>
        </form>
    </div>
@endsection


@section('javascript')
    @include('js/place_field')
@endsection