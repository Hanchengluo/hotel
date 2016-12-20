<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
		cgi::both($this->g_cgival["p"], "p", 1);
	}
	
	function get_data() {
		
		$p = $this->g_cgival["p"];
		$pcount = 10;
		
		$showValue = array();

		$db_hotel_room_info = new db_hotel_room_info();

		$count = $db_hotel_room_info->admin_get_count();
		
		$list = $db_hotel_room_info->admin_get_list($this->g_cgival["p"], $pcount);

		foreach ($list as $hotel_room_info_key => $hotel_room_info_value) {
		    $tmpValue = array();
		    $tmpValue["id"] = $hotel_room_info_value["id"];
		    $tmpValue["room_num"] = $hotel_room_info_value["room_num"];
		    $tmpValue["room_mac"] = $hotel_room_info_value["room_mac"];

		    $showValue[] = $tmpValue;
		}
		
		$this->g_show["count"] = $count;
		$this->g_show["list"] = $showValue;
		
		// TODO
		$Pages = new Pages($count, $p, $pcount);
		$page_bar = $Pages->getLinks_admin("hotel_room_info_list.php?p=", 5);
		
		$this->g_show["page_bar"] = $page_bar;
	}
	
	function show_pro() {
		$file_type ="page"; //or interface
		parent::show_pro($file_type);	
	}
	
}

$prodect_main = new prodect_main();
$prodect_main->admin_check();//后台程序检查
$prodect_main->main_do();

?>