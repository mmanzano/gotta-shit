(function($){
    var geocoder;
    var map;
    var marker;
    var position;

    // initialise the google maps objects, and add listeners
    function gmaps_init() {
        // center of the universe

        @if(old('geo_lat') != "")
            var lat = parseFloat({{ number_format(old('geo_lat'), 6) }});
            var lon = parseFloat({{ number_format(old('geo_lng'), 6) }});
            var latLonInitial = 1;
        @elseif(isset($place))
            var lat = parseFloat({{ number_format($place->geo_lat, 6) }});
            var lon = parseFloat({{ number_format($place->geo_lng, 6) }});
            var latLonInitial = 1;
        @else
            var lat = 40;
            var lon = -3;
            var latLonInitial = 0;
        @endif

        var latlng = new google.maps.LatLng(lat,lon);

        var options = {
            zoom: 6,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.RIGHT_BOTTOM
            },
            mapTypeControl: false,
            //panControl: false,
            //zoomControl: false,
            streetViewControl: false
        };

        // create our map object
        map = new google.maps.Map(document.getElementById("place-map"), options);

        // the geocoder object allows us to do latlng lookup based on address
        geocoder = new google.maps.Geocoder();

        // the marker shows us the position of the latest address
        marker = new google.maps.Marker({
            map: map,
            draggable: true
        });

        // Add a DOM event listener to react when the user clic on her location
        $('.my-location').on('click', 'a', setCurrentLocationCenter);

        // event triggered when marker is dragged and dropped
        google.maps.event.addListener(marker, 'dragend', function (event) {
            marker.setMap(map);
            position = event.latLng;
            marker.setPosition(position);
            geocode_lookup('latLng', position, false, position);
        });

        // event triggered when map is clicked
        google.maps.event.addListener(map, 'click', function (event) {
            marker.setMap(map);
            var position = event.latLng;
            marker.setPosition(position);
            marker.setVisible(true);
            map.setCenter(position);
            geocode_lookup('latLng', position, false, position);
            update_latLng(position);
        });

        if (latLonInitial == 1) {
            oldLocation = new google.maps.LatLng(lat,lon);
            marker.setPosition(oldLocation);
            map.setZoom(17);
        }

        $('#place-map-error').hide();
    }

    // move the marker to a new position, and center the map on it
    function update_map(geometry, marker) {
        marker.setMap(map);
        map.fitBounds(geometry.viewport);
        marker.setPosition(geometry.location)
    }

    // fill in the UI elements with new position data
    function update_ui(address, latLng) {
        $('#place-loc').val(address);
        update_latLng(latLng);
    }

    // Complete'#geo_lat #geo_lng before search action
    function update_latLng(latLng) {
        $('#geo_lat').val(latLng.lat());
        $('#geo_lng').val(latLng.lng());
    }

    function setCurrentLocationCenter() {
        var centerPoint = new google.maps.LatLng($(this).data("latitude"), $(this).data("longitude"));
        map.setCenter(centerPoint);
        map.setZoom(17);
        marker.setPosition(centerPoint);
        marker.setVisible(true);
        map.setCenter(centerPoint);
        geocode_lookup('latLng', centerPoint, false, centerPoint);
        update_latLng(centerPoint);
    }
    // Query the Google geocode object
    //
    // type: 'address' for search by address
    //       'latLng'  for search by latLng (reverse lookup)
    //
    // value: search query
    //
    // update: should we update the map (center map and position marker)?
    function geocode_lookup(type, value, update, initialPosition) {
        // default value: update = false
        update = typeof update !== 'undefined' ? update : false;

        request = {};
        request[type] = value;

        geocoder.geocode(request, function (results, status) {
            $('#place-map-error').html('');
            $('#place-map-error').hide();
            if (status == google.maps.GeocoderStatus.OK) {
                // Google geocoding has succeeded!
                if (results[0]) {
                    // Always update the UI elements with new location data
                    update_ui(results[0].formatted_address,
                        results[0].geometry.location);

                    initialPosition = typeof initialPosition !== 'undefined' ? initialPosition : false;

                    if (initialPosition) {
                        update_latLng(initialPosition);
                    }

                    // Only update the map (position marker and center map) if requested
                    if (update) {
                        update_map(results[0].geometry, marker);
                    }
                } else {
                    // Geocoder status ok but no results!?
                    $('#place-map-error').html("Perdona, algo anda mal. ¡Inténtalo de nuevo!");
                    $('#place-map-error').show();
                }
            } else {
                // Google Geocoding has failed. Two common reasons:
                //   * Address not recognised (e.g. search for 'zxxzcxczxcx')
                //   * Location doesn't map to address (e.g. click in middle of Atlantic)

                if (type == 'address') {
                    // User has typed in an address which we can't geocode to a location
                    $('#place-map-error').html("Perdona, no podemos encontrar " + value + ". Intenta una busqueda diferente o localízate haciendo clic en el mapa.");
                    $('#place-map-error').show();
                    $('#geo_lat').val("");
                    $('#geo_lng').val("");
                } else {
                    // User has clicked or dragged marker to somewhere that Google can't do a reverse lookup for
                    // In this case we display a warning, clear the address box, but fill in LatLng
                    $('#place-map-error').html("Guau... ¡Estás en un sitio único! Tendrás que introducir manualmente el nombre de ese lugar.");
                    $('#place-map-error').show();
                    update_ui('', value)
                }
            }
            ;
        });
    };

    function autocomplete_init() {
        var input = /** @type {HTMLInputElement} */(
                document.getElementById('place-loc'));

        var options = {
            types: [],
            componentRestrictions: {country: 'es'}
        };

        var autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.bindTo('bounds', map);

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                $('#place-map-error').html("Autocomplete's returned place contains no geometry.");
                return;
            }

            map.setCenter(place.geometry.location);
            map.setZoom(17);
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
            update_latLng(place.geometry.location);

            var address = '';
            if (place.address_components) {
                address = [
                                (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
            $('#place-loc').val(address);
        });

    }; // autocomplete_init

    $(document).ready(function () {
        // the geocoder object allows us to do latlng lookup based on address
        //geocoder = new google.maps.Geocoder();
        gmaps_init();
        autocomplete_init();
        $('#place-loc').keydown(function (event) {
            if (event.which == 13) {
                event.preventDefault();
            }
        });
        $('#place-loc').keyup(function (event) {
            if($('#place-loc').val() == "") {
                marker.setVisible(false);
                $('#geo_lat').val("");
                $('#geo_lng').val("");
            }
        });
    });
})(jQuery);


//var disclaimer_notice = document.getElementById("disclaimer-notice");

function getLocation_field() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition_field);
    }
}

function showPosition_field(position){
    $('#get-my-location').attr("data-latitude", position.coords.latitude );
    $('#get-my-location').attr("data-longitude", position.coords.longitude);
    $('#get-my-location').show()
}

getLocation_field();