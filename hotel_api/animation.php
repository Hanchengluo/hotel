<?php
/*
 * http://localhost:8088/hotel_api/animation.php
 */
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

try {
	
	$db_hotel_animation = new db_hotel_animation();
	$hotel_animation_list = $db_hotel_animation->admin_get_list(1, -1);
	
	$animation_arr = array();
	foreach ($hotel_animation_list as $hotel_animation) {
		$animation_id = $hotel_animation["id"];
		$animation_version = $hotel_animation["version"];
		$animation_url = $hotel_animation["url"];

		$animation_obj = array("animation_id" => $animation_id,
				"animation_version" => $animation_version,
				"animation_url" => $animation_url
		);

		$animation_arr[] = json_encode($animation_obj);
	}
	
	$animation = array("animation" => $animation_arr);
	header("Content-type: text/html; charset=utf-8");
	echo urldecode(json_encode($animation));
	
} catch (Exception $e) {
    echo $e->getMessage();
}
