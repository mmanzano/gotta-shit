<script>
    var disclaimer_notice = document.getElementById("disclaimer-notice");

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            disclaimer_notice.innerHTML = '{{ Lang::get('gottashit.no_geolocation') }}';
        }
    }

    function showPosition(position){
        $('#nearest-place').attr("href", '/place/' + position.coords.latitude + '/' + position.coords.longitude+ '/30000');
        //console.log();
    }

    getLocation();

</script>