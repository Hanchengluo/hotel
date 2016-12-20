<?php
/*
 * http://localhost:8088/hotel_api/video_category.php
 */
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

try {
	
	$db_hotel_video_category = new db_hotel_video_category();
	$hotel_video_category_list = $db_hotel_video_category->admin_get_list(1, -1);
	
	$video_categories = array();
	foreach ($hotel_video_category_list as $hotel_video_category) {
		$video_category_id = $hotel_video_category["id"];
		$video_category_name = $hotel_video_category["video_category_name"];

		$video_category_obj = array("video_category_id" => $video_category_id,
				"video_category_name" => urlencode($video_category_name)
		);

		$video_categories[] = json_encode($video_category_obj);
	}
	
	$video_categories_obj = array("video_categories" => $video_categories);
	header("Content-type: text/html; charset=utf-8");
	echo urldecode(json_encode($video_categories_obj));
	
} catch (Exception $e) {
    echo $e->getMessage();
}
