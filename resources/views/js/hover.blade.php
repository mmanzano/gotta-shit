<script>
        $('#place-title-card-{{ $place->id }}').hover(
            function mouseenter(){
                $('#place-title-card-{{ $place->id }}').addClass('place-title-card-hover');
                $('#place-title-link-card-{{ $place->id }}').addClass('place-title-card-hover');

            },
            function mouseleave(){
                $('#place-title-card-{{ $place->id }}').removeClass('place-title-card-hover');
                $('#place-title-link-card-{{ $place->id }}').removeClass('place-title-card-hover');
            });
</script>