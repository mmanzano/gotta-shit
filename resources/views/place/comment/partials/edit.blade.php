<div class="comment-edit-box">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="forms">
        <form method="POST" action="{{ route('place.comment.update', ['language' => App::getLocale(), 'place' => $place->id, 'comment' => $comment->id]) }}" class="create-comment-form">
            {!! csrf_field() !!}
            <input name="_method" type="hidden" value="PUT">
            @include('place.partials.comments')
            <div>
                <button class="button button-create-comment" type="submit">{{ ucfirst(trans('gottashit.comment.update_comment')) }}</button>
            </div>
        </form>
    </div>
</div>