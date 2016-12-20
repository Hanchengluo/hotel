<?php
/*
 * http://localhost:8088/hotel_api/video_detail.php?video_category_id=6
 */
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

$image_address_tag = "_188";

try {
	
	if (!isset($_GET['video_category_id'])) {
		throw new Exception('Parameter \'video_category_id\' must be setted.');
	} else {
		$video_category_id = $_GET['video_category_id'];
	}
	
	$db_hotel_video_detail = new db_hotel_video_detail();
	$hotel_video_detail_list = $db_hotel_video_detail->admin_get_list(1, -1);
	
	$video_details = array();
	foreach ($hotel_video_detail_list as $hotel_video_detail) {
		if ($video_category_id == $hotel_video_detail["video_category_id"]) {
			$video_name = $hotel_video_detail["video_name"];
			
			$video_thumbnail_address_head = substr($hotel_video_detail["video_thumbnail_address"], 0, strrpos($hotel_video_detail["video_thumbnail_address"], $image_address_tag));
			$video_thumbnail_address_tail = substr($hotel_video_detail["video_thumbnail_address"], strrpos($hotel_video_detail["video_thumbnail_address"], $image_address_tag) + strlen($image_address_tag));
			$video_thumbnail_address = $video_thumbnail_address_head . $video_thumbnail_address_tail;
			
			$video_introduction = $hotel_video_detail["video_introduction"];
			$video_url = $hotel_video_detail["video_url"];
			$video_price_single = $hotel_video_detail["video_price_single"];
			$video_rating = $hotel_video_detail["video_rating"];
			$video_area = $hotel_video_detail["video_area"];
			$video_online_time = $hotel_video_detail["video_online_time"];
			$video_duration = $hotel_video_detail["video_duration"];
			$video_director = $hotel_video_detail["video_director"];
			$video_star = $hotel_video_detail["video_star"];
			$video_price_one_day = $hotel_video_detail["video_price_one_day"];
			
			$video_detail_obj = array("video_name" => urlencode($video_name),
					"video_thumbnail_address" => $video_thumbnail_address,
					"video_introduction" => urlencode($video_introduction),
					"video_url" => urlencode($video_url),
					"video_price_single" => urlencode($video_price_single),
					"video_rating" => urlencode($video_rating),
					"video_area" => urlencode($video_area),
					"video_online_time" => urlencode($video_online_time),
					"video_duration" => urlencode($video_duration),
					"video_director" => urlencode($video_director),
					"video_star" => urlencode($video_star),
					"video_price_one_day" => urlencode($video_price_one_day)
			);
			
			$video_details[] = json_encode($video_detail_obj);
		}
		
	}
	
	$video_details_obj = array("video_details" => $video_details);
	header("Content-type: text/html; charset=utf-8");
	echo urldecode(json_encode($video_details_obj));
	
} catch (Exception $e) {
    echo $e->getMessage();
}
