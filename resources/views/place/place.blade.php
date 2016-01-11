<div class="place">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="place-title">
        @if($place->isAuthor)
            <div class="actions">
                <ul>
                    @if(! $place->trashed())
                        <li>
                            <a  class="button button-action" href="{{ route('place.edit', ['language' => App::getLocale(), 'place' => $place->id]) }}">{{ trans('gottashit.place.edit_place') }}</a>
                        </li>
                    @else
                        <li>
                            <form method="post" action="{{ route('place.restore', ['language' => App::getLocale(), 'place' => $place->id]) }}">
                                {!! csrf_field() !!}
                                <input name="_method" type="hidden" value="POST">
                                <button class="button button-action" type="submit">
                                        {{ trans('gottashit.place.restore_place') }}
                                </button>
                            </form>
                        </li>
                    @endif
                    <li>
                        <form method="post" action="{{ route('place.destroy', ['language' => App::getLocale(), 'place' => $place->id]) }}">
                            {!! csrf_field() !!}
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="button button-action button-delete-place" type="submit" id="delete-place-{{ $place->id }}">
                                @if($place->trashed())
                                    {{ trans('gottashit.place.delete_place_permanently') }}
                                @else
                                    {{ trans('gottashit.place.delete_place') }}
                                @endif
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @endif
        <h2>{{ $place->name }}</h2>
        @if(! $place->trashed())
            @if(Auth::check())
                <div class="star-rate actions-rate">
                    <ul>
                        <li>
                            <form method="POST" action="{{ route('place_stars_edit', ['language' => App::getLocale(), 'place' => $place->id]) }}">
                                {!! csrf_field() !!}
                                <input name="_method" type="hidden" value="PUT">
                                @include('place.partials.form_stars')
                                <button class="button button-rate button-rate-this" type="submit">{{ trans('gottashit.star.rate_place') }}</button>
                            </form>
                        </li>

                        @if($place->user_has_voted)
                            @include('place.partials.delete_rate')
                        @endif

                    </ul>
                </div>
            @endif
        @endif
    </div>

    <div class="place-map-render" id="map-{{ $place->id }}"></div>
    <div class="place-footer">
        <div class="place-stars">
            <div class="place-stars-background">
                <div class="place-stars-points" id="place-stars-points-{{ $place->id }}">
                </div>
            </div>
            <div class="place-stars-text">{{ $place->stars_average }} / {{ trans('gottashit.star.votes') }}: {{ $place->stars_amount }}</div>
        </div>
        <div class="place-comments">
             <div class="place-comments-number">
                @if (! $place->trashed())
                    @if(Auth::check())
                        <div class="actions actions-subscribe">
                            <ul>
                                @if(! $place->isSubscribed)
                                    <li>
                                        @include('place.subscription.add')
                                    </li>
                                @else
                                    <li>
                                        @include('place.subscription.remove')
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif
                @endif
                <p>{{ trans_choice('gottashit.comment.comments', $place->numberOfComments, ['number_of_comments' => $place->numberOfComments]) }}</p>
            </div>

            <div id="place-comments-list">
                @foreach($place->commentsWithTrashed as $comment)
                    @include('place.comment.view')
                @endforeach
            </div>
            @if(! $place->trashed())
                @if(Auth::check())
                    <div class="forms">
                        <form method="POST" action="{{ route('place_comment_create', ['language' => App::getLocale(), 'place' => $place->id]) }}" class="create-comment-form">
                            {!! csrf_field() !!}
                            <div>
                                <label class="input-label" for="comment">
                                    {{ trans('gottashit.comment.create_comment_label') }}
                                </label>
                                @if(old('comment') != "")
                                    <textarea class="textarea" name="comment" id="comment-textarea">{{ old('comment') }}</textarea>
                                @else
                                    <textarea class="textarea" name="comment" id="comment-textarea"></textarea>
                                @endif
                            </div>

                            <div>
                                <button class="button button-create-comment" type="submit">{{ trans('gottashit.comment.create_comment') }}</button>
                            </div>
                        </form>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
