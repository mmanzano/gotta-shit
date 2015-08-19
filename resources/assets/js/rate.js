$('.rate-star').on('click', ratethis);

function ratethis(){
    var checkedvalue = $(this).val();
    $('.radio').each(
        function() {
            if ($(this).val() !== undefined && $(this).val() < parseInt(checkedvalue, 10)){
                $(this).addClass('input-checked');

            } else if ($(this).val() !== undefined){
                $(this).removeClass('input-checked');
            }
        }
    );
}