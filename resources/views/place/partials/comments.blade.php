<div>
    <label class="input-label" for="comment">
        {{ ucfirst(Lang::get('gottashit.comment.update_comment')) }}
    </label>
    @if(old('comment') != "")
        <textarea class="textarea" name="comment" id="comment">{{ old('comment') }}</textarea>
    @elseif(isset($comment))
        <textarea class="textarea" name="comment" id="comment">{{ $comment->comment }}</textarea>
    @else
        <textarea class="textarea" name="comment" id="comment"></textarea>
    @endif
</div>
