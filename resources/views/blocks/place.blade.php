<div class="place">
    <div class="place-title">
        @if($place->isAuthor)
            <div class="actions">
                <ul>
                    <li>
                        <form method="post" action="/place/{{ $place->id }}">
                            {!! csrf_field() !!}
                            <input name="_method" type="hidden" value="PUT">
                            <button type="submit">{{ ucfirst(Lang::get('gottatoshit.form.edit')) }}</button>
                        </form>
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
                <p class="place-comments-user">
                    {{ Lang::get('gottatoshit.place.user') }}: {{ $comment->user->full_name }}
                </p>
                <p class="place-comments-body">
                    {{ $comment->comment }}
                </p>
            @endforeach
        </div>
    </div>
</div>
