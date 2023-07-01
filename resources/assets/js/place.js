(function ($) {
    function drawing_map(objectNumber)
    {
        var map;
        var element = $(this);
        var id;
        var lat;
        var lng;
        var width;
        if (GottaShit.place !== undefined) {
            id = GottaShit.place.id;
            lat = parseFloat(GottaShit.place.geo_lat, 6);
            lng = parseFloat(GottaShit.place.geo_lng, 6);
            width = GottaShit.place.stars_width;
        } else if (GottaShit.places !== undefined) {
            id = GottaShit.places[objectNumber].id;
            lat = parseFloat(GottaShit.places[objectNumber].geo_lat, 6);
            lng = parseFloat(GottaShit.places[objectNumber].geo_lng, 6);
            width = GottaShit.places[objectNumber].stars_width;
        }

        $("#place-stars-points-" + id).width(width);

        map = addMap(document.getElementById(element.attr('id')), lat, lng);
        // event triggered when map is clicked
        map.on('click', function (e) {
            map.off();
            map.remove();
            let theElement = document.getElementById(element.attr('id'))
            addMap(theElement, lat, lng, {
                scrollWheelZoom: true,
                dragging: true,
            });
        });

        objectNumber++
    }

    function addMap(element, lat, lng, options = {})
    {
        let map = L.map(element, {
            ...options,
            center: {
                lat,
                lng,
            },
            scrollWheelZoom: true,
            dragging: true,
            zoom: 14
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Add marker to the map
        let customIcon = L.icon({
            iconUrl: '/marker-icon.png',
            iconRetinaUrl: '/marker-icon-2x.png',
            shadowUrl: '/marker-shadow.png',
            iconSize:    [25, 41],
            iconAnchor:  [12, 41],
            popupAnchor: [1, -34],
            tooltipAnchor: [16, -28],
            shadowSize:  [41, 41]
        });
        L.marker([lat,lng], {
            icon: customIcon,
        }).addTo(map);

        return map;
    }

    $(document).ready(function () {
        var objectNumber = 0;
        $('.place-map-render').each(drawing_map);
    });
})(jQuery);
