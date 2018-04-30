


$('.item li').click(function () {
    var types = $(this).attr('data-value');
    $('.item li').removeClass('fli');
    $('#tabCon div').removeClass('items_check');
    if (types == 1) {
        $('.item li').eq(0).addClass('fli');
        $('#tabCon div').eq(0).addClass('items_check');
    }
    if (types == 2) {
        $('.item li').eq(1).addClass('fli');
        $('#tabCon div').eq(1).addClass('items_check');
    }
    if (types == 3) {
        $('.item li').eq(2).addClass('fli');
        $('#tabCon div').eq(2).addClass('items_check');
    }
    if (types == 4) {
        $('.item li').eq(3).addClass('fli');
        $('#tabCon div').eq(3).addClass('items_check');
    }
    if (types == 5) {
        $('.item li').eq(4).addClass('fli');
        $('#tabCon div').eq(4).addClass('items_check');
    }
})

