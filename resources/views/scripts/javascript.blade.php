<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    var GottaShit = {
        'analytics': '{{ env('GOOGLE_ANALYTICS') !== "" ? env('GOOGLE_ANALYTICS') : 'WithoutIdForGoogleAnalytics' }}'
    }
</script>
<script src="{{ asset('/js/gottashit.js') }}"></script>