<div class="places">
@foreach($places as $place)
    <div class="place-card">
        <div class="place-card-title">
            <h2><a href="{{ route('place', [$place->id]) }}">{{ str_limit($place->name, 14) }}</a></h2>
            @if($place->isAuthor)<p>Editar</p>@endif
        </div>
        <div id="map-{{ $place->id }}" class="place-card-map"></div>
        <div class="place-card-footer">
            <div class="place-card-stars">
                <div class="place-card-stars-background">
                    <div class="place-card-stars-points" id="place-stars-points-{{ $place->id }}">
                        <p>&nbsp</p>
                    </div>
                </div>
                <div class="place-card-stars-text">{{ $place->star }}</div>
            </div>
            <div class="place-card-comments">
                <p>
                    {{ $place->numberOfComments }}
                </p>
            </div>
        </div>
    </div>
@endforeach
</div>

{!! $places->render() !!}
