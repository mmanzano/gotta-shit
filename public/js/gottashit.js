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
$('.place-comments-number').on('click', '.button-subscribe', subscribe);
$('.place-comments').on('click', '.button-create-comment', create_update_comment);

function delete_place_confirm(e){
    if(jQuery !== undefined) {
        if ($(this).html() !== GottaShit.messages.delete_place_confirm) {
            e.preventDefault();
            $(this).addClass('red');
            $(this).text(GottaShit.messages.delete_place_confirm);
        }
    }
}

function delete_comment_confirm(e){
    if(jQuery !== undefined) {
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
                comment.fadeOut(3000);
            }).fail(function (result) {
                console.log("Wrong delete comment")
            });
        }
    }
}

function edit_comment(e){
    if(jQuery !== undefined) {
        e.preventDefault();
        var that = this;
        var url = $(this).attr("href");
        $.get(url, function (result) {
            $(that).parents('.place-comments-user').parent().html(result.edit_box);
        }).fail(function (result) {
            console.log("Wrong edit comment");
        });
    }
}

function create_update_comment(e){
    if(jQuery !== undefined) {
        e.preventDefault();
        var that = this;
        var form_name = '.create-comment-form';
        var form = $(this).parents(form_name);
        var url = form.attr('action');
        var data = form.serialize();

        $.post(url, data, function (result) {
            if ($(that).parents('.comment-edit-box').val() !== undefined) {
                $(that).parents('.comment-edit-box').html(result.comment);
            }
            else {
                $('#comment-textarea').val("")
                $('#place-comments-list').append(result.comment);
                $('.place-comments-number p').text(result.number_of_comments);
                $('.button-subscribe').parents('form').parent().html(result.button_box);
            }
        }).fail(function (result) {
            console.log("Wrong update or create comment");
        });
    }
}

function subscribe(e){
    if(jQuery !== undefined) {
        e.preventDefault();
        var that = this;
        var form = $(this).parents(form);
        var url = form.attr('action');
        var data = form.serialize();

        $.post(url, data, function (result) {
            $(that).parents('form').parent().html(result.button_box);
        }).fail(function (result) {
            console.log("Wrong Subscribe");
        });
    }
}
$('.navigation').on('click', '.menu-button', show_hide_menu);

function show_hide_menu(e){
    e.preventDefault();
    var menu = $(this).parents('.navigation');
    if(menu.hasClass('navigation-hover')) {
        menu.removeClass('navigation-hover');

    }
    else {
        menu.addClass('navigation-hover');
    }
}

$('.rate-star').on('click', ratethis);

$('.radio-label').hover(mouseenter_rate_star, mouseleave_rate_star);
$('.button-rate-this').hide();
$('.actions-rate').on('click', '.button-rate-delete', delete_rate);

function mouseenter_rate_star(){
    var hovervalue = $(this).prev().val();
    $('.radio-label').each(
        function() {
            if ($(this).prev().val() !== undefined && $(this).prev().val() <= parseInt(hovervalue, 10)){
                $(this).prev().addClass('input-checked-hover');

            } else if ($(this).val() !== undefined){
                $(this).prev().addClass('input-checked-hover-no');
            }
        }
    );
}

function mouseleave_rate_star(){
    $('.rate-star').removeClass('input-checked-hover');
    $('.rate-star').removeClass('input-checked-hover-no');
}

function ratethis() {
    var that = this;
    var checkedvalue = $(this).val();
    var form = $(this).parents(form);
    var url = form.attr('action');
    var data = form.serialize();

    $('.rate-star').each(
        function () {
            if ($(this).val() !== undefined && $(this).val() < parseInt(checkedvalue, 10)) {
                $(this).addClass('input-checked');

            } else if ($(this).val() !== undefined) {
                $(this).removeClass('input-checked');
            }
        }
    );

    if (location.pathname.split('/')[3] !== 'create'){
        $.post(url, data, function (result) {
            $('.place-stars-points').width(result.star_width);
            $('.place-stars-text').text(result.star_text);
            $('.button-rate-delete').show();
            if($('.actions-rate').find('.button-rate-delete').val() === undefined) {
                $('.actions-rate ul').append(result.button_delete_rate);
            }
        }).fail(function (result) {
            console.log("Wrong rate place")
        });
    }
}

function delete_rate(e){
    e.preventDefault();
    var that = this;
    var checkedvalue = $(this).val();
    var form = $(this).parents(form);
    var url = form.attr('action');
    var data = form.serialize();

    $('.rate-star').each(
        function () {
            //$(this).addClass('input-checked-hover-no');
            $(this).removeClass('input-checked');
            this.checked = false;
        }
    );
    $('.button-rate-delete').hide();

    $.post(url, data, function (result) {
        $('.place-stars-points').width(result.star_width);
        $('.place-stars-text').text(result.star_text);
    }).fail(function (result) {
        console.log("Wrong delete rate for place")
    });
}

//# sourceMappingURL=gottashit.js.map