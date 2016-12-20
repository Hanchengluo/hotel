var appUrl = ["../hotel_app/hotel_intro/", "../hotel_app/hotel_vod/", "../hotel_app/2048/","../hotel_app/duimutou/"];
var index = 0;
var praIndex = 0;
var remoindTimer = null;
var storege = window.localStorage;
var totalstatus = {//状态
    homepage:"homepage",
    orderfood:"orderfood",
    games:"games"
};
var totalcurrent=totalstatus.homepage;
function moveFocus(bLeft) {
	praIndex = index;
	if (bLeft) {
		if (index <= 0) {
			index = 3;
		} else {
			index--;
		}
	} else {
		if (index >= 3) {
			index = 0;
		} else {
			index++;
		}
	}
	$("#a" + index + " img").attr("src", "./img/a" + index + "_focus.png");
	$("#a" + index).addClass("focus_select");
	$("#a" + praIndex + " img").attr("src", "./img/a" + praIndex + ".png");
	$("#a" + praIndex).removeClass("focus_select");
	showLoadingIcon(false);
}

function enterApp(index) {
    if (index == 3) {
        //clearTimeout(remoindTimer);
        //$("#remind").css("display", "block");
        //remoindTimer = setTimeout(function() {
        //	$("#remind").css("display", "none");
        //}, 1000);
        totalcurrent = totalstatus.orderfood;
        document.getElementById("foodmodule").style.display = "block";
        MenuTypeChooseData(1);
    } else if (index == 2) {
        totalcurrent = totalstatus.games;
        document.getElementById("gamemodel").style.display = "block";
        GamesListShow();
    } else if (index == 1) {
        //window.localStorage.setItem("hotelplaystatus",totalstatus.homepage);
        window.location.href = appUrl[index];
    } else {
        showLoadingIcon(true);
        //window.location.href = appUrl[index];进入其他应用
        window.location.href = appUrl[0];
    }

}
function HomepageHandleKeyDown(keys) {
    switch (keys) {
        //select
        case 13:
        case IRKEY_SELECT:
            enterApp(index);
            storege.setItem("index", index);
            break;
            //left
        case 37:
        case IRKEY_LEFT:
            moveFocus(true);
            break;
            //right
        case 39:
        case IRKEY_RIGHT:
            moveFocus(false);
            break;
            //up
        case 38:
        case IRKEY_UP:
            break;
            //down
        case 40:
        case IRKEY_DOWN:
            break;
            //back
        case 8:
        case IRKEY_EXIT:
            if ($("#remind").css("display") == "block") {
                clearTimeout(remoindTimer);
                $("#remind").css("display", "none");
            } else {
                navigator.app.exitApp();
                storege.removeItem('hotelmoviestorage');
                storege.removeItem('chinesefoodstorage');
                storege.removeItem('westernstylestorage');
                storege.removeItem('specialfoodstorage');
                storege.removeItem('fruitstorage');
                storege.removeItem('dessertfoodstorage');
            }
            break;
        default:
            break;
    }
}
function handleKeyDown(keys) {
    var iKey = keys.keyCode || event.keyCode;
    switch (totalcurrent) {
        case totalstatus.homepage:
            HomepageHandleKeyDown(iKey);
            break;
        case totalstatus.orderfood:
            OrderfoodHandleKeyDown(iKey);
            break;
        case totalstatus.games:
            GamesHandleKeyDown(iKey);
        break;
        default:
            break;
    }
}

/*resume事件处理函数*/

function onResumeCallback(obj) {
	/* play dvb service*/
	console.log("@@@@@@@>>>>>>>>>>>>>>>>>>>onResumeCallback");
	welcomeVideo();
}

function onBackButtonCallback() {
	console.log("***********>>>>>>>>>>>>>>>>>>>>>>>>BACKBUTTON>>>>>>>>>>>>>>>>>>>>>>>>");
	var ikey = {
		keyCode: IRKEY_EXIT
	};
	handleKeyDown(ikey);
}

function showLoadingIcon(bShow){
	if(bShow){
		console.log("show loading!!!!");
		$("#loading").css("display","block");
	}else {
		console.log("hide loading!!!!");
		$("#loading").css("display","none");
	}
}

function init() {
    console.log("------------init-------------------");
    //console.log("window.localStorage.hotelgamestatus==" + window.localStorage.getItem("hotelgamestatus"));
    console.log("window.sessionStorage.hotelgamestatus==" + window.sessionStorage.getItem("hotelgamestatus"));
    //if (window.localStorage.getItem("hotelgamestatus") == totalstatus.games) {
      if (window.sessionStorage.getItem("hotelgamestatus") == totalstatus.games) {
        totalcurrent = totalstatus.games;
        enterApp(2);
        GamesListShow();
    }else{
        document.getElementById("main").style.display = "block";
    }
    var tmpIndex = storege.getItem("index");
    if (tmpIndex == NaN || tmpIndex == null) {
        index = 0;
    } else {
        index = parseInt(tmpIndex);
    }
    $("#a" + index + " img").attr("src", "./img/a" + index + "_focus.png");
    $("#a" + index).addClass("focus_select");
    document.addEventListener("backbutton", onBackButtonCallback);
    //window.addEventListener("keydown", handleKeyDown, false);
    addEventListener("keydown", handleKeyDown, false);

}

//window.addEventListener("load", init, false);
document.addEventListener("deviceready", init, false);

var gamesdatas={
    "gamesarray":[
        {"gamename":"俄罗斯-1","gamebigimg":"img/2048_1.png"},
        {"gamename":"堆木头-2","gamebigimg":"img/mutou_1.png"},
        {"gamename":"2048-3","gamebigimg":"img/2048_1.png"},
        {"gamename":"消消乐-4","gamebigimg":"img/xiaohappy.jpg"},
        {"gamename":"杀水果-5","gamebigimg":"img/shafruit.jpg"},
        {"gamename":"跳木板-6","gamebigimg":"img/mutou_1.png"},
        {"gamename":"疯狂石头-7","gamebigimg":"img/2048_1.png"},
        {"gamename":"快快跑-8","gamebigimg":"img/mutou_1.png"},
        {"gamename":"小墨仙-9","gamebigimg":"img/shafruit.jpg"},
        {"gamename":"川-10","gamebigimg":"img/mutou_1.png"},
        {"gamename":"木头-11","gamebigimg":"img/xiaohappy.jpg"},
        {"gamename":"大头-12","gamebigimg":"img/mutou_1.png"}
    ],
    "version":1.0
}
