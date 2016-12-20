<?php
/*
 * http://localhost:8088/hotel_api/program_info.php
 */
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

try {
	
	$db_hotel_program_info = new db_hotel_program_info();
	$hotel_program_info_list = $db_hotel_program_info->admin_get_list(1, -1);
	
	$program_version = -1;
	foreach ($hotel_program_info_list as $hotel_program_info) {
		if ($hotel_program_info["playing_state"] == "off") {
			continue;
		}
		$program_name = $hotel_program_info["program_name"];
		$program_num = $hotel_program_info["program_num"];
		$program_url = $hotel_program_info["program_url"];
		if ($program_version == -1) {
			$program_version = $hotel_program_info["version"];
		}
		
		$channel_obj = array("name" => urlencode($program_name),
				"program_number" => $program_num,
				"url" => $program_url
		);

		$channels[] = json_encode($channel_obj);
	}
	
	$channels_obj = array("channels" => $channels, "version" => $program_version);
	header("Content-type: text/html; charset=utf-8");
	echo urldecode(json_encode($channels_obj));
	
} catch (Exception $e) {
    echo $e->getMessage();
}
