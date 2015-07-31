<div>
    <label for="comment">
        {{ ucfirst(Lang::get('gottatoshit.place.comment')) }}
    </label>
    <textarea cols="3" name="comment" id="comment">@if(old('comment') != ""){{ old('comment') }}@endif</textarea>
</div>
