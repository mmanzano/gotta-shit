$('#place-comments-list').on('click', '.button-delete-comment', delete_comment_confirm);

$("#create-comment").click(create_comment);

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

function create_comment(e){
    e.preventDefault();
    var that = this;
    var form_name = '#create-comment-form';
    var form = $(form_name);
    var url = form.attr('action');
    var data = form.serialize();

    $.post(url, data, function (result) {
            $('#comment').val("")
            $('#place-comments-list').append(result.comment);
            $('.place-comments-number').text(result.number_of_comments);
        }).fail(function (result) {
            $('#place-comments-list').append(result.status_message);
        });
}