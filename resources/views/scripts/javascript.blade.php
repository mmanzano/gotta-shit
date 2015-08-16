<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    var GottaShit = {
        'analytics': '{{ env('GOOGLE_ANALYTICS') !== "" ? env('GOOGLE_ANALYTICS') : 'WithoutIdForGoogleAnalytics' }}',
        'locale': '{{ App::getLocale() }}',
        'places': {{ isset($places_json) ? $places_json : 'undefined' }}
    }
</script>
<script src="{{ asset('/js/gottashit.js') }}"></script>