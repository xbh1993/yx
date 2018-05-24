var speed = 15; //数字越大速度越慢
var tab = document.getElementById("item_item1");
var tab1 = document.getElementById("item1");
var tab2 = document.getElementById("item2");
var html = $('#item1').html();
$('#item2').html(html)
function Marquee() {

    if (tab2.offsetWidth - tab.scrollLeft <= 0)
        tab.scrollLeft -= tab1.offsetWidth
    else {
        tab.scrollLeft++;
    }
}
var MyMar = setInterval(Marquee, speed);
tab.onmouseover = function () {
    clearInterval(MyMar)
};
tab.onmouseout = function () {
    MyMar = setInterval(Marquee, speed)
};


var speed2 =15; //数字越大速度越慢
var tab_tab = document.getElementById("item_item_2");
var tab2_2 = document.getElementById("item2_2");
var tab2_3 = document.getElementById("item2_3");
var html_html = $('#item1').html();
$('#item2_3').html(html_html)
function Marquee2() {
    if (tab2_3.offsetWidth - tab_tab.scrollLeft <= 0)
        tab_tab.scrollLeft -= tab2_2.offsetWidth
    else {
        tab_tab.scrollLeft++;
    }
}

var MyMars = setInterval(Marquee2, speed2);
tab_tab.onmouseover = function () {
    clearInterval(MyMars)
};
tab_tab.onmouseout = function () {
    MyMars = setInterval(Marquee2, speed2)
};



// var map = new AMap.Map('container', {resizeEnable: true, zoom: 5,zoomEnable:false,});
var map = new AMap.Map('container', {resizeEnable: true, zoom: 5});
var infoWindow = new AMap.InfoWindow({offset: new AMap.Pixel(0, -30)});
var markers = [];
var url=$('#Tabfen').attr('data-url');
$.post(url,{type:2},function (res) {
    if(res.code==1){
        getmap(res.data)
    }
},'json')

$('.tabfenItemContainer li').click(function () {
    $('.tabfenItemContainer li a').removeClass('tabfenItemCurrent');
    $(this).find('a').addClass('tabfenItemCurrent');
    var type= $(this).attr('data-type');
    $.post(url,{type:type},function (res) {
        if(res.code==1){
            map.remove(markers);
            getmap(res.data)
        }
    },'json')
})


function getmap(data) {
    markers=[];
    for (var i = 0, marker; i < data.length; i++) {
        var position=data[i].location.split(',');

        var html = ' <div class="map_com">\n' +
            '                                    <div class="map_left">\n' +
            '                                        <div class="map_name">'+data[i].title+'</div>\n' +
            '                                        <div class="map_xia"></div>\n' +
            '                                        <div class="map_jianjie">'+data[i].describle+'</div>'+
            '                                        <div class="map_address">地址:'+data[i].address+'</div>\n' +
            '                                        <div class="map_phone">\n' +
            '                                            <div class="phone_text">联系电话：'+data[i].tel+'</div>\n' +
            '                                            <img src="/static/index/images/phonef.png">\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                    <img src="'+data[i].image+'">\n' +
            '                                </div>';

        var marker = new AMap.Marker({
            position: [position[1],position[0]],
            map: map
        });

        marker.content = html;
        markers.push(marker);
        marker.on('click', markerClick);
    }
    map.setFitView();
    map.setZoomAndCenter(4, [104.205467, 39.857761]);
    //    map.setLimitBounds(map.getBounds());
}




function markerClick(e) {
    infoWindow.setContent(e.target.content);
    infoWindow.open(map, e.target.getPosition());
}