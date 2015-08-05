@if(old('stars') != "")
    <input class="radio" type="radio" name="stars" value="0" @if(old('stars') == 0) checked @endif> <label class="radio-label" for="stars">0</label>
    <input class="radio" type="radio" name="stars" value="1" @if(old('stars') == 1) checked @endif> <label class="radio-label" for="stars">1</label>
    <input class="radio" type="radio" name="stars" value="2" @if(old('stars') == 2) checked @endif> <label class="radio-label" for="stars">2</label>
    <input class="radio" type="radio" name="stars" value="3" @if(old('stars') == 3) checked @endif> <label class="radio-label" for="stars">3</label>
    <input class="radio" type="radio" name="stars" value="4" @if(old('stars') == 4) checked @endif> <label class="radio-label" for="stars">4</label>
    <input class="radio" type="radio" name="stars" value="5" @if(old('stars') == 5) checked @endif> <label class="radio-label" for="stars">5</label>
@elseif(isset($place))
    <input class="radio" type="radio" name="stars" value="0" @if($place->starForUser()['stars'] == 0) checked @endif> <label class="radio-label" for="stars">0</label>
    <input class="radio" type="radio" name="stars" value="1" @if($place->starForUser()['stars'] == 1) checked @endif> <label class="radio-label" for="stars">1</label>
    <input class="radio" type="radio" name="stars" value="2" @if($place->starForUser()['stars'] == 2) checked @endif> <label class="radio-label" for="stars">2</label>
    <input class="radio" type="radio" name="stars" value="3" @if($place->starForUser()['stars'] == 3) checked @endif> <label class="radio-label" for="stars">3</label>
    <input class="radio" type="radio" name="stars" value="4" @if($place->starForUser()['stars'] == 4) checked @endif> <label class="radio-label" for="stars">4</label>
    <input class="radio" type="radio" name="stars" value="5" @if($place->starForUser()['stars'] == 5) checked @endif> <label class="radio-label" for="stars">5</label>
@else
    <input class="radio" type="radio" name="stars" value="0"> <label class="radio-label" for="stars" >0</label>
    <input class="radio" type="radio" name="stars" value="1"> <label class="radio-label" for="stars">1</label>
    <input class="radio" type="radio" name="stars" value="2"> <label class="radio-label" for="stars">2</label>
    <input class="radio" type="radio" name="stars" value="3"> <label class="radio-label" for="stars">3</label>
    <input class="radio" type="radio" name="stars" value="4"> <label class="radio-label" for="stars">4</label>
    <input class="radio" type="radio" name="stars" value="5"> <label class="radio-label" for="stars">5</label>
@endif