<?php
/*
 * http://localhost:8088/hotel_api/cookbook_detail.php?cookbook_category_id=6
 */
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

$image_address_tag = "_188";

try {
	
	if (!isset($_GET['cookbook_category_id'])) {
		throw new Exception('Parameter \'cookbook_category_id\' must be setted.');
	} else {
		$cookbook_category_id = $_GET['cookbook_category_id'];
	}
	
	$db_hotel_cookbook_detail = new db_hotel_cookbook_detail();
	$hotel_cookbook_detail_list = $db_hotel_cookbook_detail->admin_get_list(1, -1);
	
	$cookbook_details = array();
	foreach ($hotel_cookbook_detail_list as $hotel_cookbook_detail) {
		if ($cookbook_category_id == $hotel_cookbook_detail["cookbook_category_id"]) {
			$cookbook_id = $hotel_cookbook_detail["id"];
			$cookbook_name = $hotel_cookbook_detail["cookbook_name"];
			
			$cookbook_thumbnail_address_head = substr($hotel_cookbook_detail["cookbook_thumbnail_address"], 0, strrpos($hotel_cookbook_detail["cookbook_thumbnail_address"], $image_address_tag));
			$cookbook_thumbnail_address_tail = substr($hotel_cookbook_detail["cookbook_thumbnail_address"], strrpos($hotel_cookbook_detail["cookbook_thumbnail_address"], $image_address_tag) + strlen($image_address_tag));
			$cookbook_thumbnail_address = $cookbook_thumbnail_address_head . $cookbook_thumbnail_address_tail;
			
			$cookbook_introduction = $hotel_cookbook_detail["cookbook_introduction"];
			$cookbook_price = $hotel_cookbook_detail["cookbook_price"];
			
			$cookbook_detail_obj = array(
					"cookbook_id" => $cookbook_id,
					"cookbook_name" => urlencode($cookbook_name),
					"cookbook_thumbnail_address" => $cookbook_thumbnail_address,
					"cookbook_introduction" => urlencode($cookbook_introduction),
					"cookbook_price" => urlencode($cookbook_price)
			);
			
			$cookbook_details[] = json_encode($cookbook_detail_obj);
		}
		
	}
	
	$cookbook_details_obj = array("cookbook_details" => $cookbook_details);
	header("Content-type: text/html; charset=utf-8");
	echo urldecode(json_encode($cookbook_details_obj));
	
} catch (Exception $e) {
    echo $e->getMessage();
}
