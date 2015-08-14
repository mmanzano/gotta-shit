$('#place-comments-list').on('click', '.button-delete-comment', delete_comment_confirm);
$('#place-comments-list').on('click', '.button-edit-comment', edit_comment);
$('.place-comments').on('click', '.button-create-comment', create_update_comment);

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