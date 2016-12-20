
<?php

include ('index.php');
?>
<?php

if (isset($_POST["loginOK"])) {
    $logintmpname = $_POST['loginusername'];
    $logintmppsw = $_POST['loginpassword'];
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
//用户名receptionist
//密码vvbridge
}
?>


