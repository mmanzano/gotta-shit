function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
}

function showPosition(position){
    $('#nearest-place').attr("href", '/place/' + position.coords.latitude + '/' + position.coords.longitude+ '/30000');
    $('#nearest-place').show();
}

getLocation();