<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
    @if(isset($title))
        {{ $title }} -
    @endif
    {{ trans('gottashit.site_name') }}
</title>
<link href="{{ asset('/css/gottashit.css') }}" rel="stylesheet">
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_JS_KEY') }}&v=3.exp&libraries=places"></script>


