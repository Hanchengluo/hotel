var menustatus = {//订餐状态
    menutypelist: "menutypelist", //菜单类型列表
    menulist: "menulist", //菜单列表
    menudetailshow: "menudetailshow", //菜单详情
    cartmenulistshow: "cartmenulistshow"//购物车清单
};
var orderstorage = window.localStorage;
var current = menustatus.menutypelist;
var menutypefocusIndex = 1;//种类光标下标
var menulistIndex = 1;//菜单列表下标
var menulistfocusIndex = 1;//菜单列表光标下标
var datasum;//菜数量tmpobj.cookbook_details.length;
//菜单初始列表Show
function MenuListShow(tmpobj) {
    console.log("==========tmpobj.length==" + datasum);
    if (datasum <= 4 && datasum > 0) {
        for (var i = 1; i <= datasum; i++) {
            $("#img_" + i).attr("src", JSON.parse(tmpobj.cookbook_details[i - 1]).cookbook_thumbnail_address);
            $("#price_" + i).html("￥" + JSON.parse(tmpobj.cookbook_details[i - 1]).cookbook_price);
            $("#foodname_" + i).html(JSON.parse(tmpobj.cookbook_details[i - 1]).cookbook_name);
        }

    } else if (datasum > 4) {
        for (var i = 1; i < 6; i++) {
            $("#img_" + i).attr("src", JSON.parse(tmpobj.cookbook_details[i - 1]).cookbook_thumbnail_address);
            $("#price_" + i).html("￥" + JSON.parse(tmpobj.cookbook_details[i - 1]).cookbook_price);
            $("#foodname_" + i).html(JSON.parse(tmpobj.cookbook_details[i - 1]).cookbook_name);
        }
    } else {
        //datasum=null
        document.getElementById("menulist").style.display = "none";
        document.getElementById("menulist_focus").style.display = "none";
    }
    $("#nownum").html(0);
    $("#totelnum").html(datasum);
}
//右键，光标大于4,menulistIndex+1时列表显示
function RGthanfourShow() {
    console.log("===right->====focus>4=listshow=");
    MenuListClear();
    for (var i = 1; i < 7; i++) {
        if (i + (menulistIndex - 6) == datasum) {
            //return;
            break;
        }
        $("#img_" + (i - 1)).attr("src", JSON.parse(tmpobj.cookbook_details[i + (menulistIndex - 6)]).cookbook_thumbnail_address);
        $("#price_" + (i - 1)).html("￥" + JSON.parse(tmpobj.cookbook_details[i + (menulistIndex - 6)]).cookbook_price);
        $("#foodname_" + (i - 1)).html(JSON.parse(tmpobj.cookbook_details[i + (menulistIndex - 6)]).cookbook_name);
    }
}
//左键，光标小于1时倒序初始化显示列表
function LeftReverseListShow() {
    console.log("===<-left====focus<1=initlistshow=");
    MenuListClear();
    for (var i = 1, y = 5; i < 5, y > 0; i++, y--) {
        $("#img_" + (y - 1)).attr("src", JSON.parse(tmpobj.cookbook_details[menulistIndex - i]).cookbook_thumbnail_address);
        $("#price_" + (y - 1)).html("￥" + JSON.parse(tmpobj.cookbook_details[menulistIndex - i]).cookbook_price);
        $("#foodname_" + (y - 1)).html(JSON.parse(tmpobj.cookbook_details[menulistIndex - i]).cookbook_name);
    }
}
//左键，menulistIndex-1时数据显示
function LeftlessthanShow() {
    console.log("===<-left-move====menulistIndex-1=listshow=");
    MenuListClear();
    for (var i = 0, y = 6; i < 5, y > 0; i++, y--) {
        if ((menulistIndex + 3 - i) < 0) {
            console.log("跳出");
            //return;
            break;
        }
        if ((menulistIndex + 3 - i) == datasum) {
            console.log("暂跳");
            continue;
        }
        $("#img_" + (y - 1)).attr("src", JSON.parse(tmpobj.cookbook_details[(menulistIndex + 3) - i]).cookbook_thumbnail_address);
        $("#price_" + (y - 1)).html("￥" + JSON.parse(tmpobj.cookbook_details[(menulistIndex + 3) - i]).cookbook_price);
        $("#foodname_" + (y - 1)).html(JSON.parse(tmpobj.cookbook_details[(menulistIndex + 3) - i]).cookbook_name);
    }
}
//菜单列表clear
function MenuListClear() {
    document.getElementById("menulist").style.display = "block";
    for (var i = 0; i < 6; i++) {
        $("#img_" + i).attr("src", "img/tm.png");
        $("#price_" + i).html("");
        $("#foodname_" + i).html("");
    }
}
//菜单下标clear
function MenuListIndexClear() {
    menulistfocusIndex = 1;
    menulistIndex = 1;
    FocusMoveDistance(menulistIndex);
}

//菜单列表左右键操作，左右键切换时记录光标下标
var tmprightfocusIndex = 0;
var tmpleftfocusIndex = 0;

function RightLeftMenulist(tfalse) {
    if (tfalse == true) {//right:true left:false//右键----------->
        console.log("==右键==right=");
        tmprightfocusIndex = 0;
        if (menulistIndex < datasum) {
            menulistIndex++;
        } else {
            menulistIndex = 1;
            menulistfocusIndex = 0;
        }
        if (datasum <= 4 && datasum > 0) {//数据小于4
            FocusMoveDistance(menulistIndex);
        } else if (datasum > 4) {//数据大于4
            if (menulistfocusIndex < 4) {
                menulistfocusIndex++;
            } else {
                menulistfocusIndex = 1;
            }
            console.log("------------------->right");
            if (tmpleftfocusIndex < 4 && tmpleftfocusIndex != 0) {
                tmpleftfocusIndex++;
                menulistfocusIndex = tmpleftfocusIndex;
            }
            if (menulistIndex > 4) {
                if (tmpleftfocusIndex < 4 && tmpleftfocusIndex != 0) {
                    FocusMoveDistance(menulistfocusIndex);
                } else {
                    FocusMoveDistance(4);
                    menulistfocusIndex = 4;
                    RGthanfourShow();
                }
            } else {
                FocusMoveDistance(menulistfocusIndex);
                if (menulistIndex == 2 || menulistIndex == 3 || menulistIndex == 4) {
                    //menulistIndex!=2XXXXXXXXXXXXXXX
                } else {
                    MenuListClear();
                    MenuListShow(tmpobj);
                }
            }
            tmprightfocusIndex = menulistfocusIndex;
            console.log("临时右键=tmprightfocusIndex=" + tmprightfocusIndex);
        } else {
            //datasum=null
            document.getElementById("menulist").style.display = "none";
            document.getElementById("menulist_focus").style.display = "none";
        }
        $("#nownum").html(menulistIndex);
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    } else {//<---------左键
        console.log("===左键=left=");
        console.log("临时右键=tmprightfocusIndex=" + tmprightfocusIndex);
        tmpleftfocusIndex = 0;
        if (datasum <= 4 && datasum > 0) {
            if (menulistIndex <= 1) {
                menulistIndex = datasum;
            } else {
                menulistIndex--;
            }
            FocusMoveDistance(menulistIndex);
        } else if (datasum > 4) {
            if (menulistIndex <= 1) {
                menulistIndex = datasum;
                LeftReverseListShow();
            } else {
                menulistIndex--;
            }
            if (tmprightfocusIndex == 1 && menulistIndex == datasum) {
                tmprightfocusIndex = 5;
            }
            if (menulistfocusIndex <= 1) {
                menulistfocusIndex = 4;
            } else {
                menulistfocusIndex--;
            }
            if (tmprightfocusIndex >= 1) {
                tmprightfocusIndex--;
                menulistfocusIndex = tmprightfocusIndex;
            }//else{}
            //if (menulistIndex <= 5 && menulistIndex > 0) {//datasum
            if (menulistIndex <= (datasum - 4) && menulistIndex > 0) {
                if (tmprightfocusIndex >= 1) {
                    FocusMoveDistance(menulistfocusIndex);
                    tmpleftfocusIndex = menulistfocusIndex;
                } else {
                    FocusMoveDistance(1);
                    menulistfocusIndex = 5;
                    LeftlessthanShow();
                    tmpleftfocusIndex = 1;
                }
            } else {
                FocusMoveDistance(menulistfocusIndex);
                tmpleftfocusIndex = menulistfocusIndex;
            }
        } else {
            //datasum=null
            document.getElementById("menulist").style.display = "none";
            document.getElementById("menulist_focus").style.display = "none";
        }
        $("#nownum").html(menulistIndex);
    }
}
function FocusMoveDistance(Index) {
    switch (Index) {
        case 1:
            document.getElementById("menulist_focus").style.left = "112px";
            break;
        case 2:
            document.getElementById("menulist_focus").style.left = "388px";
            break;
        case 3:
            document.getElementById("menulist_focus").style.left = "663px";
            break;
        case 4:
        case 0:
            if (Index == 0) {
                menulistfocusIndex = 1;
            }
            document.getElementById("menulist_focus").style.left = "938px";
            break;
        default:
            break;
    }
}
//种类列表按键操作
function MenuTypeHandlekeyDown(iKey) {
    switch (iKey) {
        case IRKEY_LEFT:
            console.log("left=" + menutypefocusIndex);
            menutype_focus(false);
            break;
        case IRKEY_RIGHT:
            console.log("right=" + menutypefocusIndex);
            menutype_focus(true);
            break;
        case IRKEY_UP:
            break;
        case IRKEY_DOWN:
            if (datasum == null && datasum == undefined) {
                console.log("===food=nodata==");
            } else {
                menulistfocusIndex = 1;
                tmpleftfocusIndex = 0;
                tmprightfocusIndex = 0;
                current = menustatus.menulist;
                console.log("===menulist====");//menu_0
                document.getElementById("menulist_focus").style.display = "block";
                $("#nownum").html(1);
            }
            break;
        case IRKEY_SELECT:

            break;
        case IRKEY_EXIT:
            console.log("menutype=exit==homepage");
            totalcurrent = totalstatus.homepage;
            ExitOrderfoodClear();
            document.getElementById("foodmodule").style.display = "none";
            document.getElementById("main").style.display = "block";
            break;
        default:
            break;
    }
}

//菜单列表按键操作
function MenuListHandlekeyDown(iKey) {
    switch (iKey) {
        case IRKEY_LEFT:
            RightLeftMenulist(false);
            break;
        case IRKEY_RIGHT:
            RightLeftMenulist(true);
            break;
        case IRKEY_UP:
            current = menustatus.menutypelist;
            document.getElementById("menulist_focus").style.display = "none";
            break;
        case IRKEY_DOWN:
            break;
        case IRKEY_SELECT:
            document.getElementById("menudetail").style.display = "block";
            current = menustatus.menudetailshow;
            MenuDetailClear();
            MenuDetailShow();
            break;
        case IRKEY_EXIT:
            console.log("menulist=exit==homepage");
            totalcurrent = totalstatus.homepage;
            ExitOrderfoodClear();
            current = menustatus.menutypelist;
            document.getElementById("menulist_focus").style.display = "none";
            document.getElementById("foodmodule").style.display = "none";
            document.getElementById("main").style.display = "block";
            break;
        default:
            break;
    }
}
//退出订餐应用clear
function ExitOrderfoodClear() {
    menutypefocusIndex = 1;
    $("#menutype1").attr("src", "img/menu1.png");//菜品clear
    $("#menutype2").attr("src", "img/menu2_2.png");
    $("#menutype3").attr("src", "img/menu3_3.png");
    $("#menutype4").attr("src", "img/menu4_4.png");
    $("#menutype5").attr("src", "img/menu5_5.png");
    tmpmenuarray.splice(0, tmpmenuarray.length);
    tmpTotalnum = 0;
    totalfoodnum = 0;
    $("#cartTotalnum").html("(0)");
    CartMenulistClear();
}
//菜购物车
var tmpnum = 1;//临时菜总和
var tmpmenuarray = [];//用于存储放入购物车中的菜品
var tmppageindex = 1;//菜单列表页下标
var Totalpagenum = 0;//总页数
var tmppagemax = 4;
var totalfoodnum = 0;//总的菜量
var tmpTotalnum = 0;//总金额
var ifhavethisfood = true;//是否已添加此菜 true:yes false:no
function MenuDetailHandlekeyDown(iKey) {
    switch (iKey) {
        case IRKEY_LEFT:
            RLeftMenuDetailfocus(false);
            break;
        case IRKEY_RIGHT:
            RLeftMenuDetailfocus(true);
            break;
        case IRKEY_UP:
            tmpleftrightfocus = "";
            tmpleftrightfocus = "add";
            UpDownMenuDetailfocus(true);
            break;
        case IRKEY_DOWN:
            tmpleftrightfocus = "";
            tmpleftrightfocus = "add";
            UpDownMenuDetailfocus(false);
            break;
        case IRKEY_SELECT:
            tmppageindex = 1;
            tmpTotalnum = 0;
            if (updownfocusindex == 2) {//结算
                ///？？？？？？？tmppageindex=2;
                document.getElementById("cartmenulist").style.display = "block";
                current = menustatus.cartmenulistshow;
                console.log("tmpmenuarray.lengthlength===" + tmpmenuarray.length);
                if (tmpmenuarray.length > 0) {
                    $("#nowcartpage").html(1);
                } else {
                    $("#nowcartpage").html(0);
                }
                Totalpagenum = Math.ceil(tmpmenuarray.length / tmppagemax);
                $("#Totalcartpage").html(Totalpagenum);
                console.log("zongye=page=Total=" + Totalpagenum);
                var tmplistshowlength = 0;//购物车列表显示长度
                if (tmpmenuarray.length > 4) {
                    tmplistshowlength = 4;
                } else {
                    tmplistshowlength = tmpmenuarray.length;
                }
                for (var i = 0; i < tmplistshowlength; i++) {
                    $("#cart_img" + i).attr("src", tmpmenuarray[i].cookbook_thumbnail_address);
                    $("#cart_name" + i).html(tmpmenuarray[i].cookbook_name);
                    document.getElementById("cart_numdiv" + i).style.display = "block";
                    document.getElementById("cart_numpush" + i).style.backgroundColor = "rgb(249, 157, 16)";
                    document.getElementById("opt_delbtn" + i).style.display = "block";
                    $("#cart_num" + i).html(tmpmenuarray[i].foodnum);
                    $("#cart_price" + i).html("￥" + tmpmenuarray[i].cookbook_price);
                    tmpTotalnum += (tmpmenuarray[i].cookbook_price) * (tmpmenuarray[i].foodnum);
                    console.log("tmpTotalnum=cookbook_price=tmpmenuarray=" + tmpmenuarray[i].cookbook_price + "=" + tmpmenuarray[i].foodnum + "=" + tmpTotalnum);
                }
                console.log("0415====----===start=" + JSON.stringify(tmpmenuarray[0]));
                $("#cartTotalprice").html("￥" + tmpTotalnum);
                console.log("tmpTotalnum===" + tmpTotalnum);
            } else if (updownfocusindex == 0) {//左右
                if (tmpleftrightfocus == "add") {
                    tmpnum++;
                    console.log("add===" + tmpnum);
                    document.getElementById("num").innerHTML = tmpnum;
                } else {
                    if (tmpnum <= 1) {
                    } else {
                        tmpnum--;
                    }
                    console.log("sub===" + tmpnum);
                    document.getElementById("num").innerHTML = tmpnum;
                }
            } else {//加入
                var nowpushfood = tmpobj.cookbook_details[menulistIndex - 1];
                var tmparray = [];
                tmparray.push(JSON.parse(nowpushfood));
                $(tmparray).attr("foodnum", document.getElementById("num").innerHTML);
                if (tmpmenuarray.length == 0) {
                    tmpmenuarray.push(tmparray[0]);
                } else {
                    for (var i = 0; i < tmpmenuarray.length; i++) {
                        console.log("now foodid=" + tmpmenuarray[i].cookbook_id);
                        if (tmparray[0].cookbook_id == tmpmenuarray[i].cookbook_id) {
                            console.log("====have this food====");
                            ifhavethisfood = true;
                            break;
                        } else {
                            console.log("====haven't this food====");
                            ifhavethisfood = false;
                        }
                    }
                    if (ifhavethisfood == false) {
                        tmpmenuarray.push(tmparray[0]);
                    } else {
                        for (var i = 0; i < tmpmenuarray.length; i++) {
                            if (tmpmenuarray[i].cookbook_id == tmparray[0].cookbook_id) {
                                var tmpvalue1 = JSON.parse(tmparray[0].foodnum);
                                var tmpvalue2 = JSON.parse(tmpmenuarray[i].foodnum);
                                tmpvalue2 += tmpvalue1;
                                tmpmenuarray[i].foodnum = tmpvalue2;
                            }
                        }
                    }

                }
                console.log("tmparray=" + JSON.stringify(tmparray));
                totalfoodnum += parseInt(tmparray[0].foodnum);
                console.log("加入菜总的共有=" + totalfoodnum);
                console.log("tmpmenuarray=" + JSON.stringify(tmpmenuarray));
                document.getElementById("cartTotalnum").innerHTML = "(" + totalfoodnum + ")";
            }
            break;
        case IRKEY_EXIT://返回键
            document.getElementById("menudetail").style.display = "none";
            current = menustatus.menulist;
            tmppageindex = 1;
            //tmpTotalnum = 0;
            break;
        default:
            break;
    }
}
//购物车菜单列表
var cartmenuleftrightindex = 0;//左右光标index
var cartmenuupdownlineindex = 0;//上下行光标index
function CartMenulistHandlekeyDown(iKey) {
    switch (iKey) {
        case IRKEY_EXIT://返回键
            document.getElementById("cartmenulist").style.display = "none";
            document.getElementById("menudetail").style.display = "none";
            CartmenuLeftRightfocusClear();
            CartmenuUpDownLineClearfocus();
            current = menustatus.menulist;
            break;
        case IRKEY_PAGE_UP:
        case IRKEY_CHANNEL_UP:
            // case IRKEY_UP:
            console.log("up-page");
            CartmenuLeftRightfocusClear();
            CartmenuUpDownLineClearfocus();
            if (tmpmenuarray.length <= 4) {
                //nothing
            } else {
                CartMenulistClear();
                CartMenulistPagefocus(true);
            }
            break;
        case IRKEY_CHANNEL_DOWN:
        case IRKEY_PAGE_DOWN:
            //case IRKEY_DOWN:
            CartmenuLeftRightfocusClear();
            CartmenuUpDownLineClearfocus();
            console.log("down-page");
            if (tmpmenuarray.length <= 4) {
                //nothing
            } else {
                CartMenulistClear();
                CartMenulistPagefocus(false);
            }
            break;
        case IRKEY_UP:
            CartmenuLeftRightfocusClear();
            var tmplistshowlength = 0;//购物车列表显示长度
            if (tmpmenuarray.length - (tmppageindex - 1) * 4 > 4) {
                tmplistshowlength = 4;
            } else {
                tmplistshowlength = tmpmenuarray.length - (tmppageindex - 1) * 4;
            }
            if (cartmenuupdownlineindex <= 0) {
                cartmenuupdownlineindex = tmplistshowlength-1;
            } else {
                cartmenuupdownlineindex--;
            }
            CartmenuUpDownLineSetstyle(cartmenuupdownlineindex);

            break;
        case IRKEY_DOWN:
            CartmenuLeftRightfocusClear();
            var tmplistshowlength = 0;//购物车列表显示长度
            if (tmpmenuarray.length - (tmppageindex - 1) * 4 > 4) {
                tmplistshowlength = 4;
            } else {
                tmplistshowlength = tmpmenuarray.length - (tmppageindex - 1) * 4;
            }
            if (cartmenuupdownlineindex >=tmplistshowlength-1) {
                cartmenuupdownlineindex = 0;
            } else {
                cartmenuupdownlineindex++;
            }
            CartmenuUpDownLineSetstyle(cartmenuupdownlineindex);
            break;
        case IRKEY_LEFT:
            if (cartmenuleftrightindex <= 0) {
                cartmenuleftrightindex = 2;
            } else {
                cartmenuleftrightindex--;
            }
            console.log("0415====-left---====" + cartmenuupdownlineindex);
            CartmenuLeftRightSetstyle(cartmenuleftrightindex, cartmenuupdownlineindex);
            break;
        case IRKEY_RIGHT:
            if (cartmenuleftrightindex >= 2) {
                cartmenuleftrightindex = 0;
            } else {
                cartmenuleftrightindex++;
            }
            console.log("0415====-right---====" + cartmenuupdownlineindex);
            CartmenuLeftRightSetstyle(cartmenuleftrightindex, cartmenuupdownlineindex);
            break;
        case IRKEY_SELECT:
            console.log("====cart menu list=====");
            CartmenuKEYselectOpt(cartmenuleftrightindex, cartmenuupdownlineindex);

            break;
        default:
            break;
    }
}
////cart menu select
function CartmenuKEYselectOpt(type, index) {
    var tmpfoodnum;
    switch (type) {//index 0:push 1:minus 2:del
        case 0:
            console.log("keyopt----select--push---=");
            if (tmppageindex > 1) {
                tmpfoodnum = JSON.parse(tmpmenuarray[index + (tmppageindex - 1) * 4].foodnum);
                tmpfoodnum++;
                tmpmenuarray[index + (tmppageindex - 1) * 4].foodnum = tmpfoodnum;
                $("#cart_num" + index).html(tmpmenuarray[index + (tmppageindex - 1) * 4].foodnum);
            } else if (tmppageindex <= 1) {
                tmpfoodnum = JSON.parse(tmpmenuarray[index].foodnum);
                tmpfoodnum++;
                tmpmenuarray[index].foodnum = tmpfoodnum;
                $("#cart_num" + index).html(tmpmenuarray[index].foodnum);
            }
            break;
        case 1:
            console.log("keyopt----select--minus----=");
            if (tmppageindex > 1) {
                tmpfoodnum = JSON.parse(tmpmenuarray[index + (tmppageindex - 1) * 4].foodnum);
                if (tmpfoodnum <= 1) {
                    tmpfoodnum = 1;
                } else {
                    tmpfoodnum--;
                }
                tmpmenuarray[index + (tmppageindex - 1) * 4].foodnum = tmpfoodnum;
                $("#cart_num" + index).html(tmpmenuarray[index + (tmppageindex - 1) * 4].foodnum);
            } else if (tmppageindex <= 1) {
                tmpfoodnum = JSON.parse(tmpmenuarray[index].foodnum);
                if (tmpfoodnum <= 1) {
                    tmpfoodnum = 1;
                } else {
                    tmpfoodnum--;
                }
                tmpmenuarray[index].foodnum = tmpfoodnum;
                $("#cart_num" + index).html(tmpmenuarray[index].foodnum);
            }
            break;
        case 2:
            console.log("keyopt----select--del----=");
            if (tmppageindex > 1) {
                tmpmenuarray.remove(cartmenuupdownlineindex + (tmppageindex - 1) * 4);
            } else if (tmppageindex <= 1) {
                tmpmenuarray.remove(cartmenuupdownlineindex);
            }
            CartMenulistClear();
            CartmenuLeftRightfocusClear();
            CartmenuUpDownLineClearfocus();
            if (tmppageindex > 1) {
                console.log(" > 1当前是第" + tmppageindex + "页，数据有" + (tmpmenuarray.length - (tmppageindex - 1) * 4) + "条");
                if (tmpmenuarray.length - (tmppageindex - 1) * 4 == 0) {
                    tmppageindex = 1;
                    Totalpagenum-=1;
                }
                $("#nowcartpage").html(tmppageindex);
                $("#Totalcartpage").html(Totalpagenum);
                CartMenulistupdownShow();
            } else {
                console.log("当前是第" + tmppageindex + "页，数据有" + tmpmenuarray.length + "条");
                CartMenulistupdownShow();
            }
            break;
        default:
            break;
    }
}
/** 
 *删除数组指定下标或指定对象 
 */
Array.prototype.remove = function (obj) {
    for (var i = 0; i < this.length; i++) {
        var temp = this[i];
        if (!isNaN(obj)) {
            temp = i;
        }
        if (temp == obj) {
            for (var j = i; j < this.length; j++) {
                this[j] = this[j + 1];
            }
            this.length = this.length - 1;
        }
    }
}
//cart menu left right style
function CartmenuLeftRightSetstyle(index, i) {
    switch (index) {
        case 0://push
            document.getElementById('cart_numminus' + i).style.backgroundColor = "rgb(207, 195, 195)";
            document.getElementById('opt_delbtn' + i).style.backgroundColor = "rgb(207, 195, 195)";
            document.getElementById('cart_numpush' + i).style.backgroundColor = "rgb(249, 157, 16)";//焦点色
            break;
        case 1://minus
            document.getElementById('opt_delbtn' + i).style.backgroundColor = "rgb(207, 195, 195)";
            document.getElementById('cart_numpush' + i).style.backgroundColor = "rgb(207, 195, 195)";
            document.getElementById('cart_numminus' + i).style.backgroundColor = "rgb(249, 157, 16)";
            break;
        case 2://del
            document.getElementById('cart_numpush' + i).style.backgroundColor = "rgb(207, 195, 195)";
            document.getElementById('cart_numminus' + i).style.backgroundColor = "rgb(207, 195, 195)";
            document.getElementById('opt_delbtn' + i).style.backgroundColor = "rgb(249, 157, 16)";
            break;
        default:
            break;
    }
}
//clear focus
function  CartmenuLeftRightfocusClear() {
    cartmenuleftrightindex = 0;
    for (var i = 0; i < 4; i++) {
        document.getElementById('opt_delbtn' + i).style.backgroundColor = "rgb(207, 195, 195)";
        document.getElementById('cart_numpush' + i).style.backgroundColor = "rgb(249, 157, 16)";
        document.getElementById('cart_numminus' + i).style.backgroundColor = "rgb(207, 195, 195)";
    }
}
//cart menu up down line style
function CartmenuUpDownLineSetstyle(index) {
    switch (index) {
        case 0:// line:0  
            document.getElementById('cartlisttr1').style.backgroundColor = "";
            document.getElementById('cartlisttr2').style.backgroundColor = "";
            document.getElementById('cartlisttr3').style.backgroundColor = "";
            document.getElementById('cartlisttr0').style.backgroundColor = "rgb(19, 30, 232)";//焦点色
            break;
        case 1://line:1
            document.getElementById('cartlisttr0').style.backgroundColor = "";
            document.getElementById('cartlisttr2').style.backgroundColor = "";
            document.getElementById('cartlisttr3').style.backgroundColor = "";
            document.getElementById('cartlisttr1').style.backgroundColor = "rgb(19, 30, 232)";
            break;
        case 2://line:2
            document.getElementById('cartlisttr0').style.backgroundColor = "";
            document.getElementById('cartlisttr1').style.backgroundColor = "";
            document.getElementById('cartlisttr3').style.backgroundColor = "";
            document.getElementById('cartlisttr2').style.backgroundColor = "rgb(19, 30, 232)";
            break;
        case 3://line:3
            document.getElementById('cartlisttr0').style.backgroundColor = "";
            document.getElementById('cartlisttr1').style.backgroundColor = "";
            document.getElementById('cartlisttr2').style.backgroundColor = "";
            document.getElementById('cartlisttr3').style.backgroundColor = "rgb(19, 30, 232)";
            break;

        default:
            break;
    }
}
//clear focus
function CartmenuUpDownLineClearfocus() {
    cartmenuupdownlineindex = 0;
    document.getElementById('cartlisttr0').style.backgroundColor = "rgb(19, 30, 232)";
    document.getElementById('cartlisttr1').style.backgroundColor = "";
    document.getElementById('cartlisttr2').style.backgroundColor = "";
    document.getElementById('cartlisttr3').style.backgroundColor = "";
}
function CartMenulistClear() {
    for (var i = 0; i < 4; i++) {
        $("#cart_img" + i).attr("src", "img/tm.png");
        $("#cart_name" + i).html("");
        $("#cart_num" + i).html("");
        $("#cart_price" + i).html("");
    }
}
//购物车菜单清单列表show
var CartMenulistupdownShow = function () {
    CartMenulistbtnClear();
    CartMenulistClear();
    var tmplistshowlength = 0;//购物车列表显示长度
    if (tmpmenuarray.length - (tmppageindex - 1) * 4 > 4) {
        tmplistshowlength = 4;
    } else {
        tmplistshowlength = tmpmenuarray.length - (tmppageindex - 1) * 4;
    }
    for (var i = 0; i < tmplistshowlength; i++) {
        $("#cart_img" + i).attr("src", tmpmenuarray[i + (tmppageindex - 1) * 4].cookbook_thumbnail_address);
        $("#cart_name" + i).html(tmpmenuarray[i + (tmppageindex - 1) * 4].cookbook_name);
        $("#cart_num" + i).html(tmpmenuarray[i + (tmppageindex - 1) * 4].foodnum);
        $("#cart_price" + i).html("￥" + tmpmenuarray[i + (tmppageindex - 1) * 4].cookbook_price);
        document.getElementById("cart_numdiv" + i).style.display = "block";
        document.getElementById("cart_numpush" + i).style.backgroundColor = "rgb(249, 157, 16)";
        document.getElementById("opt_delbtn" + i).style.display = "block";
        console.log("第" + tmppageindex + "页==" + tmpmenuarray[i + (tmppageindex - 1) * 4].cookbook_name);
    }
}

//清单中图标clear
function CartMenulistbtnClear() {
    for (var i = 0; i < 4; i++) {
        document.getElementById("cart_numdiv" + i).style.display = "none";
        document.getElementById("opt_delbtn" + i).style.display = "none";
    }
}
//购物车菜单清单列表focus
function CartMenulistPagefocus(FTrue) {//true:UP false:Down
    if (FTrue == true) {
        if (tmpmenuarray.length <= 4) {
            tmppageindex = 1;
        } else {
            if (tmppageindex <= 1) {
                tmppageindex = Totalpagenum;
            } else {
                tmppageindex--;
            }
            CartMenulistupdownShow();
        }
        $("#nowcartpage").html(tmppageindex);
    } else {
        if (tmpmenuarray.length <= 4) {
            tmppageindex = 1;
        } else {
            if (tmppageindex >= Totalpagenum) {
                tmppageindex = 1;
            } else {
                tmppageindex++;
            }
            CartMenulistupdownShow();
        }
        $("#nowcartpage").html(tmppageindex);
    }
}
//菜购物车左右光标
var tmpleftrightfocus = "add";//“+”“-”切换
function RLeftMenuDetailfocus(FTrue) {//right:true left:false
    if (FTrue == true) {
        document.getElementById("sub").style.background = "url(img/tm.png) 0% 50% no-repeat";
        document.getElementById("add").style.background = "url(img/button1.png) 97% 45% no-repeat";
        tmpleftrightfocus = "";
        tmpleftrightfocus = "add";
    } else {
        document.getElementById("sub").style.background = "url(img/button1.png) 0% 50% no-repeat";
        document.getElementById("add").style.background = "url(img/tm.png) 97% 45% no-repeat";
        tmpleftrightfocus = "";
        tmpleftrightfocus = "sub";
    }
}
//菜单详情光标clear
function MenuDetailfocusClear() {
    document.getElementById("sub").style.background = "url(img/tm.png) 0% 50% no-repeat";
    document.getElementById("add").style.background = "url(img/button1.png) 97% 45% no-repeat";
    document.getElementById("cart").style.background = "url(img/cart0.png) 50% 50% no-repeat";
    document.getElementById("order").style.background = "url(img/button0.png) 50% 50% no-repeat";
}
//菜购物车上下光标
var updownfocusindex = 0;
function UpDownMenuDetailfocus(UpDown) {//up:true Down:false
    if (UpDown == true) {
        if (updownfocusindex <= 0) {
            updownfocusindex = 2;
        } else {
            updownfocusindex--;
        }
        console.log("updownfocusindex=up=" + updownfocusindex);
        updownfocus(updownfocusindex);
    } else {
        if (updownfocusindex >= 2) {
            updownfocusindex = 0;
        } else {
            updownfocusindex++;
        }
        console.log("updownfocusindex=down=" + updownfocusindex);
        updownfocus(updownfocusindex);
    }
}
var updownfocus = function (index) {
    switch (index) {
        case 0://左右
            document.getElementById("order").style.background = "url(img/button0.png) 50% 50% no-repeat";
            document.getElementById("cart").style.background = "url(img/cart0.png) 50% 50% no-repeat";
            document.getElementById("add").style.background = "url(img/button1.png) 97% 45% no-repeat";
            break;
        case 1://加入购物车
            document.getElementById("add").style.background = "url(img/tm.png) 97% 45% no-repeat";
            document.getElementById("sub").style.background = "url(img/tm.png) 0% 50% no-repeat";
            document.getElementById("order").style.background = "url(img/button0.png) 50% 50% no-repeat";
            document.getElementById("cart").style.background = "url(img/button1.png) 50% 50% no-repeat";
            break;
        case 2://结算
            document.getElementById("add").style.background = "url(img/tm.png) 97% 45% no-repeat";
            document.getElementById("sub").style.background = "url(img/tm.png) 0% 50% no-repeat";
            document.getElementById("cart").style.background = "url(img/cart0.png) 50% 50% no-repeat";
            document.getElementById("order").style.background = "url(img/button1.png) 50% 50% no-repeat";
            break;
        default:
            break;
    }
}
//菜购物车显示
function MenuDetailShow() {
    $("#detail_img").attr("src", JSON.parse(tmpobj.cookbook_details[menulistIndex - 1]).cookbook_thumbnail_address);
    $("#detail_price").html("￥" + JSON.parse(tmpobj.cookbook_details[menulistIndex - 1]).cookbook_price);
    $("#detail_name").html(JSON.parse(tmpobj.cookbook_details[menulistIndex - 1]).cookbook_name);
}
//菜购物车clear
function MenuDetailClear() {
    $("#detail_img").attr("src", "");
    $("#detail_price").html();
    $("#detail_name").html();
    updownfocusindex = 0;
    tmpnum = 1;
    $("#num").html(1);
    MenuDetailfocusClear();
}
//种类列表光标
function menutype_focus(tfalse) {
    if (tfalse == true) {//left:false right:ture
        if (menutypefocusIndex < 5) {
            menutypefocusIndex++;
        } else {
            console.log("menutypefocusIndex!<5=" + menutypefocusIndex);
            $("#menutype" + menutypefocusIndex).attr("src", "img/menu" + menutypefocusIndex + "_" + menutypefocusIndex + ".png");
            menutypefocusIndex = 1;
        }
        if (menutypefocusIndex > 1) {
            $("#menutype" + (menutypefocusIndex - 1)).attr("src", "img/menu" + (menutypefocusIndex - 1) + "_" + (menutypefocusIndex - 1) + ".png");
        }
        console.log("0204=right=menutype=" + "url(img/menu" + menutypefocusIndex + ".png) no-repeat center;");
        $("#menutype" + menutypefocusIndex).attr("src", "img/menu" + menutypefocusIndex + ".png");
    } else {
        if (menutypefocusIndex <= 1) {
            $("#menutype" + menutypefocusIndex).attr("src", "img/menu" + menutypefocusIndex + "_" + menutypefocusIndex + ".png");
            menutypefocusIndex = 5;
        } else {
            menutypefocusIndex--;
        }
        if (menutypefocusIndex < 5) {
            $("#menutype" + (menutypefocusIndex + 1)).attr("src", "img/menu" + (menutypefocusIndex + 1) + "_" + (menutypefocusIndex + 1) + ".png");
        }
        console.log("0204=left=menutype=" + "url(img/menu" + menutypefocusIndex + ".png) no-repeat center;");
        $("#menutype" + menutypefocusIndex).attr("src", "img/menu" + menutypefocusIndex + ".png");
    }
    MenuTypeChooseData(menutypefocusIndex);
}
//获取不同菜品的菜单数据
function MenuTypeChooseData(type) {
    console.log("choose=============================");
    switch (type) {
        case 1:
            MenuListClear();
            MenuListIndexClear();
            if (orderstorage.chinesefoodstorage == null) {
                console.log("====food==storage==null============");
                HtpData.get("../hotel_api/cookbook_detail.php?cookbook_category_id=1", 5000, function (data) {
                    console.log("http get success--------!");
                    tmpobj = JSON.parse(data);
                    orderstorage.setItem("chinesefoodstorage", JSON.stringify(tmpobj));
                    datasum = tmpobj.cookbook_details.length;
                    MenuListShow(tmpobj);
                }, function (data) {
                    console.log("http get fail--------!");
                });
            } else {
                console.log("====food==storage!=null============");
                tmpobj = JSON.parse(orderstorage.getItem("chinesefoodstorage"));
                datasum = tmpobj.cookbook_details.length;
                MenuListShow(tmpobj);
            }
            break;
        case 2:
            MenuListClear();
            MenuListIndexClear();
            if (orderstorage.westernstylestorage == null) {
                console.log("====food==storage==null============");
                HtpData.get("../hotel_api/cookbook_detail.php?cookbook_category_id=2", 5000, function (data) {
                    console.log("http get success--------!");
                    tmpobj = JSON.parse(data);
                    orderstorage.setItem("westernstylestorage", JSON.stringify(tmpobj));
                    datasum = tmpobj.cookbook_details.length;
                    MenuListShow(tmpobj);
                }, function (data) {
                    console.log("http get fail--------!");
                });
            } else {
                console.log("====food==storage!=null============");
                tmpobj = JSON.parse(orderstorage.getItem("westernstylestorage"));
                datasum = tmpobj.cookbook_details.length;
                MenuListShow(tmpobj);
            }
            break;
        case 3:
            MenuListClear();
            MenuListIndexClear();
            if (orderstorage.specialfoodstorage == null) {
                console.log("====food==storage==null============");
                HtpData.get("../hotel_api/cookbook_detail.php?cookbook_category_id=3", 5000, function (data) {
                    console.log("http get success--------!");
                    tmpobj = JSON.parse(data);
                    orderstorage.setItem("specialfoodstorage", JSON.stringify(tmpobj));
                    datasum = tmpobj.cookbook_details.length;
                    console.log("nowshow==3=menulistIndex=" + menulistIndex);
                    MenuListShow(tmpobj);
                }, function (data) {
                    console.log("http get fail--------!");
                });
            } else {
                console.log("====food==storage!=null============");
                tmpobj = JSON.parse(orderstorage.getItem("specialfoodstorage"));
                datasum = tmpobj.cookbook_details.length;
                MenuListShow(tmpobj);
            }
            break;
        case 4:
            MenuListClear();
            MenuListIndexClear();
            if (orderstorage.fruitstorage == null) {
                console.log("====food==storage==null============");
                HtpData.get("../hotel_api/cookbook_detail.php?cookbook_category_id=4", 5000, function (data) {
                    console.log("http get success--------!");
                    tmpobj = JSON.parse(data);
                    orderstorage.setItem("fruitstorage", JSON.stringify(tmpobj));
                    datasum = tmpobj.cookbook_details.length;
                    MenuListShow(tmpobj);
                }, function (data) {
                    console.log("http get fail--------!");
                });
            } else {
                console.log("====food==storage!=null============");
                tmpobj = JSON.parse(orderstorage.getItem("fruitstorage"));
                datasum = tmpobj.cookbook_details.length;
                MenuListShow(tmpobj);
            }
            break;
        case 5:
            MenuListClear();
            MenuListIndexClear();
            if (orderstorage.dessertfoodstorage == null) {
                console.log("====food==storage==null============");
                HtpData.get("../hotel_api/cookbook_detail.php?cookbook_category_id=5", 5000, function (data) {
                    console.log("http get success--------!");
                    tmpobj = JSON.parse(data);
                    orderstorage.setItem("dessertfoodstorage", JSON.stringify(tmpobj));
                    datasum = tmpobj.cookbook_details.length;
                    MenuListShow(tmpobj);
                }, function (data) {
                    console.log("http get fail--------!");
                });
            } else {
                console.log("====food==storage!=null============");
                tmpobj = JSON.parse(orderstorage.getItem("dessertfoodstorage"));
                datasum = tmpobj.cookbook_details.length;
                MenuListShow(tmpobj);
            }
            break;
        default:
            break;
    }
}
var HtpData = {
    ajaxobj: null,
    url: "",
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
        this.ajaxobj = $.ajax({
            url: HtpData.url,
            timeout: HtpData.timeout,
            type: "get",
            success: function (response, textStatus) {
                if (textStatus == 'success') {
                    console.log("ajax success~!!");
                    HtpData.successCallback(response);
                }
            },
            error: function (response, textStatus) {
                if (textStatus == 'error') {
                    console.log("ajax error~!!");
                    HtpData.failCallback(response);
                }
            },
            complete: function (response, textStatus) {
                if (textStatus == 'timeout') {
                    console.log("ajax timeout~!!");
                    HtpData.failCallback({msg: textStatus});
                    HtpData.ajaxobj.abort();
                }
            }

        });
    }
}
function OrderfoodHandleKeyDown(keys) {
    /// var iKey = keys.keyCode || event.keyCode;
    switch (current) {
        case menustatus.menutypelist:
            MenuTypeHandlekeyDown(keys);
            break;
        case menustatus.menulist:
            MenuListHandlekeyDown(keys);
            break;
        case menustatus.menudetailshow:
            MenuDetailHandlekeyDown(keys);
            break;
        case menustatus.cartmenulistshow:
            CartMenulistHandlekeyDown(keys);
            break;
        default:
            break;
    }
}

