<div class="place">
    <div class="place-title">
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
