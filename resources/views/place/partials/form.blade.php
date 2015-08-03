<div>
    <label for="name">
        {{ ucfirst(Lang::get('gottatoshit.place.name')) }}
    </label>
    <input type="name" name="name" @if(old('name') != "") value="{{ old('name') }}" @elseif(isset($place)) value="{{ $place->name }}" @endif id="name">
</div>

<div class="place-map">
    <div class="place-map-render" id="place-map"></div>
    <div class="place-map-city"><input type="text" name="city" value="{{ old('city') }}" id="place-loc"></div>
    <div class="place-map-error" id="place-map-error"></div>
</div>
<div>
    <input type="hidden" name="geo_lat"  @if(old('geo_lat') != "") value="{{ old('geo_lat') }}" @elseif(isset($place)) value="{{ $place->geo_lat }}" @endif id="geo_lat">
</div>

<div>
    <input type="hidden" name="geo_lng"  @if(old('geo_lng') != "") value="{{ old('geo_lng') }}" @elseif(isset($place)) value="{{ $place->geo_lng }}" @endif id="geo_lng">
</div>

<div>
    <label for="stars">
        {{ ucfirst(Lang::get('gottatoshit.place.stars')) }}
    </label>
    @include('place/partials/form_stars')
</div>