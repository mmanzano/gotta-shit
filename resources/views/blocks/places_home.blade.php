@foreach($places as $place)
    <div class="place">
        <div class="place-title">
            <h2>{{ $place->name }}</h2>
            <h3>{{ Lang::get('shitguide.place.latitude') }}: {{ $place->geo_lat }} {{ Lang::get('shitguide.place.longitude') }}: {{ $place->geo_lng }}</h3>
            <h4>{{ Lang::get('shitguide.place.stars') }}: {{ $place->star }}</h4>

            <h4>
                @if($place->numberOfComments == 0)
                    {{ Lang::get('shitguide.place.no_comments') }}
                @elseif($place->numberOfComments == 1)
                    {{ Lang::get('shitguide.place.one_comment') }}
                @else
                    {{ $place->numberOfComments }} {{ Lang::get('shitguide.place.comments') }}
                @endif
            </h4>
        </div>
    </div>
@endforeach