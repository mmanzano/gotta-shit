<div>
    <label for="comment">
        {{ ucfirst(Lang::get('gottatoshit.place.comment')) }}
    </label>
    @if(old('comment') != "")
        <textarea cols="3" name="comment" id="comment">{{ old('comment') }}</textarea>
    @elseif(isset($editComment))
        <textarea cols="3" name="comment" id="comment">{{ $editComment->comment }}</textarea>
    @else
        <textarea cols="3" name="comment" id="comment"></textarea>
    @endif
</div>
