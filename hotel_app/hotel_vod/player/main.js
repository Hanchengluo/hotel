var curVol = 1;
var VOL_MAX_LENGTH = 230;
var mediaPlayer;

function playVideo(serviceLocation) {
  if (serviceLocation) {
  	console.log("@@@@@@@@@@@@@@@@@@@@@the video have src@@@@@@@@@@@@@@@@@@");
    console.log("serviceLocation : " + serviceLocation);
    mediaPlayer.setSrc(serviceLocation);
  } else {
  	console.log("@@@@@@@@@@@@@@@@@@@@@the video have no src@@@@@@@@@@@@@@@");
    mediaPlayer.closeVideo();
  }
}

function onBackButtonCallback() {
  console.log("***********>>>>>>>>>>>>>>>>>>>>>>>>BACKBUTTON>>>>>>>>>>>>>>>>>>>>>>>>");
  location.href = "../../hotel_app/hotel_vod/detail_single.htm";
}

document.addEventListener("deviceready", function(){
	IRKEY_EXIT = 8; //退出

    IRKEY_LEFT = 37; //左
    IRKEY_RIGHT = 39; //右
    IRKEY_UP = 38; //上
    IRKEY_DOWN = 40; //下
    IRKEY_SELECT = 13; //确认
    IRKEY_CHANNEL_UP = 33; //节目+
    IRKEY_CHANNEL_DOWN = 34; //节目-
    IRKEY_FASTB = window.AKEYCODE_BUTTON_10; //快退
    IRKEY_FASTF = window.AKEYCODE_BUTTON_16; //快进
    IRKEY_RED = window.AKEYCODE_PROG_RED; //红键
    IRKEY_GREEN = 40960; //绿键
    IRKEY_VOLUME_MUTE = 101; //静音
	mediaPlayer = new MediaPlayer();
	addEventListener("keydown", mediaPlayer.handleKeyDown, false);
	playVideo("./lmkz_bak.mp4");
  document.addEventListener("backbutton", onBackButtonCallback);
}, false);

