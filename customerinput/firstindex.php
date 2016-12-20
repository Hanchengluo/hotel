
<!--<!DOCTYPE html>-->
<html>
    <head>
        <title>first page</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="js/main.js" charset="utf-8"></script>

    </head>
    <body>

        <?php
        if (empty($_COOKIE['Hotelcusinputindex'])) {
            setcookie("Hotelcusinputindex", "no");
        }
        if ($_COOKIE["Hotelcusinputindex"] === "yes") {
            
        } else if ($_COOKIE["Hotelcusinputindex"] === "no") {
            header('Location:./index.php');
        }
        ?>
        <div id="header" style="display: block;">
            <div id="titlemsg"><span>微桥酒店管理系统</span><span>-</span><span>客户信息</span><input type="button" id="msgexitbutton" onclick="msgExit_click();"/></div>
            <div id="content" >
                <div id="content-top">
                    <form onsubmit="return findcusmsg_click()" action="" method="post">
                        <table>
                            <tr>
                                <td><input type="text" id="finputtext" name="Findputtext" value="" autocomplete="off" onkeyup="value = value.replace(/[^\u4E00-\u9FA5\0-9\A-Za-z ]/g, '')" placeholder="请输入房间号或姓名"></td>
                                <td><input type="submit" id="customermsgfind" name="customermsgfind" class="cusbutton" value="查&nbsp;&nbsp;找"/></td><!--onclick="findcusmsg_click()"-->
                                <td><input type="button" id="customermsgadd" class="cusbutton" value="添&nbsp;&nbsp;加" onclick="cusAdd_click()"/></td>
                            </tr>        
                        </table>

                    </form>

                </div>
                <!--content-center start-->
                <div id="content-center">
                    <table border="1"cellpadding="0"cellspacing="0" style="font-size: 25px; height: 60px;font-weight:bold;position: fixed;text-align: center;background-color:#96B2F3;">
                        <tr >
                            <td style="
                                width: 101px;
                                ">房间号</td>
                            <td style="
                                width: 289px;
                                ">客户名</td>
                            <td style="
                                width: 62px;
                                ">性别</td>
                            <td style="
                                width: 538px;
                                ">入住时间</td>
                            <td style="
                                width: 263px;
                                ">操作</td>
                        </tr>
                    </table>
                    <table border="1"cellpadding="0"cellspacing="0"  style="  text-align: center;width:100%;height: 60px; margin-top: 60px; ">

                        <?php include ('connect.php'); ?>
                        <?php
                        $exec = "SELECT * FROM tbl_hotel_customer_info order by cus_roomnum";
                        $result = mysql_query($exec);
                        //$tmpnum=  mysql_num_rows($result);
                        $tmprow = 0;
                        while ($rs = mysql_fetch_object($result)) {
                            $rowid = $rs->id;
                            $cusmsgNum_0 = $rs->cus_roomnum;
                            $cusmsgName_0 = $rs->cus_name;
                            $cusmsgSex_0 = $rs->cus_sex;
                            $cusmsgtime_0 = $rs->create_time;
                            ?>                            
                            <tr style="background: #fff; font-size: 20px;">
                                <td width="103" id="cusmsgNum_0" ><?php echo $cusmsgNum_0 ?></td>
                                <td width="292" id="cusmsgName_0" ><?php echo $cusmsgName_0 ?></td>
                                <td width="63" id="cusmsgSex_0" ><?php
                                    if ($cusmsgSex_0 == 0)
                                        echo '男';
                                    if ($cusmsgSex_0 == 1)
                                        echo '女';
                                    ?></td>
                                <td width="548" id="cusmsgtime_0" ><?php echo $cusmsgtime_0 ?></td>
                                <td width="263" >
                                    <form style="float: left" action="./cusdel.php?delId=<?php echo $rowid ?>" method="post">
                                        <input type="submit"  class="cusmsgdel" value="" style="margin:2px 2px 0 40px;margin-top:15px!important ;"/><!--style="position: absolute;left:930px;"-background-color: yellow;-->
                                    </form>
                                    <form style="" action="?updId=<?php echo $rowid ?>" method="post">
                                        <input type="submit"  name="cuslistupdbtn" style="border:0px;background-color: #9393E0;margin:2px 2px 0 0px;margin-top:15px!important;" class="cusbuttonupd" value="修&nbsp;&nbsp;改" />
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>

                        <?php
                        mysql_close();
                        ?>
                    </table>

                </div>
                <!--content-center end--->
                <!--find-->
                <?php include ('connect.php'); ?>
                <?php
                if (isset($_POST["cuslistupdbtn"]) || isset($_POST["cusupdatesavebtn"])) {
                    $listupdid = $_GET['updId'];
                    ?><!--列表修改-->
                    <form action="./cusadd.php?listupdid=<?php echo $listupdid ?>" onsubmit="return listupdate_click()" method="post">
                        <div style="position: relative;top:-543px;z-index: 9999;">
                            <div style="margin: 0 auto;width:880px;height: auto;background-color:#4D4DE0;border:2px solid black;">
                                <div style="width: 100%;text-align: center;font-size: 35px;color: white;">修改信息</div>
                                <table border="1"cellpadding="0"cellspacing="0" align="center">
                                    <tr style="text-align: center;font-size: 26px;color: white;">
                                        <td>房间号</td>
                                        <td>姓名</td>
                                        <td>性别</td>
                                    </tr>
                                    <?php include ('connect.php'); ?>
                                    <?php
                                    $exec = "SELECT * FROM tbl_hotel_customer_info where id='$listupdid'";
                                    $result = mysql_query($exec);
                                    while ($rs = mysql_fetch_object($result)) {
                                        $cusmsgNum_2 = $rs->cus_roomnum;
                                        $cusmsgName_2 = $rs->cus_name;
                                        $cusmsgSex_2 = $rs->cus_sex;
                                        ?> 
                                        <tr style="font-size: 20px;">
                                            <td><input autofocus="true" type="text" id="listrmNum" name="listrmNum" autocomplete="off" onkeyup="value = value.replace(/[^\0-9]/g, '')" placeholder="<?php echo $cusmsgNum_2; ?>"  class="listelementstyle"/></td>
                                            <td><input type="text" id="listrmName" name="listrmName" autocomplete="off" onkeyup="value = value.replace(/[^\u4E00-\u9FA5\A-Za-z ]/g, '')" placeholder="<?php echo $cusmsgName_2; ?>"  class="listelementstyle"/></td>
                                            <td><input type="text" id="listrmSex" name="listrmSex" autocomplete="off"  onkeyup="value = value.replace(/[^\u4E00-\u9FA5]\A-Za-z ]/g, '')" placeholder="<?php
                                                if ($cusmsgSex_2 == 0)
                                                    echo '男';
                                                if ($cusmsgSex_2 == 1)
                                                    echo '女';
                                                ?>" class="listelementstyle"/>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </table>
                                <table style="width:880px;text-align: center">
                                    <tr>
                                        <td>
                                            <input type="submit" value="保&nbsp;&nbsp;存" class="cusbutton"  name="listupdateSave" style="font-size: 25px;"/>
                                        </td>
                                        <td>
                                            <input type="button" value="取&nbsp;&nbsp;消"  class="cusbutton" onclick="listupdateExit_click()" style="font-size: 25px;"/>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </form>
                    <?php
                }
                ?>
                <?php
                if (isset($_POST["customermsgfind"])) {
                    $findtmpvalue = $_POST['Findputtext'];
                    if (!eregi("[^\x80-\xff]", "$findtmpvalue") || preg_match("/[\x7f-\xff]/", $findtmpvalue)) {
                        $sql = "SELECT * FROM  `tbl_hotel_customer_info` WHERE cus_name='$findtmpvalue'";
                    } else {
                        $sql = "SELECT * FROM  `tbl_hotel_customer_info` WHERE cus_roomnum ='$findtmpvalue'OR cus_name='$findtmpvalue'";
                    }

                    $resultF = mysql_query($sql, $conn);
                    ?>
                    <div style="position: relative;top: -530px;">
                        <div id="findinfobox" style="margin: 0 auto;width:1100px;height:500px;border:2px solid black;overflow: hidden;font-size:30px;background-color:#485FE4;z-index: 9999;display:block;color:whitesmoke;display: block">
                            <div style="position: relative;left:20px;top:5px;font-size: 35px;font-weight: bold;">查找信息</div>
                            <div style="width:1100px;height:308px;position: relative;top: 70px;left:0px;font-size:30px;background-color:whitesmoke;display:block;color:black;display: block">
                                <?php
                                while ($rs = mysql_fetch_object($resultF)) {
                                    //echo '查询成功！';
                                    $rowidf = $rs->id;
                                    $cusmsgNum_1 = $rs->cus_roomnum;
                                    $cusmsgName_1 = $rs->cus_name;
                                    $cusmsgSex_1 = $rs->cus_sex;
                                    $cusmsgtime_1 = $rs->create_time;
                                    ?>
                                    <div style="width:1200px;height:60px;border-bottom:1px solid wheat;font-size:30px;text-align:center;line-height: 60px;overflow: hidden;">
                                        <form onsubmit="return cusUpdate_click()" action="?updId=<?php echo $rowidf ?>" method="post">
                                            <input type="text" name="cusmsgNum" id="cusmsgNum_1" autocomplete="off" readonly="true" onkeyup="value = value.replace(/[^\0-9]/g, '')" style="background-color:whitesmoke;width:180px;height:48px;border:0px;position:absolute;left:0px;overflow: hidden;font-size:30px;text-align:center;line-height:48px;" value=" <?php echo $cusmsgNum_1; ?>">
                                            <input type="text" name="cusmsgName"  id="cusmsgName_1" autocomplete="off" readonly="true" onkeyup="value = value.replace(/[^\u4E00-\u9FA5\A-Za-z ]/g, '')" style="background-color:whitesmoke;width:200px;height:48px;border:0px;position:absolute;left:200px;overflow: hidden;font-size:30px;text-align:center;line-height:48px;" value="<?php echo $cusmsgName_1; ?>">
                                            <input type="text" name="cusmsgSex" id="cusmsgSex_1" autocomplete="off"  readonly="true" onkeyup="value = value.replace(/[^\u4E00-\u9FA5]/g, '')" style="background-color:whitesmoke;width:150px;height:48px;border:0px;position:absolute;left:400px;overflow: hidden;font-size:30px;text-align:center;line-height:48px;" value="<?php if ($cusmsgSex_1 == 0) echo '男';if ($cusmsgSex_1 == 1) echo '女'; ?>">
                                            <input type="text" name="cusmsgtime"  id=cusmsgtime_1" autocomplete="off" readonly="true" style="background-color:whitesmoke;width:300px;height:48px;border:0px;position:absolute;left:560px;overflow: hidden;font-size:30px;text-align:center;line-height:48px;" value="<?php echo $cusmsgtime_1; ?>">
                                            <input type="submit"  name="cusupdatesavebtn" style="border:0px;position:absolute;left:940px;background-color: #9393E0;margin:2px 2px 0 35px;margin-top:7px!important ;" class="cusbuttonupd" value="修&nbsp;&nbsp;改" />
                                        </form>
                                        <form action="./cusdel.php?delId=<?php echo $rowidf ?>" method="post">
                                            <input type="submit"  class="cusmsgdel" style="border:0px;position:absolute;left:880px;margin:2px 2px 0 35px;margin-top:-23px!important ;" value=""/>
                                        </form>

                                    </div>

                                    <?php
                                }
                                ?>

                            </div>
                            <div><input type="button" name="findinfoexitbtn" id="findinfoexitbtn" class="cusbutton" style="position: absolute;top:438px;left:506px;width:90px;height:50px;background-color: #A9A0A0;font-size: 25px;" value="退&nbsp;&nbsp;出" onclick="findExit_click()"/>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <!--end-->
                <!--addinputbox-->
                <div id="cusaddinputbox">
                    <div style="margin: 0 auto;width:446px;background-color:#1C20B1;border: 4px solid #220794; border-radius:9px; -webkit-border-radius:15px; -moz-border-radius: 9px; color: white; font-weight:bold; font-size: 35px;">
                        <div style="width: 100%;text-align: center">客户信息录入</div>
                        <form action="./cusadd.php" onsubmit="return inputsave_click()" id="cusinputform" name="cusinputform" method="post">
                            <table  align="center"  style="width: 100%;height:300px;color: white;font-size: 30px;font-weight: bold;">
                                <tr>
                                    <td>房间号：</td>
                                    <td><input type="text" id="cusinputroomnum" class="cusinputbox" name="cusinputroomnum" autocomplete="off" onkeyup="value = value.replace(/\D+/g, '')" placeholder="‘101’格式"/></td>
                                </tr>
                                <tr>
                                    <td >客户名：</td>
                                    <td >
                                        <input type="text" name="cusinputname" id="cusinputname" class="cusinputbox" value="" autocomplete="off" onkeyup="value = value.replace(/[\d]/g, '')" placeholder="中文或英文名"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>性&nbsp;&nbsp;&nbsp;&nbsp;别：</td>
                                    <td>
                                        <span>男<input id="man" name="cusSex" type="radio" class="cusinputbtn" value="0" checked="checked"/></span><!--checked="checked"-->
                                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        <span>女<input id="woman" name="cusSex" type="radio" class="cusinputbtn" value="1"/></span>
                                    </td>
                                </tr>

                            </table>
                            <table style="width: 100%;text-align: center">
                                <tr >
                                    <td><input type="submit" id="cusinputsave" name="cusinputsave" class="cusbutton" value="保&nbsp;&nbsp;存"/></td>
                                    <td><input type="button" id="cusinputdel" class="cusbutton" value="取&nbsp;&nbsp;消" onclick="inputdel_click()"/></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!--提示框-->
        <div id="cuspromptdiv" >
            <div id="cusprompttext" style="position:absolute;width:400px;height:20px;top:20px;text-align: center;"></div>
            <div style="position:absolute;width:400px;height:20px;top:90px;text-align: center;"><input type="button" style="width:85px;height:45px;color:black;font-size: 20px;" onclick="pro_click()" value="确&nbsp;&nbsp;定"/></div>
        </div>

        <!--end-->
        <!--Exit prompt-->
        <div id="exitpromptdiv" >
            <div id="exitprompttext" style="position:absolute;width:450px;height:20px;top:20px;text-align: center;">确认退出该系统？</div>
            <div style="position:absolute;width:450px;height:20px;top:90px;text-align: center;">
                <input type="button" style="width:85px;height:45px;color:black;font-size: 20px;text-align: center;line-height: 45px;overflow: hidden;" onclick="exitOK_click()" class="cusbutton" value="确&nbsp;&nbsp;定"/>
                <input type="button" style="width:85px;height:45px;color:black;font-size: 20px;text-align: center;line-height: 45px;overflow: hidden;" onclick="exitNO_click()" class="cusbutton" value="取&nbsp;&nbsp;消"/>
            </div>
        </div>

    </body>
</html>
