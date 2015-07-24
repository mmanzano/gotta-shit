<div class="places">
@foreach($places as $place)
    <div class="place-card">
        <div class="place-title">
            <h2>{{ $place->name }}</h2>
        </div>
        @include('sections.footer')
        <div class="place-footer">
            <div class="place-stars">
                <p>
                    {{ $place->star }}
                </p>
            </div>
            <div class="place-comments">
                <p>
                    {{ $place->numberOfComments }}
                </p>
            </div>
        </div>
    </div>
@endforeach
</div>

{!! $places->render() !!}