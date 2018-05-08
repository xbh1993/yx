$(function(){
    $(".tabItemContainer>li").click(function(){
        $(".tabItemContainer>li>a").removeClass("tabItemCurrent");
        $(".tabBodyItem").removeClass("tabBodyCurrent");
        $(this).find("a").addClass("tabItemCurrent");
        $($(".tabBodyItem")[$(this).index()/2]).addClass("tabBodyCurrent");
    });
})