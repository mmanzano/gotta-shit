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
    $(this).find('.place-title-link-card').addClass('place-title-card-hover');
}

function mouseleave_place_card(){
    $(this).removeClass('place-title-card-hover');
    $(this).find('.place-title-link-card').removeClass('place-title-card-hover');
}
$('.places').on('click', '.button-delete-place', delete_place_confirm);
$('.place').on('click', '.button-delete-place', delete_place_confirm);
$('#place-comments-list').on('click', '.button-delete-comment', delete_comment_confirm);
$('#place-comments-list').on('click', '.button-edit-comment', edit_comment);
$('.place-comments').on('click', '.button-create-comment', create_update_comment);

function delete_place_confirm(e){
    if ($(this).html() !== GottaShit.messages.delete_place_confirm) {
        e.preventDefault();
        $(this).addClass('red');
        $(this).text(GottaShit.messages.delete_place_confirm);
    }
}

function delete_comment_confirm(e){
    if ($(this).html() !== GottaShit.messages.delete_comment_confirm) {
        e.preventDefault();
        $(this).addClass('red');
        $(this).text(GottaShit.messages.delete_comment_confirm);
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

function edit_comment(e){
    e.preventDefault();
    var that = this;
    var url = $(this).attr("href");
    $.get(url, function (result) {
        $(that).parents('.place-comments-user').parent().html(result.edit_box);
    }).fail(function (result) {
        console.log("Wrong");
    });
}

function create_update_comment(e){
    e.preventDefault();
    var that = this;
    var form_name = '.create-comment-form';
    var form = $(this).parents(form_name);
    var url = form.attr('action');
    var data = form.serialize();

    $.post(url, data, function (result) {
            if($(that).parents('.comment-edit-box').val() !== undefined)
            {
                $(that).parents('.comment-edit-box').html(result.comment);
            }
            else
            {
                $('#comment-textarea').val("")
                $('#place-comments-list').append(result.comment);
                $('.place-comments-number').text(result.number_of_comments);
            }
        }).fail(function (result) {
            $('#place-comments-list').append(result.status_message);
        });
}
//# sourceMappingURL=gottashit.js.map