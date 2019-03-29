<div class="status-message">
    <ul>
    </ul>
</div>
<script src="{{ mix('/js/app.js') }}"></script>
<script>
    var GottaShit = {
        'analytics': '{{ env('GOOGLE_ANALYTICS') !== "" ? env('GOOGLE_ANALYTICS') : 'WithoutIdForGoogleAnalytics' }}',
        'locale': '{{ App::getLocale() }}',

        @if( ! isset($places) && ! isset($place))
            'places': undefined,
            'place': undefined,
        @elseif(isset($places))
            'place': undefined,
            'places': [
                @foreach($places as $place)
                    {
                        id: "{{ $place->id }}",
                        name: "{{$place->name}}",
                        geo_lat: "{{ $place->geo_lat }}",
                        geo_lng: "{{ $place->geo_lng }}",
                        stars_width: "{{ $place->stars_progress_bar }}",
                    },
                @endforeach
                ],
        @else
            'place': {
                id: "{{ $place->id }}",
                name: "{{$place->name}}",
                geo_lat: "{{ $place->geo_lat }}",
                geo_lng: "{{ $place->geo_lng }}",
                stars_width: "{{ $place->stars_progress_bar }}",
                },
            'places': undefined,
        @endif

        @if(old('geo_lat') != "")
            'lat': parseFloat({{ number_format(old('geo_lat'), 6) }}),
            'lon': parseFloat({{ number_format(old('geo_lng'), 6) }}),
            'latLonInitial': 1,
        @elseif(isset($place))
            'lat': parseFloat({{ number_format($place->geo_lat, 6) }}),
            'lon': parseFloat({{ number_format($place->geo_lng, 6) }}),
            'latLonInitial': 1,
        @else
            'lat': 40,
            'lon': -3,
            'latLonInitial': 0,
        @endif
    'messages': {
            delete_place_confirm: "{!! trans('gottashit.place.delete_place_confirm') !!}",
            delete_comment_confirm: "{!! trans('gottashit.comment.delete_comment_confirm') !!}",
        },
    }
</script>
<script src="{{ mix('/js/gottashit.js') }}"></script>