<?php
/*
 * http://localhost:8088/hotel_api/welcome_info.php?mac_address=11:12:13:14:15:16
 */
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

$image_address_tag = "_188";

function get_client_ip() {
    
    if ($_SERVER['REMOTE_ADDR']) {
        $cip = $_SERVER['REMOTE_ADDR'];
    } elseif (getenv("REMOTE_ADDR")) {
        $cip = getenv("REMOTE_ADDR");
    } elseif (getenv("HTTP_CLIENT_IP")) {
        $cip = getenv("HTTP_CLIENT_IP");
    } else {
        $cip = "unknown";
    }
    
    return $cip;
}

try {
	
	if (!isset($_GET['mac_address'])) {
		throw new Exception('Parameter \'mac_address\' must be setted.');
	} else {
		$mac_address = $_GET['mac_address'];
	}
	
// 	echo $mac_address;
	
	/* $conn=mysql_connect("localhost", "root", "rootroot"); //连接数据库
	mysql_query("set names 'utf8'"); //数据库输出编码
	mysql_select_db("hotel_vvb"); //打开数据库
	$sql = "select * from tbl_hotel_customer_info where cus_roomnum in (select room_num from tbl_hotel_room_info where room_mac like '%" . $mac_address . "%')";
	$result = mysql_query($sql, $conn);
	list($id, $cus_roomnum, $customer_name, $customer_gender) = mysql_fetch_row($result);
	mysql_close(); //关闭MySQL连接 */
	
	/* $sql = "select * from tbl_hotel_customer_info where cus_roomnum in (select room_num from tbl_hotel_room_info where room_mac like '%" . $mac_address . "%')";
	echo $sql;
	$result = mysql_query($sql);
	echo "result:" . $result; */
	
	
	/* $db_hotel_room_info = new db_hotel_room_info();
	$hotel_room_info_list = $db_hotel_room_info->admin_get_list(1, -1, $mac_address);
	
	if (count($hotel_room_info_list) <= 0) {
		$json_obj = array();
	    
	    echo json_encode($json_obj);
		return;
	}
	
	$room_num = $hotel_room_info_list[0]["room_num"];
	
	$db_hotel_customer_info = new db_hotel_customer_info();
	$hotel_customer_info_list = $db_hotel_customer_info->admin_get_list(1, -1, $room_num);
	
	if (count($hotel_customer_info_list) <= 0) {
		$json_obj = array();
	    
	    echo json_encode($json_obj);
		return;
	}
	
	$customer_name = $hotel_customer_info_list[0]["cus_name"];
	$customer_gender = $hotel_customer_info_list[0]["cus_sex"]; */
	
	//select * from tbl_hotel_customer_info where cus_roomnum in (select room_num from tbl_hotel_room_info where room_mac like '%11:12:13:14:15:16%')
	$db_base = new db_base();
	$sql = "select * from tbl_hotel_customer_info where cus_roomnum in (select room_num from tbl_hotel_room_info where room_mac like '%" . $mac_address . "%')";
	$results = $db_base->mix_query($sql);
	/* if (count($results) <= 0) {
		$json_obj = array();
			
		echo json_encode($json_obj);
		return;
	} */
	
	if (count($results) > 0) {
		$customer_name = $results[0]["cus_name"];
		$customer_gender = $results[0]["cus_sex"];
	} else {
		$customer_name = "";
		$customer_gender = "";
	}
	
	$db_hotel_welcome = new db_hotel_welcome();
	$hotel_welcome_list = $db_hotel_welcome->admin_get_list(1, 1);

	/* if (count($hotel_welcome_list) <= 0) {
	    $json_obj = array();
	    
	    echo json_encode($json_obj);
	    return;
	} */
	
	if (count($hotel_welcome_list) > 0) {
		$hotel_welcome_list_first = $hotel_welcome_list[0];
		$hotel_welcome_list_first_image_address = $hotel_welcome_list_first["image_address"];
		
		$image_address_head = substr($hotel_welcome_list_first_image_address, 0, strrpos($hotel_welcome_list_first_image_address, $image_address_tag));
		$image_address_tail = substr($hotel_welcome_list_first_image_address, strrpos($hotel_welcome_list_first_image_address, $image_address_tag) + strlen($image_address_tag));
		$image_address = $image_address_head . $image_address_tail;
		$welcome_info = $hotel_welcome_list_first["welcome_info"];
	} else {
		$image_address = "";
		$welcome_info = "";
	}
	
	$json_obj = array("customer_name" =>$customer_name,
			"customer_gender" => $customer_gender,
			"image_address" => $image_address,
			"welcome_info" => $welcome_info);
	
	echo json_encode($json_obj);
	
	return;
	
} catch (Exception $e) {
    echo $e->getMessage();
}
