<div class="places">
@foreach($places as $place)
    <div class="place-card">
        <div class="place-title-card" id="place-title-card-{{ $place->id }}">
            <h2><a class="place-title-link-card" href="{{ route('place', [$place->id]) }}" id="place-title-link-card-{{ $place->id }}">{{ str_limit($place->name, 14) }}</a></h2>
            @if($place->isAuthor)
                <div class="card actions actions-card">
                    <ul>
                        <li>
                            <a class="button button-card" href="/place/{{ $place->id }}/edit" id="button-edit-card-{{ $place->id }}">{{ ucfirst(Lang::get('gottashit.form.edit')) }}</a>
                        </li>
                        <li>
                            <form method="post" action="/place/{{ $place->id }}">
                                {!! csrf_field() !!}
                                <input name="_method" type="hidden" value="DELETE">
                                <button class="button button-card" type="submit" id="button-delete-card-{{ $place->id }}">{{ ucfirst(Lang::get('gottashit.form.delete')) }}</button>
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
                <div class="place-stars-text">{{ $place->starForPlace()['average'] }} / {{ ucfirst(Lang::get('gottashit.place.votes')) }}: {{ $place->starForPlace()['votes'] }}</div>
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

<div class="pagination-nav">
    {!! $places->render() !!}
</div>
