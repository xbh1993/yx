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


var speed = 15; //数字越大速度越慢
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

var MyMars = setInterval(Marquee2, speed);
tab_tab.onmouseover = function () {
    clearInterval(MyMars)
};
tab_tab.onmouseout = function () {
    MyMars = setInterval(Marquee2, speed)
};



var html = ' <div class="map_com">\n' +
    '                                    <div class="map_left">\n' +
    '                                        <div class="map_name">广西扬翔股份有限公司服务中心</div>\n' +
    '                                        <div class="map_xia"></div>\n' +
    '                                        <div class="map_jianjie">\n' +
    '                                            简介：广西扬翔股份有限公司成立于1998年，是农业产业化国家重点龙头企业，旗下32家子公司，员工5000余名。\n' +
    '                                            公司主营猪产业，拥有自养猪和服务养猪两大板块，是集种猪、肉猪、猪精、猪饲料、养猪设备、猪动保为一体的\n' +
    '                                            全产业链大型农牧企业，致力于打造“基因+产品+服务+互联网”的综合模式。\n' +
    '                                        </div>\n' +
    '                                        <div class="map_address">地址：广西贵港市江南工业园区城东大道与工业一路交汇处东北角</div>\n' +
    '                                        <div class="map_phone">\n' +
    '                                            <div class="phone_text">联系电话：400-727-0088</div>\n' +
    '                                            <img src="/static/index/images/phonef.png">\n' +
    '                                        </div>\n' +
    '                                    </div>\n' +
    '                                    <img src="/static/index/images/3.jpg">\n' +
    '                                </div>';
var map = new AMap.Map('container', {resizeEnable: true, zoom: 5, zoomEnable: false,});
var markers = []; //province见Demo引用的JS文件
var infoWindow = new AMap.InfoWindow({offset: new AMap.Pixel(0, -30)});
for (var i = 0, marker; i < provinces.length; i++) {
    var marker = new AMap.Marker({
        position: provinces[i].center.split(','),
        map: map
    });
    marker.content = html;
    marker.on('click', markerClick);
}



function markerClick(e) {
    infoWindow.setContent(e.target.content);
    infoWindow.open(map, e.target.getPosition());
}
map.setFitView();
map.setZoomAndCenter(4, [104.205467, 39.857761]);
map.setLimitBounds(map.getBounds());