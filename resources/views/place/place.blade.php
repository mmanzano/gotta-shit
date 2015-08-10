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
                    <li>
                        <a  class="button button-action" href="/place/{{ $place->id }}/edit">{{ ucfirst(trans('gottashit.place.edit_place')) }}</a>
                    </li>
                    <li>
                        <form method="post" action="/place/{{ $place->id }}">
                            {!! csrf_field() !!}
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="button button-action" type="submit">{{ ucfirst(trans('gottashit.place.delete_place')) }}</button>
                        </form>
                    </li>
                </ul>
            </div>
        @endif
        <h2>{{ $place->name }}</h2>
        @if(Auth::check())
            <div class="star-rate actions-rate">
                <ul>
                    <li>
                        <form method="POST" action="/place/{{ $place->id }}/stars">
                            {!! csrf_field() !!}
                            <input name="_method" type="hidden" value="PUT">
                            @include('place.partials.form_stars')
                            <button class="button button-rate" type="submit">{{ ucfirst(trans('gottashit.star.rate_place')) }}</button>
                        </form>
                    </li>
                    <li>
                        @if($place->starForUser()['id'])
                            <form method="POST" action="/place/{{ $place->id }}/stars">
                                {!! csrf_field() !!}
                                <input name="_method" type="hidden" value="DELETE">
                                <button class="button button-rate" type="submit">{{ ucfirst(trans('gottashit.star.delete_star')) }}</button>
                            </form>
                        @endif
                    </li>
                </ul>
            </div>
        @endif
    </div>

    <div class="place-map-render" id="map-{{ $place->id }}"></div>
    <div class="place-footer">
        <div class="place-stars">
            <div class="place-stars-background">
                <div class="place-stars-points" id="place-stars-points-{{ $place->id }}">
                </div>
            </div>
            <div class="place-stars-text">{{ $place->starForPlace()['average'] }} / {{ ucfirst(trans('gottashit.star.votes')) }}: {{ $place->starForPlace()['votes'] }}</div>
        </div>
        <div class="place-comments">
            <p class="place-comments-number">
                {{ trans_choice('gottashit.comment.comments', $place->numberOfComments, ['number_of_comments' => $place->numberOfComments]) }}
            </p>

            @foreach($place->comments as $comment)
                <a name="comment-{{ $comment->id }}"></a>
                <div class="place-comments-user">
                    <p class="place-comments-user-name">
                        {{ $comment->user->username }}<br/>
                        <span class="place-comments-date">{{ $comment->created_at->diffForHumans() }}</span>
                    </p>
                    @if($comment->isAuthor || $place->isAuthor)
                        <div class="actions">
                            <ul>
                                @if($comment->isAuthor)
                                    <li>
                                        <a  class="button button-action" href="/place/{{ $place->id }}/comment/{{ $comment->id }}/edit">{{ ucfirst(trans('gottashit.comment.edit_comment')) }}</a>
                                    </li>
                                @endif
                                <li>
                                    <form method="post" action="/place/{{ $place->id }}/comment/{{ $comment->id }}">
                                        {!! csrf_field() !!}
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button class="button button-action" type="submit">{{ ucfirst(trans('gottashit.comment.delete_comment')) }}</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
                <p class="place-comments-body">
                    {{ $comment->comment }}
                </p>
            @endforeach
            @if(Auth::check())
                <div class="forms">
                    <form method="POST" action="/place/{{ $place->id }}/comment">
                        {!! csrf_field() !!}
                        <div>
                            <label class="input-label" for="comment">
                                {{ ucfirst(trans('gottashit.comment.create_comment_label')) }}
                            </label>
                            @if(old('comment') != "")
                                <textarea class="textarea" name="comment" id="comment">{{ old('comment') }}</textarea>
                            @else
                                <textarea class="textarea" name="comment" id="comment"></textarea>
                            @endif
                        </div>

                        <div>
                            <button class="button" type="submit">{{ ucfirst(trans('gottashit.comment.create_comment')) }}</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
