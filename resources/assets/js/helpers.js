var number_of_message = 0;
function status_message (message) {
    var element = '.status-message ul li.' + number_of_message;
    $('.status-message ul').append('<li class="' + number_of_message + '">' + message + '</li>');
    var that = $(element);
    that.fadeIn(1000).delay(1500).fadeOut(1000);
    number_of_message++;
}