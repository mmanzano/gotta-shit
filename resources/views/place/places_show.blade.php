<div class="places">
@foreach($places as $place)
    <div class="place-card">
        <div class="place-title-card" id="place-title-card-{{ $place->id }}">
            <h2><a class="place-title-link-card" href="{{ $place->path }}" id="place-title-link-card-{{ $place->id }}">{{ str_limit($place->name, 14) }}</a></h2>
            @if($place->is_author)
                <div class="card actions actions-card">
                    <ul>
                        @if(! $place->trashed())
                            <li>
                                <a class="button button-card" href="{{ route('place.edit', ['place' => $place->id]) }}" id="button-edit-card-{{ $place->id }}">{{ trans('gottashit.place.edit_place') }}</a>
                            </li>
                        @endif
                        <li>
                            <form method="post" action="{{ route('place.destroy', ['place' => $place->id]) }}">
                                {!! csrf_field() !!}
                                <input name="_method" type="hidden" value="DELETE">
                                <button class="button button-card button-delete-place" type="submit" id="delete-place-{{ $place->id }}">
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
        </div>
        <div class="place-map-render card" id="map-{{ $place->id }}"></div>
        <div class="place-footer card-footer">
            <div class="place-stars card-stars">
                <div class="place-stars-background">
                    <div class="place-stars-points" id="place-stars-points-{{ $place->id }}">
                    </div>
                </div>
                <div class="place-stars-text">{{ $place->stars_average }} / {{ trans('gottashit.star.votes') }}: {{ $place->stars_amount }}</div>
            </div>
            <div class="place-comments card-comments">
                <p>
                    {{ $place->number_of_comments }}
                </p>
            </div>
        </div>
    </div>
@endforeach
</div>
