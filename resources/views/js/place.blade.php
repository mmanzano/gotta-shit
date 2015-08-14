<script>
    function initialize_{{ $place->id }}() {
        var map_{{ $place->id }};
        var element_{{ $place->id }} = document.getElementById('map-{{ $place->id }}');

        var myLatlng_{{ $place->id }} = new google.maps.LatLng({{ $place->geo_lat }},{{ $place->geo_lng }});
        var mapOptions_{{ $place->id }} = {
            zoom: 16,
            center: myLatlng_{{ $place->id }},
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
        map_{{ $place->id }} = new google.maps.Map(element_{{ $place->id }}, mapOptions_{{ $place->id }})

        var marker_{{ $place->id }} = new google.maps.Marker({
            position: myLatlng_{{ $place->id }},
            map: map_{{ $place->id }},
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize_{{ $place->id }});

    $("#place-stars-points-{{ $place->id }}").width("{{ $place->starForPlace()['width'] }}");

    $("#delete-place-{{ $place->id }}").click(delete_place_confirm);

    @foreach($place->comments as $comment)
        $("#delete-comment-{{ $comment->id }}").click(delete_comment_confirm);
    @endforeach

    function delete_place_confirm(e){
        if ($(this).html() !== "{!! trans('gottashit.place.delete_place_confirm') !!}") {
            e.preventDefault();
            $(this).addClass('red');
            $(this).text("{!! trans('gottashit.place.delete_place_confirm') !!}");
        }
    }

    function delete_comment_confirm(e){
        if ($(this).html() !== "{!! trans('gottashit.comment.delete_comment_confirm') !!}") {
            e.preventDefault();
            $(this).addClass('red');
            $(this).text("{!! trans('gottashit.comment.delete_comment_confirm') !!}");
        }
        else{
            e.preventDefault();
            var that = this;
            var comment = $(this).parents('.place-comments-user').parent();
            var form_name = '#' + $(this).attr('id') + '-form';
            var form = $(form_name);
            var url = form.attr('action');
            var data = form.serialize();

            $.post(url, data, function (result) {
                $(that).parents('.place-comments-user').text(result.status_message);
                $('.place-comments-number').text(result.number_of_comments);
                comment.fadeOut(3000);
            }).fail(function (result) {
                $(that).parents('.place-comments-user').text(result.status_message);
            });
        }
    }
</script>
