
//登陆
function loginNO_Click(){
    console.log("============no=============");
    document.getElementById("loginusername").value="";
    document.getElementById("loginpassword").value="";
}


        
//客户添加
function cusAdd_click(){
    console.log("============cus========add====");
    document.getElementById("cusaddinputbox").style.display="block";
  
}
//录入取消
function inputdel_click(){
    console.log("=========input======del============");
    document.getElementById("cusinputname").value="";
    document.getElementById("cusinputroomnum").value="";
    document.getElementById("cusaddinputbox").style.display="none";
}
//退出
function msgExit_click(){
    console.log("=====exit====="); 
    document.getElementById("exitpromptdiv").style.display="block";  
//    document.cookie="Hotelcusinputindex="+'no';
//    window.location.href="./index.php";
}
//exitok no 退出系统提示框
function exitOK_click(){
    document.getElementById("exitpromptdiv").style.display="none";
    document.cookie="Hotelcusinputindex="+'no';
    //document.cookie="Hotelcusinputindexh="+'yes';
    window.location.href="./index.php";
    location.reload();
}
function exitNO_click(){
    document.getElementById("exitpromptdiv").style.display="none";
}
//点击
function del_click(){
}
//刷新
function reload(){
    window.location.reload();
}
function findcusmsg_click(){
    console.log("============find======");
    var tmpinputtext=document.getElementById("finputtext").value;
    if(tmpinputtext==""||tmpinputtext==null){
        document.getElementById("cusprompttext").innerHTML = "查找信息不能为空！";
        document.getElementById("cuspromptdiv").style.display = "block";
        //if(tmpinputtext){}
        return false;
    }else{
        return true;
    }
}


/*//入口
function init(){
    console.log("------init----------------");
}
window.addEventListener("load",init,false);*/
function inputsave_click(){
    var tmproomnum=document.getElementById("cusinputroomnum").value;
    var tmpname=document.getElementById("cusinputname").value;
    var tmpcussex=document.getElementsByName("cusSex");
    if (tmproomnum == '' || tmproomnum == null) {
        document.getElementById("cusprompttext").innerHTML = "房间号不能为空！";
        document.getElementById("cuspromptdiv").style.display = "block";
        return false;
    } else {
        
        if (tmpname == '' || tmpname == null) {
            document.getElementById("cusprompttext").innerHTML = "客户名不能为空！";
            document.getElementById("cuspromptdiv").style.display = "block";
            return false;
        } else { 
            
            return true;
        }
    }
}
function pro_click(){
    document.getElementById("cuspromptdiv").style.display="none";
}

//查找信息框退出
function findExit_click(){
    document.getElementById("findinfobox").style.display="none";
}
/*修改控制*/
function cusUpdate_click(){
   var tmpupdrmnum=document.getElementById("cusmsgNum_1").value;
   var tmpupdname=document.getElementById("cusmsgName_1").value;
   var tmpupdsex=document.getElementById("cusmsgSex_1").value;
   console.log("upd=====before=============");
   if (tmpupdrmnum == "" || tmpupdrmnum == null) {
        document.getElementById("cusprompttext").innerHTML = "修改时房间号不能为空！";
        document.getElementById("cuspromptdiv").style.display = "block";
        return false;
    } else {
        
        if (tmpupdname == "" || tmpupdname == null) {
            document.getElementById("cusprompttext").innerHTML = "修改时客户名不能为空！";
            document.getElementById("cuspromptdiv").style.display = "block";
            return false;
        } else { 
            if (tmpupdsex == "" || tmpupdsex == null) {
                document.getElementById("cusprompttext").innerHTML = "修改时客户性别不能为空！";
                document.getElementById("cuspromptdiv").style.display = "block";
                return false;
            } else {
              
                return true;
            }
        }
    }
}  

//修改控制
function listupdate_click(){
    var tmpupdrmnum=document.getElementById("listrmNum").value;
   var tmpupdname=document.getElementById("listrmName").value;
   var tmpupdsex=document.getElementById("listrmSex").value;
    if (tmpupdrmnum == "" || tmpupdrmnum == null) {
        document.getElementById("cusprompttext").innerHTML = "修改时房间号不能为空！";
        document.getElementById("cuspromptdiv").style.display = "block";
        return false;
    } else {
        
        if (tmpupdname == "" || tmpupdname == null) {
            document.getElementById("cusprompttext").innerHTML = "修改时客户名不能为空！";
            document.getElementById("cuspromptdiv").style.display = "block";
            return false;
        } else { 
            if (tmpupdsex == "" || tmpupdsex == null) {
                document.getElementById("cusprompttext").innerHTML = "修改时客户性别不能为空！";
                document.getElementById("cuspromptdiv").style.display = "block";
                return false;
            } else {
              
                return true;
            }
        }
    }
}

function listupdateExit_click(){
    window.location.href="./firstindex.php";
}


//error exit

//var refresh = function() {
//$.ajax({
//  type:'post',
//  url:'http://192.168.172.122/customerinput/',
//  timeout:10000,
//  data:{time:"1"},
//  dataType:'html',
//  success:function(data){
//  if(data.state==200){
//  console.log("nihao");
//  }else{
//      console.log("=====1");
//  
//  }
//  },
//  error:function(){
//  console.log("属性值删除失败!");
//  document.cookie="Hotelcusinputindex="+'no';
//  }
//   });
//
//          }
//  setInterval(refresh, 1000);
//function errorexit(){
//    document.cookie="Hotelcusinputindex="+'no';
//}