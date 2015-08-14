<a name="comment-{{ $comment->id }}"></a>
<div id="place-comment-{{ $comment->id }}">
    <div class="place-comments-user">
        <p class="place-comments-user-name">
            {{ $comment->user->username }}<br/>
            <span class="place-comments-date">{{ $comment->created_at->diffForHumans() }}</span>
        </p>
        @if(($comment->isAuthor || $place->isAuthor) && ! $place->trashed())
        <div class="actions">
            <ul>

                @if($comment->isAuthor)
                <li>
                    <a  class="button button-action" href="{{ route('place_comment_edit_form', ['language' => App::getLocale(), 'place' => $place->id, 'comment' => $comment->id]) }}">{{ trans('gottashit.comment.edit_comment') }}</a>
                </li>
                @endif

                <li>
                    <form method="post" action="{{ route('place_comment_delete', ['language' => App::getLocale(), 'place' => $place->id, 'comment' => $comment->id]) }}" id='delete-comment-{{ $comment->id }}-form'>
                        {!! csrf_field() !!}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="button button-action button-delete-comment" type="submit" id="delete-comment-{{ $comment->id }}">{{ trans('gottashit.comment.delete_comment') }}</button>
                    </form>
                </li>

            </ul>
        </div>
        @endif
    </div>

    <div class="place-comments-body">
        {{ $comment->comment }}
    </div>
</div>