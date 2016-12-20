
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
        
        <!--login-->
        <div id="loginmoduler">
            <div id="logininput">
                <form action=""  method="post"><!--action="tmp/tmp.txt"  ./cusindex.php-->
                    <input type="text" name="loginusername" id="loginusername" value=""/>
                    <input type="password" name="loginpassword" id="loginpassword" value=""/>
                    <table style="margin-top:20px;" >
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
            include ('connect.php');
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
                setcookie("Hotelcusinputindex","yes");
            } else {
                //header('Location:./index.php');
                ?>
                        <script>
                (function (){
                 alert("用户密码输入错误或不能为空！");
            })();
            </script>
                    <?php
            }
        }
    }else if($logintmpname !== 'receptionist'){
        ?>
            <script>
                (function (){
                 alert("用户密码输入错误或不能为空！");
            })();
            </script>
            <?php
    }

//用户名receptionist
//密码vvbridge
}
?>

    </body>
</html>
