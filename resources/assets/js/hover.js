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