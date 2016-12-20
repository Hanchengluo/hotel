
<!DOCTYPE html>
<html>
    <head>
        <title>first page</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="js/main.js"></script>

    </head>
    <body>
<!--        prompt
        <div id="promptbox">用户名或密码错误！</div>-->
        <!--login-->
        <div id="loginmoduler" style="position: absolute;top:190px;left:370px;display:block;">
            <img src="img/login-bg.png" width="526" height="297"/>
            <div id="logininput" style="position: absolute;top:90px;left:60px;">
                <img src="img/login-txt.png" width="202" height="99"/>
                <form action="" method="post"><!--action="tmp/tmp.txt"  ./cusloginpage.php-->
                    <input type="text" name="loginusername" id="loginusername" value=""/>
                    <input type="password" name="loginpassword" id="loginpassword" value=""/>
                    <table style="position: absolute;top:125px;left:0px;width:250px; height:40px;" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td style="width:100px;height:40px;"><input type="submit" id="loginOK" name="loginOK" class="loginbutton" value="登录"/></td>
                                <td style="width:100px;height:40px;"><input type="button" id="loginNO" class="loginbutton" onClick="loginNO_Click()" value="取消"/></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <?php 
            include ('index.php');
        ?>
<?php
  if (isset($_POST["loginOK"])) {
    $logintmpname = $_POST['loginusername'];
    $logintmppsw = $_POST['loginpassword'];
    if ($logintmpname == 'receptionist') {
        $sql = "SELECT `user_passwd` FROM `admin_user` WHERE `user_name`='receptionist';";
        $result = mysql_query($sql, $conn);
        while ($rs = mysql_fetch_object($result)) {

            $loginpsw = $rs->user_passwd;
            if ($loginpsw == md5($logintmppsw)) {
                header('Location:./firstindex.php');
            } else {
                header('Location:./loginpage.php');
            }
        }
    }

//用户名receptionist
//密码vvbridge
}
?>

    </body>
</html>
