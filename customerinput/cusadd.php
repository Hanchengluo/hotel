
<?php
include ('connect.php')
?>
<?php
//添加       
if (isset($_POST["cusinputsave"])) {
    $cusinputname = $_POST['cusinputname'];
    $cusinputroomnum = $_POST['cusinputroomnum'];
    $cusSex = $_POST['cusSex'];
    //判断roomnum
    $sqlrmNum = "SELECT room_num FROM `tbl_hotel_room_info`";
    $resultrmNum = mysql_query($sqlrmNum, $conn);
    $tmpcomparestatus = 0;
    while ($rs = mysql_fetch_object($resultrmNum)) {
        $tmprmNum = $rs->room_num;
        if ($cusinputroomnum === $tmprmNum) {
            $sqlCusrmNum = "SELECT cus_roomnum FROM `tbl_hotel_customer_info`";
            $resultCusrmNum = mysql_query($sqlCusrmNum, $conn);
            $tmpcomparestatus2 = 1;
            while ($rs = mysql_fetch_object($resultCusrmNum)) {
                $tmpCusrmNum = $rs->cus_roomnum;
                if ($cusinputroomnum === $tmpCusrmNum) {
                    $tmpcomparestatus2 = 0;
                }
            }
            $tmpcomparestatus = 1;
        }
    }
    if ($tmpcomparestatus === 0) {
        echo '<script language="javascript">alert("此房间不存在！");history.back();</script>';
    } else if ($tmpcomparestatus2 === 0) {
        echo '<script language="javascript">alert("此房间已存在！");history.back();</script>';
    } else if ($tmpcomparestatus2 === 1) {
        $sql = "INSERT INTO `hotel_vvb`.`tbl_hotel_customer_info` (`id`, `cus_roomnum`,`cus_name`, `cus_sex`) VALUES ('0', '$cusinputroomnum','$cusinputname', '$cusSex');";
        mysql_query($sql, $conn);
        header('Location:./firstindex.php');
    }
}
?>

<!-- //update2-->
<?php
if (isset($_POST["cuslistupdbtn"])) {
    ?>
    <div style="position: absolute;top:10px;left:50px;width:1000px;height: 500px;background-color: yellow;z-index: 9999;"></div>
    <?php
}
?>
<!--list update--->
<?php
if (isset($_POST["listupdateSave"])) {
    $updtmpid = $_GET['listupdid'];
    //echo $updtmpid;
    $cusinputname = $_POST['listrmName'];
    $cusinputroomnum = $_POST['listrmNum'];
    if ($_POST['listrmSex'] == '女') {
        $cusSex = 1;
    } else {
        $cusSex = 0;
    }
    $sqlupdrmNum = "SELECT room_num FROM `tbl_hotel_room_info`";
    $resultupdrmNum = mysql_query($sqlupdrmNum, $conn);
    $tmpupdcomparestatus = 0;
    while ($rs = mysql_fetch_object($resultupdrmNum)) {
        $tmpupdrmNum = $rs->room_num;
        if ($cusinputroomnum == $tmpupdrmNum) {
            $tmpupdcomparestatus = 1;
        }
    }
    if ($tmpupdcomparestatus === 0) {
        echo '<script language="javascript">alert("此房间不存在！");history.back();</script>';
    } else {
        $sql = "UPDATE `hotel_vvb`.`tbl_hotel_customer_info` SET `cus_roomnum`=$cusinputroomnum,`cus_name`='$cusinputname',`cus_sex`=$cusSex WHERE id=$updtmpid";
        mysql_query($sql, $conn);
        // echo '添加成功！';
        header('Location:./firstindex.php');
    }
}
?>
