@if(old('stars') != "")

    <input id="stars-1" class="radio rate-star @if(old('stars') > 1) input-checked @endif" type="radio" name="stars" value="1" @if(old('stars') == 1) checked @endif>
    <label class="radio-label" for="stars-1">1</label>

    <input id="stars-2" class="radio rate-star @if(old('stars') > 2) input-checked @endif" type="radio" name="stars" value="2" @if(old('stars') == 2) checked @endif>
    <label class="radio-label" for="stars-2">2</label>

    <input id="stars-3" class="radio rate-star @if(old('stars') > 3) input-checked @endif" type="radio" name="stars" value="3" @if(old('stars') == 3) checked @endif>
    <label class="radio-label" for="stars-3">3</label>

    <input id="stars-4" class="radio rate-star @if(old('stars') > 4) input-checked @endif" type="radio" name="stars" value="4" @if(old('stars') == 4) checked @endif>
    <label class="radio-label" for="stars-4">4</label>

    <input id="stars-5" class="radio rate-star @if(old('stars') > 5) input-checked @endif" type="radio" name="stars" value="5" @if(old('stars') == 5) checked @endif>
    <label class="radio-label" for="stars-5">5</label>

@elseif(isset($place))

    <input id="stars-1" class="radio rate-star @if($place->current_user_vote > 1) input-checked @endif" type="radio" name="stars" value="1" @if($place->current_user_vote == 1) checked @endif>
    <label class="radio-label" for="stars-1">1</label>

    <input id="stars-2" class="radio rate-star @if($place->current_user_vote > 2) input-checked @endif" type="radio" name="stars" value="2" @if($place->current_user_vote == 2) checked @endif>
    <label class="radio-label" for="stars-2">2</label>

    <input id="stars-3" class="radio rate-star @if($place->current_user_vote > 3) input-checked @endif" type="radio" name="stars" value="3" @if($place->current_user_vote == 3) checked @endif>
    <label class="radio-label" for="stars-3">3</label>

    <input id="stars-4" class="radio rate-star @if($place->current_user_vote > 4) input-checked @endif" type="radio" name="stars" value="4" @if($place->current_user_vote == 4) checked @endif>
    <label class="radio-label" for="stars-4">4</label>

    <input id="stars-5" class="radio rate-star @if($place->current_user_vote > 5) input-checked @endif" type="radio" name="stars" value="5" @if($place->current_user_vote == 5) checked @endif>
    <label class="radio-label" for="stars-5">5</label>

@else

    <input id="stars-1" class="radio rate-star" type="radio" name="stars" value="1">
    <label class="radio-label" for="stars-1">1</label>

    <input id="stars-2" class="radio rate-star" type="radio" name="stars" value="2">
    <label class="radio-label" for="stars-2">2</label>

    <input id="stars-3" class="radio rate-star" type="radio" name="stars" value="3">
    <label class="radio-label" for="stars-3">3</label>

    <input id="stars-4" class="radio rate-star" type="radio" name="stars" value="4">
    <label class="radio-label" for="stars-4">4</label>

    <input id="stars-5" class="radio rate-star" type="radio" name="stars" value="5">
    <label class="radio-label" for="stars-5">5</label>

@endif