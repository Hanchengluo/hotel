
<?php

// put your code here
//$url="192.168.172.136";
$url = "localhost";
$user = "root";
$password = "root";

$conn = mysql_connect($url, $user, $password);

if (!$conn) {
    die("连接失败" . mysql_error());
}

mysql_select_db("hotel_vvb");

/* $sql="CREATE TABLE tbl_hotel_customer_info"
  . "("
  . "id int AUTO_INCREMENT,"
  . "cus_roomnum varchar(30) not null,"
  . "cus_name varchar(30) not null,"
  . "cus_sex varchar(20)) not null"; */
//mysql_query($sql,$conn);
//mysql_close($conn);
//$conn->set_charset('utf-8');
mysql_set_charset("utf8", $conn);
?>

