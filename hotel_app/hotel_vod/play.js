/*************************************************
* 
*/                       
function MediaPlayer() {
/******************** for video playing ****************************/
  var VideoObj = function() {
  // public
  this.mediaSeekLen =function(){
  		console.log(">>>>>>>>>>>>>>>>>>>oMediaPlayer.duration====="+oMediaPlayer.duration);
  		seeking_len = Math.ceil(PROGRESS_BAR_MAX_LENGTH / oMediaPlayer.duration) * 10;
    	console.log("#######################################################");
    	console.log("####################"+seeking_len+"####################");
    	console.log("#######################################################");
  }
    this.handleKeyDown = function() {
      var keyCode = event.which
      this.showPlayerBar("测试片");
      switch (keyCode) {
      case IRKEY_RIGHT:
      	console.log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>IRKEY_UP");
        //calIndex(true);
                calVol(true);
      break;
      
       case IRKEY_LEFT:
      	console.log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>IRKEY_DOWN");
        //calIndex(false);
                calVol(false);
      break;
      //IRKEY_FASTF 快进  IRKEY_FASTB 快退
      case IRKEY_FASTB://快退
      case IRKEY_RED:
      	console.log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>IRKEY_LEFT");
                        seek_position(false);
      break;
      
      case IRKEY_FASTF://快进
      case IRKEY_GREEN:
      	console.log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>IRKEY_RIGHT");

                seek_position(true);
      break;

      case IRKEY_SELECT:
      	console.log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>IRKEY_SELECT");
      	console.log("@@@@@@@@@@@@@@@@@@@oMediaPalyer========"+oMediaPlayer);
        /*if (seeking_flag) { // Press enter key to play from the position seeked
          clearTimeout(seeking_timer_id);
          oMediaPlayer.currentTime = Math.ceil(
              (parseInt(playerBarProgressHeadEle.style.left) + 
                        PROGRESSBAR_HEAD_HALF_WIDTH) / 
              PROGRESS_BAR_MAX_LENGTH * Math.ceil(oMediaPlayer.duration));
          seeking_flag = false;
        } else */{
          if (oMediaPlayer) {
            if (oMediaPlayer.paused) {
              oMediaPlayer.play();
              this.showPlayIcon(false);
            } else {
              oMediaPlayer.pause();
              this.showPlayIcon(true);
            }
          }
          
          hidePlayerBarTimer();
        } 
      break;
      
      case IRKEY_VOLUME_MUTE:
      	console.log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>IRKEY_VOLUME_MUTE");
        oMediaPlayer.muted = !oMediaPlayer.muted;
        this.showMuteIcon(oMediaPlayer.muted);
      break;
      /*case IRKEY_GREEN:
      	console.log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>IRKEY_FASTF");
        seek_position(true);
        
      break;
      case IRKEY_RED:  
      	console.log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>IRKEY_FASTB");
        seek_position(false);
      break;*/
      
      default:
      break;
      }
    };
   
    this.hidePlayerBar = function() {
      clearTimer();
      //mp3和mp4播放过程中如果为音频不隐藏播放进度条
      if (!this.playingAudio) {
        playerBarEle.style.opacity = "0";
      }
    };
    
    this.showPlayerBar = function(name) {
      drawVolume();
      clearTimer();
      playerBarEle.style.opacity = "1";
      playerBarTitleEle.innerText = name;
      hidePlayerBarTimer();
    };
    
    this.mediaLoadStart = function() {
      console.log("===mediaLoadStart===");
      if (checkVideoList()) {
        showLoading(true);
        refreshPlayerInfo();
        playerBarTitleEle.innerText = videoList[videoListIndex].name;
      };
    };
    
    this.mediaStalled = function(event) {

    };
    
    this.mediaLoadedData = function() {

    };
    
    this.mediaCanPlay = function() {
      console.log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>===mediaCanPlay===<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<");
      if (oMediaPlayer) { 
      	console.log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>oMediaPlayer is true<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<");
      	console.log(">>>>>>>>>>src>>>>>>>>>>>>>>>>>>+"+document.getElementById("video").src);
        //oMediaPlayer.play();
      }
      if (checkVideoList()) {
        showLoading(false);
        self.showPlayerBar("测试片");
      }
    };
    
    this.mediaPlaying = function() {
      console.log("===mediaPlaying===");
    };
    
    this.mediaEnded = function() {
      console.log("@@@@@@@@@@@@@@===mediaEnded===");
      playerBarEle.style.opacity = "0";
      refreshPlayerInfo();
      // if (!parent.videoRemovedFlag) {
         calIndex(true); // Play the next video.
      // }
     // backToMain();
    };
  
    this.mediaTimeUpdate = function() {
      if (oMediaPlayer) {
        playerBarTimeEle.innerText = getTime(oMediaPlayer.currentTime) + 
                                  "/" + getTime(oMediaPlayer.duration);
        var tmp_value = (Math.ceil(oMediaPlayer.currentTime) / 
                   Math.ceil(oMediaPlayer.duration)) * PROGRESS_BAR_MAX_LENGTH;
        playerBarProgressEle.style.width = tmp_value + "px";
        tmp_value -= PROGRESSBAR_HEAD_HALF_WIDTH;
        if (!seeking_flag && oMediaPlayer) {
          playerBarProgressHeadEle.style.left = tmp_value + "px";
        }
      }
    };
    
    this.mediaPause = function() {
      console.log("===mediaPause===");
    };
    
    /****************************show element*********************************/
    this.showPlayIcon = function(flag) {
      showEle(playIconEle, flag);
    };
    
    this.showMuteIcon = function(flag) {
      showEle(muteIconEle, flag);
    };
    
    this.showAudioBK = function(flag) {
      showEle(audioBK, flag);//显示音频播放背景
      self.playingAudio = flag;
    }
    
  // private
    var showLoading = function(flag) {
      showEle(playerLoadingEle, flag);
    };
    
    var showEle = function(ele, flag) {
      if (flag) {
        ele.style.display = "block";
      } else {
        ele.style.display = "none";
      }
    };
    /****************************show element end*****************************/
    
  // private
    var hidePlayerBarTimerId;
    var loadNextTimerId;
    var self = this;
    
    var LOAD_NEXT_SRC_DURATION = 1000;
    
    var playerBarEle = document.getElementById("playerBar");
    var playerBarTitleEle = document.getElementById("playerBarTitle");
    var playIconEle = document.getElementById("playIcon");
    
    var playerBarTimeEle = document.getElementById("playerBarTime");
    var playerBarProgressEle = document.getElementById("playerBarProgress");
    var playerBarProgressHeadEle = document.getElementById("playerBarProgressHead");
    var playerLoadingEle = document.getElementById("playerLoading");  
    
    // Half size of the width of the image playerBarProgressHead
    var PROGRESSBAR_HEAD_HALF_WIDTH = 13; 
    
    // volume
    var curVolEle = document.getElementById("curvol");
    var curVolHeadEle = document.getElementById("curvolHead");
    var volNumEle = document.getElementById("volnum");
    var muteIconEle = document.getElementById("muteIcon");
    
    var audioBK = document.getElementById("audio_bk");
    
    var playingAudio = false;
    
    var calIndex = function(bUp) {
      if (!bUp) {
        videoListIndex = ((videoListIndex - 1) >= 0) ? 
                         (videoListIndex - 1) : (videoList.length - 1);
      } else {
        videoListIndex = ((videoListIndex + 1) < videoList.length) ? 
                         (videoListIndex + 1) : 0;
      }
      
      if (oMediaPlayer) {
        oMediaPlayer.pause();
        loadNext();
      }
    };
    
    var loadNext = function() {
      self.hidePlayerBar();
      clearTimeId(loadNextTimerId);
      loadNextTimerId = setTimeout(
        function() {
          setNextSrc();
        }, LOAD_NEXT_SRC_DURATION);
    };
    
    var setNextSrc = function() {
      mainList.setItemIndex(videoListIndex);
      parent.setCurPlayingName(videoList[videoListIndex].name);
      parent.setSrc(videoList[videoListIndex].fullPath);
      refreshPlayerInfo();
    };
    //时间、进度条、节目名置空
    var refreshPlayerInfo = function() {
      playerBarTimeEle.innerText = "00:00:00/00:00:00";
      playerBarProgressEle.style.width = "0px";
      playerBarProgressHeadEle.style.left = (-1 * PROGRESSBAR_HEAD_HALF_WIDTH) + "px";//playerBarProgress.style.width;
      playerBarTitleEle.innerText = "";
    };
    
  /****************************volume*****************************************/

    var calVol = function(flag) {
      oMediaPlayer.muted = false;
      self.showMuteIcon(false);
      if (flag) {
        curVol += 1;
        if (curVol > 100) {
          curVol = 100;
        }
      } else {
        curVol -= 1;
        if (curVol < 0) {
          curVol = 0;
        }
      }
      drawVolume();
      parent.setVolume(curVol / 100);
    };
    
    var drawVolume = function() {
      var tmpVal = parseInt((curVol * VOL_MAX_LENGTH) / 100);
      curVolEle.style.width = tmpVal + "px";
    
      tmpVal += 30;
      curVolHeadEle.style.left = tmpVal + "px";

      volNumEle.innerHTML = curVol;
    };
  /****************************volume end*************************************/
    
    var hidePlayerBarTimer = function() {
      clearTimer();
      hidePlayerBarTimerId = setTimeout(
        function() {
          self.hidePlayerBar();
        }, HIDE_PLAYER_BAR_DURATION);
    };
    
    var getTime = function(time) {
      var tmpTime = Math.ceil(time);
      if (!tmpTime) {
        tmpTime = 0;
      }
      
      var tmp_hour = tmpTime / 3600;
      var tmp_left_min = tmpTime % 3600;
      var tmp_min = tmp_left_min / 60;
      var tmp_sec = tmp_left_min % 60;
    
      return (formatTime(Math.floor(tmp_hour)) + ":" + formatTime(Math.floor(tmp_min)) + ":" + formatTime(Math.ceil(tmp_sec)));
    };
    //clearTimer
    var clearTimer = function() {
      clearTimeId(hidePlayerBarTimerId);
    };
    
    var seeking_flag = false;
    var seeking_timer_id;
    var PROGRESS_BAR_MAX_LENGTH = 1180;
    var seeking_len = 0;
    var seek_position = function(forward) {
      //清除barnner条的隐藏定时器
      clearTimeId(hidePlayerBarTimerId);
      seeking_flag = true;
      var tmpPos = parseInt(playerBarProgressHeadEle.style.left);
      console.log("@@@@@@@@@@@@@@@@tmpPos====="+tmpPos);
      tmpPos = forward ? (tmpPos + seeking_len) : (tmpPos - seeking_len);
      console.log("^^^^^^^@@@@@@@@@@@@@@@@tmpPos====="+tmpPos);
      if (tmpPos < (-1 * PROGRESSBAR_HEAD_HALF_WIDTH)) {
        tmpPos = (-1 * PROGRESSBAR_HEAD_HALF_WIDTH);
      } else if (tmpPos > (PROGRESS_BAR_MAX_LENGTH - PROGRESSBAR_HEAD_HALF_WIDTH)) {
        tmpPos = (PROGRESS_BAR_MAX_LENGTH - PROGRESSBAR_HEAD_HALF_WIDTH);
      }
      playerBarProgressHeadEle.style.left = tmpPos + "px";
      clearTimeout(seeking_timer_id);
      seeking_timer_id = setTimeout(function() {
        oMediaPlayer.currentTime = Math.ceil(
            (parseInt(playerBarProgressHeadEle.style.left) + 
                      PROGRESSBAR_HEAD_HALF_WIDTH) / 
            PROGRESS_BAR_MAX_LENGTH * Math.ceil(oMediaPlayer.duration));
        seeking_flag = false;
        hidePlayerBarTimer();
      }, 2000);
    };
    
  };
/******************** for media player ****************************/
// public
  this.handleKeyDown = function(keyCode) {
    videoObj.handleKeyDown(keyCode);
  };
  
  this.showPlayerBar = function(name) {
    videoObj.hidePlayerBar();
    videoObj.showPlayerBar(name);
  };
  
  this.setVideoList = function(contents, index) {
    videoList = contents;
    this.setVideoListIndex(index);
  };
  
  this.setVideoListIndex = function(index) {
    videoListIndex = index;
  };
  
  this.getVideoListIndex = function() {
    return videoListIndex;
  };
  
  this.setSrc = function(mediaSrc) {
    videoObj.showPlayIcon(false);
    this.createVideo();

    var ext = mediaSrc.substr(mediaSrc.lastIndexOf('.') + 1).toLowerCase();
    console.log("@@@@@@@@@@ext=========="+ext);
    
    
    this.showPlayerBar("测试片");
    
    if (oMediaPlayer) {
      console.log("@@@@@@@@@@@@@@@@@@oMediaPlayer is true");
      oMediaPlayer.setAttribute("src", mediaSrc);
      oMediaPlayer.play();
    }
  };
  
  this.pause = function() {
    if (oMediaPlayer) {
      oMediaPlayer.pause();
    }
  };
  
  this.setVolume = function(vol) {
    if (oMediaPlayer) {
      oMediaPlayer.volume = vol;
    }
  };
  
  this.addEventListener = function() {
    for (var key in MEDIA_EVENTS) {
      //console.log("^^^^^^^^^^^^^^^^^^^key===="+key);
      //console.log("^^^^^^^^^^^^^^^^^^^MEDIA_EVENTS[key]======="+MEDIA_EVENTS[key]);
      oMediaPlayer.addEventListener(MEDIA_EVENTS[key], mediaCapture, false);
    }
  };
  
  this.setMediaPlayer = function(media) {
    oMediaPlayer = media;
    console.log("@@@@@@@@@@@@@@oMediaPlayer======="+oMediaPlayer);
    this.addEventListener();
  };
  
  this.createVideo = function() {
  	//console.log("@@@@@@@@@@@@@@videoFrame.hasChildNodes()"+videoFrame.hasChildNodes());
//  	while (videoFrame.childNodes.length >= 1) {
//  		console.log("@@@@@@@@@@@@@@remove video....................");
//        videoFrame.removeChild(videoFrame.firstChild);
//    }
    if (!this.haveVideo) {
      console.log("@@@@@@@@@@@@@@@@@@videoFrame has no ChildNodes @@@@@@@@@@@@@@");
      // this.videoRemovedFlag = false;
      var tmpVideo = document.createElement("video");
      tmpVideo.id = "video";
      tmpVideo.className = "videoEle";
      tmpVideo.poster = "img/poster.png"
      videoFrame.appendChild(tmpVideo);
      this.setMediaPlayer(tmpVideo);
      this.haveVideo = true;
      this.setVolume(0.01);  
    }
  };
  
  this.closeVideo = function() {
    if (oMediaPlayer) {
      // this.videoRemovedFlag = true;
      oMediaPlayer.pause();
      console.log("@@@@@@@@@@@@@@@@@@@@@@set src clean............");
      console.log("@@@@@@@@@@@@@@@@@@@@@@set src clean......");
      console.log("@@@@@@@@@@@@@@@@@@@@@@set src clean............");
      //oMediaPlayer.setAttribute("src", "");
      oMediaPlayer.load();
//      while (videoFrame.childNodes.length >= 1) {
//        videoFrame.removeChild(videoFrame.firstChild);
//      }
//      oMediaPlayer = null;
      videoObj.showMuteIcon(false);
    }
  };
  
  this.setCurPlayingName = function(name) {
    curPlayingName = name;
  };
  
  this.getCurPlayingName = function() {
    return curPlayingName;
  };
  
  // this.videoRemovedFlag;

// private
  var oMediaPlayer = null;
  
  var videoList;
  var videoListIndex = 0;
  
  var videoFrame = document.getElementById("videoFrame");
  
  var HIDE_PLAYER_BAR_DURATION = 5000;
  
  var videoObj = new VideoObj();
  var parent = this;
  
  var curPlayingName;
  
  var formatTime = function(time) {
    return (time < 10 ? ("0" + time) : time);
  };
  
  var checkVideoList = function() {
    if (videoList) {
      return true;
    }
    return false;
  };
  
  var clearTimeId = function(timerId) {
    clearTimeout(timerId);
    timerId = null;
  };
  
  var MEDIA_EVENTS = ["loadstart", "progress", "suspend",
                      "error", "emptied", "stalled",
                      "loadedmetadata", "loadeddata", "canplay",
                      "canplaythrough", "playing", "waiting",
                      "seeking", "seeked", "ended",
                      "durationchange", "timeupdate", "play",
                      "pause", "ratechange", "volumechange"];
                      
  var MEDIA_EVENTS_TYPES = {LOAD_START: "loadstart",
                            PROGRESS: "progress",
                            SUSPEND: "suspend",
                            ERROR: "error",
                            EMPTIED: "emptied",
                            STALLED: "stalled",
                            LOADED_META_DATA: "loadedmetadata",
                            LOADED_DATA: "loadeddata",
                            CAN_PLAY: "canplay",
                            CAN_PLAY_THROUGH: "canplaythrough",
                            PLAYING: "playing",
                            WAITING: "waiting",
                            SEEKING: "seeking",
                            SEEKED: "seeked",
                            ENDED: "ended",
                            DURATION_CHANGE: "durationchange",
                            TIME_UPDATE: "timeupdate",
                            PLAY: "play",
                            PAUSE: "pause",
                            RATE_CHANGE: "ratechange",
                            VOLUME_CHANGE: "volumechange"}; 
  
  var mediaCapture = function(event) {
    console.log("@@@@@@@@@@@@@@event.type:" + event.type);
    switch (event.type) {
    case MEDIA_EVENTS_TYPES.LOAD_START:
      mediaLoadStart();
    break;
    
    case MEDIA_EVENTS_TYPES.PROGRESS:
    break;
    
    case MEDIA_EVENTS_TYPES.SUSPEND:
    break;
    
    case MEDIA_EVENTS_TYPES.ERROR:
      mediaEnded();
    break;
    
    case MEDIA_EVENTS_TYPES.EMPTIED:
    break;
    
    case MEDIA_EVENTS_TYPES.STALLED:
      mediaStalled();
    break;
    
    case MEDIA_EVENTS_TYPES.LOADED_META_DATA:
    break;
    
    case MEDIA_EVENTS_TYPES.LOADED_DATA:
      mediaLoadedData();
    break;
    
    case MEDIA_EVENTS_TYPES.CAN_PLAY:
      console.log("^^^^^^^^^^^^^^^^^^^^^^^^^^^^this video can play@@@@@@@@@@@@@@@@@");
      mediaCanPlay();
    break;
    
    case MEDIA_EVENTS_TYPES.PLAYING:
      mediaPlaying();
    break;
    
    case MEDIA_EVENTS_TYPES.WAITING:
    break;
    
    case MEDIA_EVENTS_TYPES.SEEKING:
    break;
    
    case MEDIA_EVENTS_TYPES.SEEKED:
    break;
    
    case MEDIA_EVENTS_TYPES.ENDED:
      mediaEnded();
    break;
    
    case MEDIA_EVENTS_TYPES.DURATION_CHANGE:
    	mediaSeekLen();
    break;
    
    case MEDIA_EVENTS_TYPES.TIME_UPDATE:
      mediaTimeUpdate();
    break;
    
    case MEDIA_EVENTS_TYPES.PLAY:
    break;
    
    case MEDIA_EVENTS_TYPES.PAUSE:
      mediaPause();
    break;
    
    case MEDIA_EVENTS_TYPES.RATE_CHANGE:
    break;
    
    case MEDIA_EVENTS_TYPES.VOLUME_CHANGE:
    break;
    
    default:
    break;
    }
  };
  var mediaSeekLen =function(){
  	videoObj.mediaSeekLen();
  }
  var mediaLoadStart = function() {
    videoObj.mediaLoadStart();
  };
  
  var mediaStalled = function() {
    videoObj.mediaStalled();
  };
  
  var mediaLoadedData = function() {
    videoObj.mediaLoadedData();
  };
  
  var mediaCanPlay = function() {
    videoObj.mediaCanPlay();
  };
  
  var mediaPlaying = function() {
    videoObj.mediaPlaying();
  };
  
  var mediaEnded = function() {
    videoObj.mediaEnded();
  };
  
  var mediaTimeUpdate = function() {
    videoObj.mediaTimeUpdate();
  };
  
  var mediaPause = function() {
    videoObj.mediaPause();
  };
}
