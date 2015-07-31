<div class="place">
    <div class="place-title">
        @if($place->isAuthor)
            <div class="actions">
                <ul>
                    <li>
                        <a href="/place/{{ $place->id }}/edit">{{ ucfirst(Lang::get('gottatoshit.form.edit')) }}</a>
                    </li>
                    <li>
                        <form method="post" action="/place/{{ $place->id }}">
                            {!! csrf_field() !!}
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit">{{ ucfirst(Lang::get('gottatoshit.form.delete')) }}</button>
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
                    <button type="submit" class="rate">{{ ucfirst(Lang::get('gottatoshit.place.rate_place')) }}</button>
                </form>
            </div>
        @endif
    </div>

    <div id="map-{{ $place->id }}" class="place-map"></div>
    <div class="place-footer">
        <div class="place-stars">
            <div class="place-stars-background">
                <div class="place-stars-points" id="place-stars-points-{{ $place->id }}">
                    <p>&nbsp</p>
                </div>
            </div>
            <div class="place-stars-text">{{ $place->star }}</div>
        </div>
        <div class="place-comments">
            <p class="place-comments-number">
                @if($place->numberOfComments == 0)
                {{ Lang::get('gottatoshit.place.no_comments') }}
                @elseif($place->numberOfComments == 1)
                {{ Lang::get('gottatoshit.place.one_comment') }}
                @else
                {{ $place->numberOfComments }} {{ Lang::get('gottatoshit.place.comments') }}
                @endif
            </p>

            @foreach($place->comments as $comment)
                <div class="place-comments-user">
                    {{ Lang::get('gottatoshit.place.user') }}: {{ $comment->user->full_name }}
                    @if($comment->isAuthor)
                        <div class="actions">
                            <ul>
                                <li>
                                    <a href="/place/{{ $place->id }}/comment/{{ $comment->id }}/edit">{{ ucfirst(Lang::get('gottatoshit.form.edit')) }}</a>
                                </li>
                                <li>
                                    <form method="post" action="/place/{{ $place->id }}/comment/{{ $comment->id }}">
                                        {!! csrf_field() !!}
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit">{{ ucfirst(Lang::get('gottatoshit.form.delete')) }}</button>
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
            <div class="forms">
                <form method="POST" action="/place/{{ $place->id }}/comment">
                    {!! csrf_field() !!}
                    @include('place.partials.comments')
                    <div>
                        <button type="submit">{{ ucfirst(Lang::get('gottatoshit.place.create_comment')) }}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
