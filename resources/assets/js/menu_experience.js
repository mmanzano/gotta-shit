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
