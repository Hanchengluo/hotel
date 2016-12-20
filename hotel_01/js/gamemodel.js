
var gamesdatasum = JSON.parse(JSON.stringify(gamesdatas)).gamesarray.length;
function GamesHandleKeyDown(iKey) {
    //console.log("game==keydown====");
    switch (iKey) {
        case IRKEY_UP:
            UpDowngamesfocus(true);
            break;
        case IRKEY_DOWN:
            UpDowngamesfocus(false);
            break;
        case IRKEY_SELECT:
            //window.localStorage.setItem("hotelgamestatus",totalstatus.games);
            window.sessionStorage.setItem("hotelgamestatus",totalstatus.games)
            if (gamesdataindex == 2) {
                window.location.href = appUrl[2];
                //进入其他应用
            }/*else if(gamesdataindex==1){
                window.location.href = appUrl[3];
            }else{}*/
            break;
        case IRKEY_EXIT:
            gamesdataindex=0;//clear       
            $("#gamenownum").html(0);
            document.getElementById("gamelist_0").style.background = "url(img/type_focus.png) no-repeat center";
            $("#gamelist_0").css("background-size", "330px");
            document.getElementById("gamelist_1").style.background = "url(img/tm.png) no-repeat center";
            $("#gamelist_0").css("background-size", "330px");
            document.getElementById("gamelist_2").style.background = "url(img/tm.png) no-repeat center";
            $("#gamelist_0").css("background-size", "330px");
            document.getElementById("gamelist_3").style.background = "url(img/tm.png) no-repeat center";
            $("#gamelist_0").css("background-size", "330px");
            document.getElementById("gamelist_4").style.background = "url(img/tm.png) no-repeat center";
            $("#gamelist_0").css("background-size", "330px");
            $("#gamebigimg").attr("src", JSON.parse(JSON.stringify(gamesdatas)).gamesarray[0].gamebigimg);
            gamesupdownfocusindex = 0;//光标下标(从0-11的切换)
            tmpupfocusindex = -1;//临时切换光标
            tmpdownfocusindex = -1;//临时切换光标
            tmpupgamesdataindex = -1;//临时切换数据下标
            tmpdowngamesdataindex = -1;//clear
           // window.localStorage.removeItem("hotelgamestatus");
            window.sessionStorage.removeItem("hotelgamestatus");
            totalcurrent=totalstatus.homepage;
            document.getElementById("gamemodel").style.display="none";
            document.getElementById("main").style.display="block";
        break;
        default:
            break;
    }
}
var gamesdataindex = 0;//数据下标
var gamesupdownfocusindex = 0;//光标下标(从0-11的切换)
var tmpupfocusindex = -1;//临时切换光标
var tmpdownfocusindex = -1;//临时切换光标
var tmpupgamesdataindex = -1;//临时切换数据下标
var tmpdowngamesdataindex = -1;//临时切换数据下标

function UpDowngamesfocus(Ftrue) {
    if (Ftrue == true) {//true:up false:down
        tmpupfocusindex = -1;
        tmpupgamesdataindex = -1;
        if (tmpdowngamesdataindex != -1 && tmpdowngamesdataindex >= 0) {
            gamesdataindex = tmpdowngamesdataindex;
            tmpdowngamesdataindex--;
        }
        if (gamesdataindex <= 0) {
            gamesdataindex = gamesdatasum - 1;
            gamesupdownfocusindex = 5;
            
        } else {
            gamesdataindex--;
        }
        GamesFocusClear();
        $("#gamenownum").html(gamesdataindex + 1);
        $("#gamerightname").html(JSON.parse(JSON.stringify(gamesdatas)).gamesarray[gamesdataindex].gamename);
        $("#gamebigimg").attr("src", JSON.parse(JSON.stringify(gamesdatas)).gamesarray[gamesdataindex].gamebigimg);
        if (tmpdownfocusindex != 0 && tmpdownfocusindex > 0) {
            gamesupdownfocusindex = tmpdownfocusindex;
            tmpdownfocusindex--;
        }
        gamesupdownfocusindex--;
        if (gamesupdownfocusindex >= 0) {
            GamesFocusShow(gamesupdownfocusindex);
            if (tmpdowngamesdataindex != -1 && tmpdowngamesdataindex >= 0) {
                //nothing
            } else {
                GamesListClear();
                for (var i = 0; i < gamesdatasum; i++) {
                    if (i + ((gamesdatasum - 1) - 4) == gamesdatasum) {
                        break;
                    }
                    $("#gamelist_" + i).html(JSON.parse(JSON.stringify(gamesdatas)).gamesarray[i + ((gamesdatasum - 1) - 4)].gamename);
                }
            }
            tmpupfocusindex = gamesupdownfocusindex;
            tmpupgamesdataindex = gamesdataindex;
        } else {
            GamesListClear();
            GamesFocusShow(0);
            for (var i = 0; i < gamesdatasum; i++) {
                if (i + gamesdataindex == gamesdatasum) {
                    break;
                }
                $("#gamelist_" + i).html(JSON.parse(JSON.stringify(gamesdatas)).gamesarray[i + gamesdataindex].gamename);
            }
            gamesupdownfocusindex = 0;
            tmpupfocusindex = 0;
            tmpupgamesdataindex = gamesdataindex;
        }
    } else {//down
        tmpdownfocusindex = -1;
        tmpdowngamesdataindex = -1;
        if (tmpupgamesdataindex != -1 && tmpupgamesdataindex <= gamesdatasum - 1) {
            gamesdataindex = tmpupgamesdataindex;
            tmpupgamesdataindex++;
        }
        if (gamesdataindex >= gamesdatasum - 1) {
            GamesListClear();
            gamesdataindex = 0;
        } else {
            gamesdataindex++;
        }
        GamesFocusClear();
        $("#gamenownum").html(gamesdataindex + 1);
        $("#gamerightname").html(JSON.parse(JSON.stringify(gamesdatas)).gamesarray[gamesdataindex].gamename);
        console.log("=0203==down==<5="+gamesdataindex+"="+JSON.parse(JSON.stringify(gamesdatas)).gamesarray[gamesdataindex].gamename)
        $("#gamebigimg").attr("src", JSON.parse(JSON.stringify(gamesdatas)).gamesarray[gamesdataindex].gamebigimg);
        if (gamesdataindex < 5 && gamesdataindex >= 0) {
            console.log("20160201--数据下标<5===" + gamesdataindex);
            if (tmpupfocusindex != -1 && tmpupfocusindex < 4) {
                tmpupfocusindex++;
                GamesFocusShow(tmpupfocusindex);
            } else {
                for (var i = 0; i < 5; i++) {
                    $("#gamelist_" + i).html(JSON.parse(JSON.stringify(gamesdatas)).gamesarray[i].gamename);
                }
                GamesFocusShow(gamesdataindex);
                tmpupfocusindex = -1;
            }
            tmpdownfocusindex = gamesdataindex;
            tmpdowngamesdataindex = gamesdataindex;
            
        } else if (gamesdataindex >= 5) {
            if (tmpupfocusindex != -1 && tmpupfocusindex < 4) {
                tmpupfocusindex++;
                GamesFocusShow(tmpupfocusindex);
                tmpdownfocusindex = tmpupfocusindex;
                tmpdowngamesdataindex = gamesdataindex;
            } else {
                GamesListClear();
                GamesFocusShow(4);
                for (var i = 0; i < gamesdatasum; i++) {
                    if (i + (gamesdataindex - 4) == gamesdatasum) {
                        break;
                    }
                    $("#gamelist_" + i).html(JSON.parse(JSON.stringify(gamesdatas)).gamesarray[i + (gamesdataindex - 4)].gamename);
                }
                tmpdownfocusindex = 4;
                tmpdowngamesdataindex = gamesdataindex;
            }

        }
        console.log("上下切换===down=" + gamesdataindex);
    }
}
//光标定位
function GamesFocusShow(index) {
    switch (index) {
        case 0:
            document.getElementById("gamelist_" + index).style.background = "url(img/type_focus.png) no-repeat center";
            $("#gamelist_" + index).css("background-size", "330px");
            break;
        case 1:
            document.getElementById("gamelist_" + index).style.background = "url(img/type_focus.png) no-repeat center";
            $("#gamelist_" + index).css("background-size", "330px");
            break;
        case 2:
            document.getElementById("gamelist_" + index).style.background = "url(img/type_focus.png) no-repeat center";
            $("#gamelist_" + index).css("background-size", "330px");
            break;
        case 3:
            document.getElementById("gamelist_" + index).style.background = "url(img/type_focus.png) no-repeat center";
            $("#gamelist_" + index).css("background-size", "330px");
            break;
        case 4:
            document.getElementById("gamelist_" + index).style.background = "url(img/type_focus.png) no-repeat center";
            $("#gamelist_" + index).css("background-size", "330px");
            break;
        default:
            break;
    }
}
//光标clear
function GamesFocusClear() {
    $("#gamenownum").html(0);
    document.getElementById("gamelist_0").style.background = "url(img/tm.png) no-repeat center";
    document.getElementById("gamelist_1").style.background = "url(img/tm.png) no-repeat center";
    document.getElementById("gamelist_2").style.background = "url(img/tm.png) no-repeat center";
    document.getElementById("gamelist_3").style.background = "url(img/tm.png) no-repeat center";
    document.getElementById("gamelist_4").style.background = "url(img/tm.png) no-repeat center";
}
//列表clear
function GamesListClear() {
    for (var i = 0; i < 5; i++) {
        $("#gamelist_" + i).html("");
    }
}
//列表初始显示
function GamesListShow() {
    console.log("--game-first-show--");
    $("#gametotalnum").html(gamesdatasum);
    if(gamesdatasum>0){
        $("#gamenownum").html(1);
    }else{
        $("#gamenownum").html(0);
    }
    if (gamesdatasum > 0) {
        $("#gamerightname").html(JSON.parse(JSON.stringify(gamesdatas)).gamesarray[0].gamename);
    }
    for (var i = 0; i < 5; i++) {
        $("#gamelist_" + i).html(JSON.parse(JSON.stringify(gamesdatas)).gamesarray[i].gamename);
    }

}
