/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**************全局变量声明**********************/
var oHistory = new $.plugs.history(),
        //type 0表示连续剧 1表示影片
        vodList = [
            {
                "id": 31,
                "price": 0,
                "name": "",//影片类型
                "validTime": 0,
                "list": [
                    /*{
                     "id": 3,
                     "icon": "",//图片
                     "price": 0,//价格
                     "name": "",//影片名
                     "type": 1,
                     "vodInfo": {//详情信息
                     "icon":"",
                     "desc":"",//影片描述
                     "score":,//评分
                     "number":,
                     "actor": "",//主演
                     "type": 0,
                     "director": "",//导演
                     "id": ,
                     "time": "",//上线时间
                     "duration": "",//时长
                     "area": "",//地区
                     "price": ,//价格
                     "resList": [//视频资源
                     {
                     "id": ,
                     "playUrl": "",
                     "name": ""
                     }
                     ]
                     }
                     }*/
                ]
            },
        ],
            storagelocal=window.localStorage,

currVodList = [],
        listBox = null,
        startPos = ($.url.query('startPos') || 0) - 0,
        focusPos = ($.url.query('focusPos') || 0) - 0,
        showLen = 10,
        listLen = 0,
        pageNum = ($.url.query('pageNum') || 1) - 0,
        totalPage = 0,
        categoryListBox = null,
        cateShowLen = 6,
        categoryPos = ($.url.query('categoryPos') || 0) - 0,
        cateStartPos = ($.url.query('cateStartPos') || 0) - 0,
        cateFocusPos = ($.url.query('cateFocusPos') || 0) - 0,
        categoryLen = 0, //类别长度
        lastFocusArea = 0,
        focusArea = ($.url.query('focusArea') || 0) - 0;//0:类型列表;1:影片列表;2:XXXXXXXXXXX.


/****************按键处理**********************/
$.plugs.keyProcess = function (key, keyObj) {
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
                    location.href = "../../hotel_01/";
                    break;
                case 1:
                    setFocusStyle(0);
                    focusArea = 0;
                    setFocusStyle(1);
                    initListBox();
                    break;
                default:
                    break;
            }

            break;
        case "EXIT":
            return 1;
            break;
        case "F2":
            location.href = location.href;
            break;
        default:
            /*if(key.indexOf('NUMBER')>-1){
             var tmpKey = key.split('_')[1];
             break;
             }*/
            return 1;
    }
    //return 0;
}
/**************入口**********************/
function init() {
    if(storagelocal.getItem('hotelmoviestorage')==null){
        console.log("====VOD=init==storage=null=========");
    }
    initClock();   
    MovieTypeData();
    //document.addEventListener("backbutton", onBackButtonCallback);
}

/**************初始化内容******************/
function initListBox() {
    console.log("****初始化内容******");
    listBox = new $.plugs.list();
    listBox.haveData = function (iPos, dPos) {
        var data = currVodList[dPos];
        $('list_icon' + iPos).src(data.icon);
        $('list_name' + iPos).bgImage('images/vod_name_bg.png');
        $('list_name' + iPos).text($.substr(data.name, 8, ''));
    };
    listBox.noData = clearListData;
    listBox.init({
        showType: '2*5',
        showLen: showLen,
        dataLen: listLen,
        startPos: startPos,
        focusPos: focusPos,
        focusDiv: 'list_focus',
        focusPlace: {left: 354, top: 177},
        focusStep: {left: 180, top: 232}
    });
}

function clearListData(iPos, dPos) {
    $('list_icon' + iPos).src('images/tm.gif');
    $('list_name' + iPos).bgImage('images/tm.gif').text('');
}

function initDownList() {
    for (var i = pageNum * showLen; i < (pageNum * showLen + 5); i++) {
        if (i < listLen) {
            var data = currVodList[i];
            $('list_down_icon' + i % showLen).src(data.icon);
            //$('list_down_name'+i%showLen).bgImage('images/vod_name_bg.png');
            //$('list_down_name'+i%showLen).text($.substr(data.name,8,''));
        }
        else {
            $('list_down_icon' + i % showLen).src('images/tm.gif');
            //$('list_down_name'+i%showLen).bgImage('images/tm.gif').text('');
        }
    }
}

function initCategoryList() {
    categoryListBox = new $.plugs.list();
    categoryListBox.haveData = function (iPos, dPos) {
        $('type' + iPos).bgImage('').color('#686767');
        if (categoryPos == dPos)
            $('type' + categoryPos % cateShowLen).bgImage('images/type_select.png').color('#FFFFFF');
        var data = JSON.parse(JSON.parse(vodtypelist).video_categories[dPos]);
        var nameStr = '';
        /*if (data.id == 0)
         nameStr = '专题院线';
         else*/
        nameStr = data.video_category_name;
        $('type' + iPos).text($.substr(nameStr, 12, ''));
    };
    categoryListBox.noData = clearCategoryListData;
    categoryListBox.init({
        showType: 't',
        pageStyle: 1,
        showLen: cateShowLen,
        dataLen: categoryLen,
        startPos: cateStartPos,
        focusPos: cateFocusPos
    });
}

function clearCategoryListData(iPos, dPos) {
    $('type' + iPos).bgImage('').color('#686767').text('');
}

function initUpDown() {
    $('up').src(categoryListBox.startPos == 0 ? 'images/tm.gif' : 'images/type_up.png');
    $('down').src(categoryListBox.startPos + categoryListBox.showLen >= categoryListBox.dataLen ? 'images/tm.gif' : 'images/type_down.png');
}
function initCategoryInfo() {
    var data = vodList[categoryPos];    
    var nameStr = '';
    /*if (data.id == 0)
     nameStr = '专题院线';
     else*/
    //nameStr = data.name;//160314
    $('categoryName').text(nameStr);
    $('currNum').text(listBox.dataPos + 1);
    $('totalNum').text("/" + listLen);
}

/**************处理焦点样式****************/

function setFocusStyle(__num) {
    switch (focusArea) {
        case 0:
            if (categoryPos == categoryListBox.dataPos) {
                $('type' + categoryListBox.focusPos).bgImage(['images/type_select.png', 'images/type_focus.png'][__num]);
                $('type' + categoryListBox.focusPos).color(['#FFFFFF', '#FFFFFF'][__num]);
            }
            else {
                $('type' + categoryListBox.focusPos).bgImage(['', 'images/type_focus.png'][__num]);
                $('type' + categoryListBox.focusPos).color(['#686767', '#FFFFFF'][__num]);
            }
            break;
        case 1:
            if (listBox != null) {
                if (__num > 0)
                    listBox.focus();
                else
                    listBox.blur();
                $('list_name' + listBox.focusPos).color(__num > 0 ? '#02acfd' : '#ffffff');
            }
            break;
    }
}
/**************左右键处理*****************/
var tmpposvalue = 0;//临时listBox.dataPos值
var tmpfocusvalue = 0;//临时listBox.focusPos值
function keyLeftRight(__num) {//1:right -1:left
    switch (focusArea) {
        case 0:
            if (__num > 0 && listBox != null && listLen > 0)
                changeFocusArea(1);
            break;
        case 1:
            //if(__num < 0 && listBox.isLimit('l')){
            //changeFocusArea(0);
            //return;
            //}
            if (__num < 0 && pageNum > 1 && listBox.isLimit('t') && listBox.isLimit('l')) {
                tmpposvalue = listBox.dataPos - 1;
                tmpfocusvalue = 9;
                changePage(__num);
                tmpposvalue = 0;
                tmpfocusvalue = 0;
                initDownList();
            } else if (__num > 0 && pageNum > 0 && listBox.isLimit('b') && listBox.isLimit('r')) {
                changePage(__num);
                initDownList();
            } else {
                setFocusStyle(0);
                listBox.changeList(__num);
                setFocusStyle(1);
            }
            $('currNum').text(listBox.dataPos + 1);
            break;

    }
}
/**************上下键处理*****************/
var keyupleft = 0;//0:leftright 1:updown
function keyUpDown(__num) {//_num -1:up 1:down
    switch (focusArea) {
        case 0:
            if (categoryListBox.dataPos == 0 && __num < 0)
                return;
            if (categoryListBox.dataPos == JSON.parse(vodtypelist).video_categories.length - 1 && __num > 0)
                return;
            setFocusStyle(0);
            categoryListBox.changeList(__num);
            setFocusStyle(1);
            initUpDown();
            selectType();
            break;
        case 1:
            if (__num > 0 && listBox != null && totalPage > 1 && listBox.isLimit('b')) {
                keyupleft = 1;
                tmpposvalue = listBox.dataPos + 5;
                tmpfocusvalue = listBox.focusPos - 5;
                changePage(__num);
                tmpposvalue = 0;
                tmpfocusvalue = 0;
                keyupleft = 0;
                initDownList();
            } else if (__num < 0 && pageNum > 1 && listBox.isLimit('t')) {
                tmpposvalue = listBox.dataPos - 5;
                tmpfocusvalue = listBox.focusPos + 5;
                changePage(__num);
                tmpposvalue = 0;
                tmpfocusvalue = 0;
                initDownList();
            } else {
                setFocusStyle(0);
                listBox.changeList(__num * listBox.showCols);
                setFocusStyle(1);
            }
            $('currNum').text(listBox.dataPos + 1);
            break;
    }
}
/**************翻页键处理*****************/
function changePage(__num) {//up:-1  down:1
    switch (focusArea) {
        case 0:
            break;
        case 1:
            if (listBox == null)
                break;

            var tmpPage = pageNum + __num;

            if (tmpPage < 1 || tmpPage > totalPage)
                break;

            pageNum = tmpPage;
            setFocusStyle(0);
            var tmpp = 0;//0 1 listBox.isLimit('b')
            if (__num > 0 && listBox.isLimit('b') && (listBox.dataPos + 5) < listLen && keyupleft == 1) {
                tmpp = 1;
                //keyupleft=0;
            }
            listBox.changePage(__num);
            //if (__num < 0 && listBox.isLimit('t') && listBox.isLimit('l')) {
            if (__num < 0 && listBox.isLimit('t')) {
                listBox.dataPos = tmpposvalue;
                listBox.focusPos = tmpfocusvalue;
            }
            if (__num > 0 && tmpp == 1) {
                listBox.dataPos = tmpposvalue;
                listBox.focusPos = tmpfocusvalue;
                tmpp = 0;
            }
            setFocusStyle(1);
            break;

    }
}

/**************切换焦点区域*****************/
function changeFocusArea(__num) {
    switch (focusArea) {//0:type 1:list
        case 0:
            setFocusStyle(0);
            break;
        case 1:
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
            break;
    }
}

/**************确定键处理*****************/
var storage = window.sessionStorage;
function doOk() {
    switch (focusArea) {
        case 0:
            //if(__num > 0 && listBox != null && listLen > 0) changeFocusArea(1);
            //if(listBox != null && listLen > 0) changeFocusArea(1);
            //selectType();
            break;
        case 1://1:详情
            var tmpvodinfo=JSON.stringify(vodList[cateFocusPos].list[listBox.dataPos].vodInfo);
            console.log("dok=========="+tmpvodinfo);
            window.sessionStorage.setItem("hotelfilmdetailinfo",tmpvodinfo);
            location.href = 'detail_single.htm';
            //document.getElementById("detail_single").style.display="block";
            //$('movie').hide();
            // $('list_focus').hide();
            //$('detail_single').show();
            break;
    }
}
/**************功能函数区域*****************/
function selectType() {
    if (categoryPos == categoryListBox.dataPos)
        return;
    $('type' + categoryPos % cateShowLen).bgImage('').color('#686767');
    categoryPos = categoryListBox.dataPos;
    cateStartPos = categoryListBox.startPos;
    cateFocusPos = categoryListBox.focusPos;
    if (vodList[cateFocusPos].list.length <= 0) {
        MovieTypeChooseData();
    }
    currVodList = vodList[cateFocusPos].list;
    listLen = currVodList.length;
    if(listLen==0){
        clearListData(0,0);
    }
    pageNum = 1;
    totalPage = Math.ceil(listLen / showLen);
    startPos = 0;
    focusPos = 0;
    
    initListBox();
    initDownList();
    initCategoryInfo();
}

function initClock() {
    var datetime = $.date.format('yyyyMMddHHmm');
    $.each(datetime.split(''), function (v, k) {
        $('dt' + k).src('images/num' + v + '.png');
    });
    setTimeout(initClock, 60000);
}

function onBackButtonCallback() {
    console.log("***********>>>>>>>>>>>>>>>>>>>>>>>>BACKBUTTON>>>>>>>>>>>>>>>>>>>>>>>>");
    var ikey = "BACK";

    $.plugs.keyProcess(ikey, {});
}
document.addEventListener("deviceready", init, false);

//获取不同类型的影片数据
var vodList;
function MovieTypeChooseData() {
    console.log("choose=============================");
     //vodList[0].list=[];
     var typeindex = JSON.parse(JSON.parse(vodtypelist).video_categories[cateFocusPos]).video_category_id;
    jQuery.noConflict();//$.noConflict();
    jQuery(document).ready(function ($) {
       if(storagelocal.hotelmoviestorage==null||JSON.parse(storagelocal.getItem("hotelmoviestorage"))[cateFocusPos].list.length<=0){
            console.log("==============VOD=localstorage=null=<length====================");
            HtpDataMovie.get("../../hotel_api/video_detail.php?video_category_id=" + typeindex, 5000, function (data) {
            console.log("http get success--------!");
            tmpobj = JSON.parse(data);
            for (var i = 0; i < tmpobj.video_details.length; i++) {
                tmp_detail = JSON.parse(tmpobj.video_details[i]);
                var tmpvodlist = {};
                tmpvodlist.icon = tmp_detail.video_thumbnail_address;
                tmpvodlist.price = tmp_detail.video_price_single;
                tmpvodlist.name = tmp_detail.video_name;
                tmpvodlist.vodInfo = {};
                tmpvodlist.vodInfo.icon = tmp_detail.video_thumbnail_address;
                tmpvodlist.vodInfo.desc = tmp_detail.video_introduction;
                tmpvodlist.vodInfo.score = tmp_detail.video_rating;
                tmpvodlist.vodInfo.actor = tmp_detail.video_star;
                tmpvodlist.vodInfo.type = tmp_detail.video_price_single;
                tmpvodlist.vodInfo.director = tmp_detail.video_director;
                tmpvodlist.vodInfo.time = tmp_detail.video_online_time;
                tmpvodlist.vodInfo.duration = tmp_detail.video_duration;
                tmpvodlist.vodInfo.area = tmp_detail.video_area;
                tmpvodlist.vodInfo.price = tmp_detail.video_price_single;
                tmpvodlist.vodInfo.resList=[];
                tmpvodlist.vodInfo.resList[0]={};
                tmpvodlist.vodInfo.resList[0].playUrl = tmp_detail.video_url;
                tmpvodlist.vodInfo.name = tmp_detail.video_name;
                vodList[cateFocusPos].list[i] = tmpvodlist;
            }
            
            categoryLen = vodList[categoryPos].list.length;
            if (categoryLen < 1)
                return;
            currVodList = vodList[categoryPos].list
            //currVodList = vodList[0].list;
            console.log("currVodList.length=" + currVodList.length);
            listLen = categoryLen;
            totalPage = Math.ceil(listLen / showLen);
            initUpDown();
            initListBox();
            initDownList();
            initCategoryInfo();
            setFocusStyle(1);
            storagelocal.setItem("hotelmoviestorage",JSON.stringify(vodList));//0318
        }, function (data) {
            console.log("http get fail--------!");
        });//}else{console.log(">0");}
        }else{
            console.log("==============VOD=localstorage!=null===>length==================");
            vodList=JSON.parse(storagelocal.getItem('hotelmoviestorage'));//storagelocal.hotelmoviestorage);
            categoryLen = vodList[categoryPos].list.length;
            if (categoryLen < 1)
                return;
            currVodList = vodList[categoryPos].list
            //currVodList = vodList[0].list;
            console.log("currVodList.length=" + currVodList.length);
            listLen = categoryLen;
            totalPage = Math.ceil(listLen / showLen);
            initUpDown();
            initListBox();
            initDownList();
            initCategoryInfo();
            setFocusStyle(1);
        }
    });
    //break;
}

//获取影片类型
var vodtypelist;
function MovieTypeData() {
    console.log("=======MovieTypeData==========");
    jQuery.noConflict();
    jQuery(document).ready(function ($) {
        HtpDataMovie.get("../../hotel_api/video_category.php", 5000, function (data) {
            console.log("MovieType get success--------!");
            vodtypelist = data;
            console.log(vodtypelist);
            categoryLen = JSON.parse(vodtypelist).video_categories.length;
            var tmpvarry=JSON.parse(vodtypelist).video_categories;
            for(var i=0;i<categoryLen;i++){
                var tmptypelistchild={
                        "id": 31,
                        "price": 0,
                        "name": "动作片",
                        "validTime": 0,
                        "list": []
                    };
                tmptypelistchild.id=JSON.parse(tmpvarry[i]).video_category_id;
                tmptypelistchild.name=JSON.parse(tmpvarry[i]).video_category_name;
                vodList[i]=tmptypelistchild;
             }
            
            initCategoryList();
            MovieTypeChooseData();
        }, function (data) {
            console.log("MovieType get fail--------!");
        });
    }
    )
}
var HtpDataMovie = {
    ajaxobj: null,
    url: "../../hotel_api/video_category.php",
    timeout: 0,
    successCallback: function () {
    },
    failCallback: function () {
    },
    get: function (url, timeout, successCallback, failCallback) {
        this.url = url;
        this.timeout = timeout;
        this.successCallback = successCallback;
        this.failCallback = failCallback;
        this.ajaxobj = jQuery.ajax({
            url: HtpDataMovie.url,
            timeout: HtpDataMovie.timeout,
            type: "get",
            success: function (response, textStatus) {
                if (textStatus == 'success') {
                    console.log("ajax success~!!");
                    HtpDataMovie.successCallback(response);
                }
            },
            error: function (response, textStatus) {
                if (textStatus == 'error') {
                    console.log("ajax error~!!");
                    HtpDataMovie.failCallback(response);
                }
            },
            complete: function (response, textStatus) {
                if (textStatus == 'timeout') {
                    console.log("ajax timeout~!!");
                    HtpDataMovie.failCallback({msg: textStatus});
                    HtpDataMovie.ajaxobj.abort();
                }
            }

        });
    }
}

