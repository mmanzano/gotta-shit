<script>
    var map_{{ $place->id }};
    function initialize() {

        var element_{{ $place->id }} = document.getElementById('map-{{ $place->id }}');

        var myLatlng_{{ $place->id }} = new google.maps.LatLng({{ $place->geo_lat }},{{ $place->geo_lng }});
        var mapOptions_{{ $place->id }} = {
            zoom: 16,
            center: myLatlng_{{ $place->id }},
        };
        map_{{ $place->id }} = new google.maps.Map(element_{{ $place->id }}, mapOptions_{{ $place->id }})

        var marker_{{ $place->id }} = new google.maps.Marker({
            position: myLatlng_{{ $place->id }},
            map: map_{{ $place->id }},
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);


</script>
<div id="map-{{ $place->id }}" class="place-map"></div>
