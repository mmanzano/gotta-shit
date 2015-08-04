<div>
    <label for="comment">
        {{ ucfirst(Lang::get('gottashit.place.update_comment')) }}
    </label>
    @if(old('comment') != "")
        <textarea cols="3" name="comment" id="comment">{{ old('comment') }}</textarea>
    @elseif(isset($comment))
        <textarea cols="3" name="comment" id="comment">{{ $comment->comment }}</textarea>
    @else
        <textarea cols="3" name="comment" id="comment"></textarea>
    @endif
</div>
