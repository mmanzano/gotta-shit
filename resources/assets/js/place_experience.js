$('.places').on('click', '.button-delete-place', delete_place_confirm);
$('.place').on('click', '.button-delete-place', delete_place_confirm);
$('#place-comments-list').on('click', '.button-delete-comment', delete_comment_confirm);
$('#place-comments-list').on('click', '.button-edit-comment', edit_comment);
$('.place-comments-number').on('click', '.button-subscribe', subscribe);
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
    else {
        e.preventDefault();
        var that = this;
        var comment = $(this).parents('.place-comments-user').parent();
        var form_name = '#' + $(this).attr('id') + '-form';
        var form = $(form_name);
        var url = form.attr('action');
        var data = form.serialize();

        $.post(url, data, function (result) {
            $(that).parents('.place-comments-user').text(result.status_message);
            $('.place-comments-number p').text(result.number_of_comments);
            status_message(result.status_message);
            comment.fadeOut(3000);
        }).fail(function (result) {
            console.log("Wrong delete comment")
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
        console.log("Wrong edit comment");
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
        if ($(that).parents('.comment-edit-box').val() !== undefined) {
            $(that).parents('.comment-edit-box').html(result.comment);
            status_message(result.status_message);
        }
        else {
            $('#comment-textarea').val("")
            $('#place-comments-list').append(result.comment);
            $('.place-comments-number p').text(result.number_of_comments);
            $('.button-subscribe').parents('form').parent().html(result.button_box);
            status_message(result.status_message);
        }
    }).fail(function (result) {
        console.log("Wrong update or create comment");
    });
}

function subscribe(e){
    e.preventDefault();
    var that = this;
    var form = $(this).parents(form);
    var url = form.attr('action');
    var data = form.serialize();

    $.post(url, data, function (result) {
        $(that).parents('form').parent().html(result.button_box);
        status_message(result.status_message);
    }).fail(function (result) {
        console.log("Wrong Subscribe");
    });
}