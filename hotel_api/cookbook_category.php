<?php
/*
 * http://localhost:8088/hotel_api/cookbook_category.php
 */
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

try {
	
	$db_hotel_cookbook_category = new db_hotel_cookbook_category();
	$hotel_cookbook_category_list = $db_hotel_cookbook_category->admin_get_list(1, -1);
	
	$cookbook_categories = array();
	foreach ($hotel_cookbook_category_list as $hotel_cookbook_category) {
		$cookbook_category_id = $hotel_cookbook_category["id"];
		$cookbook_category_name = $hotel_cookbook_category["cookbook_category_name"];

		$cookbook_category_obj = array("cookbook_category_id" => $cookbook_category_id,
				"cookbook_category_name" => urlencode($cookbook_category_name)
		);

		$cookbook_categories[] = json_encode($cookbook_category_obj);
	}
	
	$cookbook_categories_obj = array("cookbook_categories" => $cookbook_categories);
	header("Content-type: text/html; charset=utf-8");
	echo urldecode(json_encode($cookbook_categories_obj));
	
} catch (Exception $e) {
    echo $e->getMessage();
}
