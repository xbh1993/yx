//侧边切换

$(function(){
    $(".tabItemContainers>li").click(function(){
        $(".tabItemContainers>li>a").removeClass("tabItemCurrents");
        $(".tabBodyItems").removeClass("tabBodyCurrents");
        $(this).find("a").addClass("tabItemCurrents");
        $($(".tabBodyItems")[$(this).index()]).addClass("tabBodyCurrents");
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