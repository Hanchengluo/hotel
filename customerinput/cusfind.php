
<?php

include ('index.php');
?>
<?php

if (isset($_POST["customermsgfind"])) {
    $findtmpvalue = $_POST['Findputtext'];
    echo '===========================';
    echo $findtmpvalue;
    $sql = "SELECT * FROM  `tbl_hotel_customer_info` WHERE cus_roomnum ='$findtmpvalue'";
    $result = mysql_query($sql, $conn);
    while ($rs = mysql_fetch_object($result)) {
        echo '查询成功！';
        $cusmsgNum_1 = $rs->cus_roomnum;
        $cusmsgName_1 = $rs->cus_name;
        $cusmsgSex_1 = $rs->cus_sex;
        echo $cusmsgNum_1;
        echo $cusmsgName_1;
        echo $cusmsgSex_1;
    }
    //header('Location:./firstindex.php');
}
?>


