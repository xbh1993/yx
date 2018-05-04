$(function(){
    $(".tabItemContainer>li").click(function(){
        $(".tabItemContainer>li>a").removeClass("tabItemCurrent");
        $(".tabBodyItem").removeClass("tabBodyCurrent");
        $(this).find("a").addClass("tabItemCurrent");
        $($(".tabBodyItem")[$(this).index()]).addClass("tabBodyCurrent");
    });
})

//切换2
$(function(){
    $(".tabfenItemContainer>li").click(function(){
        $(".tabfenItemContainer>li>a").removeClass("tabfenItemCurrent");
        $(".tabfenBodyItem").removeClass("tabfenBodyCurrent");
        $(this).find("a").addClass("tabfenItemCurrent");
        $($(".tabfenBodyItem")[$(this).index()]).addClass("tabfenBodyCurrent");
    });
})