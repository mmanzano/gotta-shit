<div>
    <label for="name">
        {{ ucfirst(Lang::get('gottatoshit.place.name')) }}
    </label>
    <input type="name" name="name" value="@if(old('name') != "") {{ old('name') }} @elseif(isset($place)) {{ $place->name }} @endif" id="name">
</div>

<div>
    <input type="text" name="city" value="{{ old('city') }}" id="place-loc">
    <div id="place-map-error"></div>
    <div id="place-map" style="width:80%;height:300px"></div>
</div>
<div>
    <input type="hidden" name="geo_lat"  value="@if(old('geo_lat') != "") {{ old('geo_lat') }} @elseif(isset($place)) {{ $place->geo_lat }} @endif" id="geo_lat">
</div>

<div>
    <input type="hidden" name="geo_lng"  value="@if(old('geo_lng') != "") {{ old('geo_lng') }} @elseif(isset($place)) {{ $place->geo_lng }} @endif" id="geo_lng">
</div>

<div>
    <label for="stars">
        {{ ucfirst(Lang::get('gottatoshit.place.stars')) }}
    </label>
    @if(old('stars') != "")
        <input type="radio" name="stars" value="0" @if(old('stars') == 0) checked @endif> <label for="stars"  class="radio">0</label>
        <input type="radio" name="stars" value="1" @if(old('stars') == 1) checked @endif> <label for="stars" class="radio">1</label>
        <input type="radio" name="stars" value="2" @if(old('stars') == 2) checked @endif> <label for="stars" class="radio">2</label>
        <input type="radio" name="stars" value="3" @if(old('stars') == 3) checked @endif> <label for="stars" class="radio">3</label>
        <input type="radio" name="stars" value="4" @if(old('stars') == 4) checked @endif> <label for="stars" class="radio">4</label>
        <input type="radio" name="stars" value="5" @if(old('stars') == 5) checked @endif> <label for="stars" class="radio">5</label>'
    @elseif(isset($place))
        <input type="radio" name="stars" value="0" @if(old('stars') == 0) checked @endif> <label for="stars"  class="radio">0</label>
        <input type="radio" name="stars" value="1" @if(old('stars') == 1) checked @endif> <label for="stars" class="radio">1</label>
        <input type="radio" name="stars" value="2" @if(old('stars') == 2) checked @endif> <label for="stars" class="radio">2</label>
        <input type="radio" name="stars" value="3" @if(old('stars') == 3) checked @endif> <label for="stars" class="radio">3</label>
        <input type="radio" name="stars" value="4" @if(old('stars') == 4) checked @endif> <label for="stars" class="radio">4</label>
        <input type="radio" name="stars" value="5" @if(old('stars') == 5) checked @endif> <label for="stars" class="radio">5</label>'
     @endif
</div>
<div>
    <button type="submit">{{ ucfirst(Lang::get('gottatoshit.place.create_place')) }}</button>
</div>