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
                        <a  class="button button-action" href="/place/{{ $place->id }}/edit">{{ ucfirst(Lang::get('gottashit.form.edit')) }}</a>
                    </li>
                    <li>
                        <form method="post" action="/place/{{ $place->id }}">
                            {!! csrf_field() !!}
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="button button-action" type="submit">{{ ucfirst(Lang::get('gottashit.form.delete')) }}</button>
                        </form>
                    </li>
                </ul>
            </div>
        @endif
        <h2>{{ $place->name }}</h2>
        @if(Auth::check())
            <div class="star-rate">
                <form method="POST" action="/place/{{ $place->id }}/stars">
                    {!! csrf_field() !!}
                    <input name="_method" type="hidden" value="PUT">
                    @include('place.partials.form_stars')
                    <button class="button button-rate" type="submit">{{ ucfirst(Lang::get('gottashit.place.rate_place')) }}</button>
                </form>
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
            <div class="place-stars-text">{{ $place->starForPlace()['average'] }} / {{ ucfirst(Lang::get('gottashit.place.votes')) }}: {{ $place->starForPlace()['votes'] }}</div>
        </div>
        <div class="place-comments">
            <p class="place-comments-number">
                @if($place->numberOfComments == 0)
                {{ Lang::get('gottashit.place.no_comments') }}
                @elseif($place->numberOfComments == 1)
                {{ Lang::get('gottashit.place.one_comment') }}
                @else
                {{ $place->numberOfComments }} {{ Lang::get('gottashit.place.comments') }}
                @endif
            </p>

            @foreach($place->comments as $comment)
                <div class="place-comments-user">
                    <p class="place-comments-user-name">{{ $comment->user->full_name }}</p>
                    @if($comment->isAuthor)
                        <div class="actions">
                            <ul>
                                <li>
                                    <a  class="button button-action" href="/place/{{ $place->id }}/comment/{{ $comment->id }}/edit">{{ ucfirst(Lang::get('gottashit.form.edit_comment')) }}</a>
                                </li>
                                <li>
                                    <form method="post" action="/place/{{ $place->id }}/comment/{{ $comment->id }}">
                                        {!! csrf_field() !!}
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button class="button button-action" type="submit">{{ ucfirst(Lang::get('gottashit.form.delete_comment')) }}</button>
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
                                {{ ucfirst(Lang::get('gottashit.place.comment')) }}
                            </label>
                            @if(old('comment') != "")
                                <textarea class="textarea" name="comment" id="comment">{{ old('comment') }}</textarea>
                            @else
                                <textarea class="textarea" name="comment" id="comment"></textarea>
                            @endif
                        </div>

                        <div>
                            <button class="button" type="submit">{{ ucfirst(Lang::get('gottashit.place.create_comment')) }}</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
