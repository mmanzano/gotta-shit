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
