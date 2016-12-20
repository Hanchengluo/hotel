
<?php

include ('connect.php')
?>
<?php

if (isset($_GET['delId'])) {//&& !empty($_POST['$rowid'])
    $cusmsgNum_id = $_GET['delId'];
    echo '$cusmsgNum_id' + $cusmsgNum_id;
    $sql = "DELETE FROM `tbl_hotel_customer_info` WHERE id='$cusmsgNum_id'";
    mysql_query($sql, $conn);
    header('Location:./firstindex.php');
} else {
    $cusmsgNum_id = $_GET['delId'];
    echo $cusmsgNum_id;
    echo '删除失败！';
}
?>

