(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', GottaShit.analytics, 'auto');
ga('send', 'pageview');
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
}

function showPosition(position){
    $('#nearest-place').attr("href", '/' + GottaShit.locale + '/place/' + position.coords.latitude + '/' + position.coords.longitude+ '/30000');
    $('#nearest-place').show();
}

getLocation();
$('.places').on('mouseenter', '.place-title-card', mouseenter_place_card)
$('.places').on('mouseleave', '.place-title-card', mouseleave_place_card)

function mouseenter_place_card(){
    $(this).addClass('place-title-card-hover');
    $(this).children().children().addClass('place-title-card-hover');
}

function mouseleave_place_card(){
    $(this).removeClass('place-title-card-hover');
    $(this).children().children().removeClass('place-title-card-hover');
}
//# sourceMappingURL=gottashit.js.map