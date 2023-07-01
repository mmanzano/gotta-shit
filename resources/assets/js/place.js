(function($){

    function drawing_map(objectNumber){
        var map;
        var element = $(this);
        if(GottaShit.place !== undefined) {
            var id = GottaShit.place.id;
            var lat = parseFloat(GottaShit.place.geo_lat, 6);
            var lng = parseFloat(GottaShit.place.geo_lng, 6);
            var width = GottaShit.place.stars_width;
        }
        else if(GottaShit.places !== undefined){
            var id = GottaShit.places[objectNumber].id;
            var lat = parseFloat(GottaShit.places[objectNumber].geo_lat, 6);
            var lng = parseFloat(GottaShit.places[objectNumber].geo_lng, 6);
            var width = GottaShit.places[objectNumber].stars_width;
        }
        $("#place-stars-points-" + id).width(width);
        //var myLatlng = new google.maps.LatLng(lat,lng);
        // var mapOptions = {
        //     zoom: 16,
        //     center: myLatlng,
        //     mapTypeId: google.maps.MapTypeId.ROADMAP,
        //     zoomControl: true,
        //     zoomControlOptions: {
        //         style: google.maps.ZoomControlStyle.SMALL,
        //         position: google.maps.ControlPosition.RIGHT_BOTTOM
        //     },
        //     mapTypeControl: false,
        //     streetViewControl: false,
        //     scrollwheel: false,
        //     draggable: false
        // };

        map = L.map(document.getElementById(element.attr('id')), {
            center: {
                lat,
                lng,
            },
            zoom: 14
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // var marker = new google.maps.Marker({
        //     position: myLatlng,
        //     map: map
        // });
       L.marker([lat,lng]).addTo(map);

        // event triggered when map is clicked
        // google.maps.event.addListener(map, 'click', function (event) {
        //     map.setOptions({
        //         scrollwheel: true,
        //         draggable: true
        //     });
        // });
        objectNumber++
    }

    $(document).ready(function () {
        var objectNumber = 0;
        $('.place-map-render').each(drawing_map);
    });
})(jQuery);