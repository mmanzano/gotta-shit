<div class="places">
@foreach($places as $place)
    <div class="place-card">
        <div class="place-title-card" id="place-title-card-{{ $place->id }}">
            <h2><a class="place-title-link-card" href="{{ route('place', ['language' => App::getLocale(), 'place' => $place->id]) }}" id="place-title-link-card-{{ $place->id }}">{{ str_limit($place->name, 14) }}</a></h2>
            @if($place->isAuthor)
                <div class="card actions actions-card">
                    <ul>
                        <li>
                            <a class="button button-card" href="{{ route('place_edit_form', ['language' => App::getLocale(), 'place' => $place->id]) }}" id="button-edit-card-{{ $place->id }}">{{ ucfirst(trans('gottashit.place.edit_place')) }}</a>
                        </li>
                        <li>
                            <form method="post" action="{{ route('place_delete', ['language' => App::getLocale(), 'place' => $place->id]) }}">
                                {!! csrf_field() !!}
                                <input name="_method" type="hidden" value="DELETE">
                                <button class="button button-card" type="submit" id="button-delete-card-{{ $place->id }}">{{ ucfirst(trans('gottashit.place.delete_place')) }}</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
        <div class="place-map-render card" id="map-{{ $place->id }}"></div>
        <div class="place-footer card-footer">
            <div class="place-stars card-stars">
                <div class="place-stars-background">
                    <div class="place-stars-points" id="place-stars-points-{{ $place->id }}">
                    </div>
                </div>
                <div class="place-stars-text">{{ $place->starForPlace()['average'] }} / {{ ucfirst(trans('gottashit.star.votes')) }}: {{ $place->starForPlace()['votes'] }}</div>
            </div>
            <div class="place-comments card-comments">
                <p>
                    {{ $place->numberOfComments }}
                </p>
            </div>
        </div>
    </div>
@endforeach
</div>
