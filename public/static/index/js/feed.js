//侧边切换

$(function(){
    $(".tabItemContainers li").click(function(){
        $(this).parent().find('li').find('a').removeClass('tabItemCurrents');
        $(this).parent().parent().parent().find('.pnavtopr').find('.tabBodyItems').removeClass('tabBodyCurrents');
        $(this).find("a").addClass("tabItemCurrents");
        $($(this).parent().parent().parent().find('.pnavtopr').find('.tabBodyItems ')[$(this).index()]).addClass('tabBodyCurrents');
    });
})

//切换2
$(function(){
    $(".tabItemContainer_item li").click(function(){
        $(".tabItemContainer_item li a").removeClass("tabItemCurrent");
        $(".tabBodyItem ").removeClass("tabBodyCurrent");
        $(this).find("a").addClass("tabItemCurrent");
        $($(".tabBodyItem ")[$(this).index()/2]).addClass("tabBodyCurrent");
    });
})

