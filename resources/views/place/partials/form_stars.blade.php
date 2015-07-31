@if(old('stars') != "")
    <input type="radio" name="stars" value="0" @if(old('stars') == 0) checked @endif> <label for="stars"  class="radio">0</label>
    <input type="radio" name="stars" value="1" @if(old('stars') == 1) checked @endif> <label for="stars" class="radio">1</label>
    <input type="radio" name="stars" value="2" @if(old('stars') == 2) checked @endif> <label for="stars" class="radio">2</label>
    <input type="radio" name="stars" value="3" @if(old('stars') == 3) checked @endif> <label for="stars" class="radio">3</label>
    <input type="radio" name="stars" value="4" @if(old('stars') == 4) checked @endif> <label for="stars" class="radio">4</label>
    <input type="radio" name="stars" value="5" @if(old('stars') == 5) checked @endif> <label for="stars" class="radio">5</label>
@elseif(isset($place))

    <input type="radio" name="stars" value="0" @if($place->starForUser()['stars'] == 0) checked @endif> <label for="stars"  class="radio">0</label>
    <input type="radio" name="stars" value="1" @if($place->starForUser()['stars'] == 1) checked @endif> <label for="stars" class="radio">1</label>
    <input type="radio" name="stars" value="2" @if($place->starForUser()['stars'] == 2) checked @endif> <label for="stars" class="radio">2</label>
    <input type="radio" name="stars" value="3" @if($place->starForUser()['stars'] == 3) checked @endif> <label for="stars" class="radio">3</label>
    <input type="radio" name="stars" value="4" @if($place->starForUser()['stars'] == 4) checked @endif> <label for="stars" class="radio">4</label>
    <input type="radio" name="stars" value="5" @if($place->starForUser()['stars'] == 5) checked @endif> <label for="stars" class="radio">5</label>
@else
    <input type="radio" name="stars" value="0"> <label for="stars"  class="radio">0</label>
    <input type="radio" name="stars" value="1"> <label for="stars" class="radio">1</label>
    <input type="radio" name="stars" value="2"> <label for="stars" class="radio">2</label>
    <input type="radio" name="stars" value="3"> <label for="stars" class="radio">3</label>
    <input type="radio" name="stars" value="4"> <label for="stars" class="radio">4</label>
    <input type="radio" name="stars" value="5"> <label for="stars" class="radio">5</label>
@endif