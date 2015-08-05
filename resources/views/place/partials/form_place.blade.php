<div>
    <label class="input-label" for="name">
        {{ ucfirst(Lang::get('gottashit.place.name')) }}
    </label>
    <input class="input" type="name" name="name" @if(old('name') != "") value="{{ old('name') }}" @elseif(isset($place)) value="{{ $place->name }}" @endif id="name">
</div>

<div class="place-map">
    <div class="place-map-form-map" id="place-map"></div>
    <div class="place-map-form-city"><input class="input" type="text" name="city" value="{{ old('city') }}" id="place-loc"></div>
    <div class="place-map-form-error" id="place-map-error"></div>
</div>
<div>
    <input type="hidden" name="geo_lat"  @if(old('geo_lat') != "") value="{{ old('geo_lat') }}" @elseif(isset($place)) value="{{ $place->geo_lat }}" @endif id="geo_lat">
</div>

<div>
    <input type="hidden" name="geo_lng"  @if(old('geo_lng') != "") value="{{ old('geo_lng') }}" @elseif(isset($place)) value="{{ $place->geo_lng }}" @endif id="geo_lng">
</div>

<div>
    <label class="input-label" for="stars">
        {{ ucfirst(Lang::get('gottashit.place.stars')) }}
    </label>
    @include('place.partials.form_stars')
</div>