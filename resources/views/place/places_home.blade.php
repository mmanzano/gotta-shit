<div class="places">
@foreach($places as $place)
    <div class="place-card">
        <div class="place-title">
            @if($place->isAuthor)
                <div class="actions card">
                    <ul>
                        <li>
                            <a href="/place/{{ $place->id }}/edit" class="button card-button">{{ ucfirst(Lang::get('gottatoshit.form.edit')) }}</a>
                        </li>
                        <li>
                            <form method="post" action="/place/{{ $place->id }}">
                                {!! csrf_field() !!}
                                <input name="_method" type="hidden" value="DELETE">
                                <button type="submit" class="button card-button">{{ ucfirst(Lang::get('gottatoshit.form.delete')) }}</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endif
            <h2><a href="{{ route('place', [$place->id]) }}" class="place-title-link">{{ str_limit($place->name, 14) }}</a></h2>


        </div>
        <div id="map-{{ $place->id }}" class="place-map-render card"></div>
        <div class="place-footer card-footer">
            <div class="place-stars card-stars">
                <div class="place-stars-background">
                    <div class="place-stars-points" id="place-stars-points-{{ $place->id }}">
                        <p>&nbsp</p>
                    </div>
                </div>
                <div class="place-stars-text">{{ $place->star }}</div>
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

{!! $places->render() !!}
