<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
                    },
                @endforeach
                ],
        @else
            'place': {
                id: "{{ $place->id }}",
                name: "{{$place->name}}",
                geo_lat: "{{ $place->geo_lat }}",
                geo_lng: "{{ $place->geo_lng }}",
                },
            'places': undefined,
        @endif
        'messages': {
            delete_place_confirm: "{!! trans('gottashit.place.delete_place_confirm') !!}",
            delete_comment_confirm: "{!! trans('gottashit.comment.delete_comment_confirm') !!}",
        },
    }
</script>
<script src="{{ asset('/js/gottashit.js') }}"></script>