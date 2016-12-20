/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**************全局变量声明**********************/
var bntPos = 0,
        noteBntPos = 0,
        vodInfo, /*{"icon": "http://182.92.156.224:8088/smart_file/sys_file/hotel/31/static/vod/img/51999453-05a0-47d5-b72d-435bd92373f8.jpg", "desc": "《猩球崛起》片末的致命病毒弥漫全球，遭此横祸的人类只有一小部分幸存下来，聚居在旧金山。智能进化的猿族首领凯撒也在深山密林中与族人建立了自己的家园，并试图将人性带入猿族社会。然而随着一小队人类的到访，他们的宁静被打破。在这场人猿大战中，人类也分成了两个阵营，杰森·克拉克、凯丽·拉塞尔饰演的角色将与猿族成为朋友，而加里·奥德曼饰演的角色则与猿族敌对。", "score": 4.2, "number": 1, "actor": "安迪·瑟金斯、加里·奥德曼", "type": 0, "director": "马特·里夫斯", "id": 3, "time": "2014-09-09", "duration": "130", "area": "欧美", "price": 5, "resList": [{"id": 38, "playUrl": "http://211.149.158.230:8088/index_movie/2.mp4", "name": "1"}], "name": "猩球崛起：黎明之战"},*/
vodValidTime = 24, //48,//单位小时，购买一次在多长的有效时间内可以重复观看
        allDayPrice = 20.0, //20,//单位元，包天购买的价格
        allDayId = 66, //包天节目包Id
        //resListLen = vodInfo.resList.length;//资源长度
        resListLen;//资源长度
//resListLen		= vodList[0].list[0].vodInfo.resList.length;//资源长度

topicId = $.url.query('topicId') || 0,
        topicPrice = $.url.query('topicPrice') || 0,
        topicValidTime = $.url.query('topicValidTime') || 0,
        authFlag = false, //false鉴权失败  true鉴权成功
        buyFlag = false, //false购买失败  true购买成功
        buyType = 0, //1单次或者专题购买  2全天购买
        packageId = 0,
        lastFocusArea = 0,
        focusArea = 0;//0:底部按钮;1:弹出框按钮;4:正在操作提示框.


HOTEL_AUTH_INFO = HOTEL_AUTH_INFO || $.mem.getVar('HISU_SMART_HOTEL_ROOM_INFO');
/****************按键处理**********************/
$.plugs.keyProcess = function (key, keyObj) {
    console.log("**********keyProcess************************="+key);
    switch (key) {
        case "LEFT":
            keyLeftRight(-1);
            break;
        case "RIGHT":
            keyLeftRight(1);
            break;
        case "UP":
            keyUpDown(-1);
            break;
        case "DOWN":
            keyUpDown(1);
            break;
        case "CHANNEL_UP":
        case "PAGE_UP":
            changePage(-1);
            break;
        case "CHANNEL_DOWN":
        case "PAGE_DOWN":
            changePage(1);
            break;
        case "OK":
            doOk();
            break;
        case "BACK":
            switch (focusArea) {
                case 0:
                    location.href = "./index.html";
                    break;
                case 1:
                    changeFocusArea(0);
                    break;
                case 4:
                    changeFocusArea(0);
                break;
                default:
                    break;
            }
            break;
        case "EXIT":
            console.log("========detail=====Exit===");
            return 1;
            break;
        case "F2":
            location.href = location.href;
            break;
        default:
            console.log("*******default***********");
            /*if(key.indexOf('NUMBER')>-1){
             var tmpKey = key.split('_')[1];
             break;
             }*/
            return 1;
            break;
    }
    return 0;
}
/**************入口**********************/
function init() {
    vodInfo=JSON.parse(window.sessionStorage.getItem("hotelfilmdetailinfo"));
    resListLen = vodInfo.resList.length;//资源长度
    //document.addEventListener("backbutton", onBackButtonCallback);
    initVodInfo();
    setFocusStyle(1);
    initNoteBntInfo();
    if (!$.empty(HOTEL_AUTH_INFO))
        vodPlayAuth();
}
/**************数据请求********************/
function vodPlayAuth() {
    var params = {
        hotelId: HOTEL_AUTH_INFO.hotelId,
        roomId: HOTEL_AUTH_INFO.roomId,
        vodId: vodInfo.id
    }
    if (!$.empty(HOTEL_AUTH_INFO.stayId))
        params.stayId = HOTEL_AUTH_INFO.stayId;
    var url = initRequestUrl('/SmartHotelInterface/api/smartHotel/vodPlayAuth', params);
    $.get(url, authCallback);
}

function authCallback(__text) {
    var tmp = $.eval(__text);
    if (!$.empty(tmp)) {
        if (tmp.resultCode == 200) {
            authFlag = true;
            packageId = tmp.packageId;
        }
        else
            authFlag = false;
    }
}

function buyVodPackage(__type) {
    buyType = __type;
    var params = {
        hotelId: HOTEL_AUTH_INFO.hotelId,
        roomId: HOTEL_AUTH_INFO.roomId,
        vodId: vodInfo.id
    }
    if (!$.empty(HOTEL_AUTH_INFO.stayId))
        params.stayId = HOTEL_AUTH_INFO.stayId;
    if (buyType == 1)
        params.packageId = topicId;
    else
        params.packageId = 0;
    var url = initRequestUrl('/SmartHotelInterface/api/smartHotel/buyVodPackage', params);
    $.get(url, buyCallback);
}

function buyCallback(__text) {
    var tmp = $.eval(__text);
    if (!$.empty(tmp)) {
        if (tmp.resultCode == 200) {
            buyFlag = true;
            showNoteMessage('购买成功，正在准备播放，请稍候！');
            vodPlayRecord();
        }
        else {
            buyFlag = false;
            showNoteMessage('购买失败，请稍候再试！');
            setTimeout('hideNoteMessage()', 3000);
        }
    }
}

function vodPlayRecord() {
    hideNoteMessage();
    playVideo();
}

function playCallback(__text) {
    var tmp = $.eval(__text);
    if (!$.empty(tmp)) {
        if (tmp.resultCode == 200) {//跳转到播放页面
            playVideo();
        }
        else {
            showNoteMessage('播放失败，请稍候再试！');
        }
    }
    setTimeout('hideNoteMessage()', 3000);
}

/**************初始化内容******************/
function initVodInfo() {
    console.log("");
    $('vodName').text($.substr(vodInfo.name, 21, ''));
    $('bigIcon').src(vodInfo.icon);//bigIcon
    if (topicId != 0)
        $('price').text(topicPrice + '元');//如果从专题进入就显示专题的价格
    else
        $('price').text(vodInfo.price + '元');
    $('score').text(vodInfo.score + '分');
    var tmpScore = vodInfo.score.toString();
    var scoreArray = tmpScore.split('.');
    var starStr = '';
    for (var i = 0; i < parseInt(scoreArray[0]); i++) {
        starStr += '<image src="images/vod_star0.png"> ';
    }
    if (scoreArray.length > 1 && parseInt(scoreArray[1]) > 0) {
        starStr += '<image src="images/vod_star1.png"> ';
    }
    $('star').html(starStr);
    $('vodArea').text(vodInfo.area);
    $('vodTime').text(vodInfo.time);
    $('vodDuration').text(vodInfo.duration + '分钟');
    $('vodDirector').text(vodInfo.director);
    $('vodActor').text(vodInfo.actor);
    $('vodDesc').text($.substr(vodInfo.desc, 230));
}

function initNoteInfo() {
    if (topicId != 0) {
        $('noteVodPrice').text(topicPrice + '元');
        $('vodValidTime').text(topicValidTime);
    }
    else {
        $('noteVodPrice').text(vodInfo.price + '元');
        $('vodValidTime').text(vodValidTime);
    }
    $('allDayPrice').text(allDayPrice);
}
/**************处理焦点样式****************/

function setFocusStyle(__num) {
    switch (focusArea) {
        case 0:
            $('bnt' + bntPos).bgImage('images/vod_bnt' + __num + '.png');
            $('bnt' + bntPos).color(['#626262', '#FFFFFF'][__num]);
            break;
        case 1:
            $('noteBnt' + noteBntPos).bgImage('images/vod_note_bnt' + __num + '.png');
            $('noteBnt' + noteBntPos).color(['#626262', '#FFFFFF'][__num]);
            break;
        case 4:
            if (__num > 0){
                //$('currNoteArea').show();
                document.getElementById('currNoteArea').style.display="block";
            }
            else{
                //$('currNoteArea').hide();
                document.getElementById('currNoteArea').style.display="none";
                }
            break;
    }
}
/**************左右键处理*****************/
function keyLeftRight(__num) {
    switch (focusArea) {
        case 0:
            setFocusStyle(0);
            bntPos = (bntPos + 3 + __num) % 3;
            setFocusStyle(1);
            break;
        case 1:
            setFocusStyle(0);
            noteBntPos = (noteBntPos + 3 + __num) % 3;
            setFocusStyle(1);
            break;

    }
}
/**************上下键处理*****************/
function keyUpDown(__num) {
    switch (focusArea) {
        case 0:
            break;
        case 1:

            break;
    }
}
/**************翻页键处理*****************/
function changePage(__num) {
    switch (focusArea) {
        case 0:
            break;
        case 1:
            break;

    }
}

/**************切换焦点区域*****************/
function changeFocusArea(__num) {
    switch (focusArea) {
        case 0:
            setFocusStyle(0);
            break;
        case 1:
            setFocusStyle(0);
            document.getElementById('buyNote').style.display="none";
            break;
        case 4:
            setFocusStyle(0);
            break;
    }
    lastFocusArea = focusArea;
    focusArea = __num;

    switch (focusArea) {
        case 0:
            setFocusStyle(1);
            break;
        case 1:
            setFocusStyle(1);
             document.getElementById('buyNote').style.display="block";
            break;
        case 4:
            setFocusStyle(1);
            break;
    }
}

/**************确定键处理*****************/
function doOk() {
    switch (focusArea) {
        case 0:
            if (bntPos == 1) {//点播
                if (resListLen == 0) {
                    changeFocusArea(4);
                    showNoteMessage('暂时未找到资源，请稍候再试');
                    setTimeout('hideNoteMessage()', 3000);
                    return;
                }
                if (authFlag) {
                    changeFocusArea(4);
                    showNoteMessage('正在准备播放，请稍候！');
                    vodPlayRecord();
                }
                else {
                    changeFocusArea(1);
                    initNoteInfo();
                }
            }
            else if (bntPos == 2) {//返回
                location.href = "./index.html";
            }
            break;
        case 1:
            if (noteBntPos == 0) {
                changeFocusArea(4);
                if (topicId != 0) {
                    showNoteMessage('正在购买专题，请稍候！');
                    buyVodPackage(1);
                }
                else {
                    showNoteMessage('正在准备播放，请稍候！');
                    vodPlayRecord();//单次点播是不用调用购买接口，直接调用添加播放记录接口就可以了
                }
            }
            else if (noteBntPos == 1) {
                changeFocusArea(4);
                showNoteMessage('正在包天购买，请稍候！');
                buyVodPackage(2);
            }
            else {
                changeFocusArea(0);
            }
            break;
    }
}
/**************功能函数区域*****************/
function showNoteMessage(__text) {
    $('curr_note_info').text(__text);
}

function hideNoteMessage() {
    changeFocusArea(0);
}

function initNoteBntInfo() {
    if (topicId != 0) {
        $('noteBnt0').text('专题点播');
        $('noteVodInfo').text('此影片是付费专题影片，您确认点播？');
        $('noteVodInfo1').text('小时内可无限制播放此专题影片。');
    }
}

function playVideo() {
    var currData = vodInfo.resList[0];
    var url = '';
    switch ($.browser) {
        case "Hisu":
            url = 'player/player.html?purl=';
            break;
        case "iPanel":
            var video_url = currData.playUrl;
            if (video_url.indexOf('rtsp://') > -1) {
                var macAddress = $.STB.getMAC();
                macAddress = macAddress.replace(/-/g, "");
                video_url += "&stbcapability=0x1&servicename=StartOver&ipanel_shangxi=1" + "&STBMac=" + macAddress;
                window.location.href = video_url;//这个方式是陕广播放rtsp路径的视频，会进入茁壮内置的VOD全频播放页面，播放完毕或者按返回键浏览器会自动返回上一级页面
                return;
            }
            url = 'ipanelPlayer/usbVideoPlay.htm?purl=';
            break;
        case "iPanelAdvanced"://茁壮Advanced版本目前对接的是海南的版本
            url = 'NGBPlayer/videoPlay.htm';
            var myurl = "";
            if (topicId != 0)
                myurl = window.location.href.split('?')[0] + '?topicId=' + topicId + '&topicPrice=' + topicPrice + '&topicValidTime=' + topicValidTime;
            else
                myurl = window.location.href;

            iPanel.setGlobalVar('HISU_SMART_HOTEL_VOD_PLAY_URL', currData.playUrl);
            iPanel.setGlobalVar('HISU_SMART_HOTEL_VOD_RETURN_URL', myurl);
            iPanel.setGlobalVar('HISU_SMART_HOTEL_VOD_NAME', vodInfo.name);

            window.location.href = url;
            return;
            break;
        default:
            url = 'player/video_player.html?purl=';
            break;
    }
    url += $.url.encode(currData.playUrl);
    url += '&rurl=';
    var myurl = "";
    if (topicId != 0)
        myurl = window.location.href.split('?')[0] + '?topicId=' + topicId + '&topicPrice=' + topicPrice + '&topicValidTime=' + topicValidTime;
    else
        myurl = window.location.href;
    url += $.url.encode(myurl);
    url += '&vinfo=';
    url += $.url.encode(vodInfo.name);

    window.location.href = url;
}

/*function onBackButtonCallback() {
    console.log("***********>>>>>>>>>>>>>>>>>>>>>>>>BACKBUTTON>>>>>>>>>>>>>>>>>>>>>>>>");
    var ikey = "BACK";

    $.plugs.keyProcess(ikey, {});
}*/
document.addEventListener("deviceready", init, false);


