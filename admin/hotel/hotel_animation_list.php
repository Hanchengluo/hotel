<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
		cgi::both($this->g_cgival["p"], "p", 1);
	}
	
	function get_data() {
		
		$p = $this->g_cgival["p"];
		$pcount = -1;
		
		$showValue = array();
		
		$db_hotel_animation = new db_hotel_animation();

		$count = $db_hotel_animation->admin_get_count();
		
		$list = $db_hotel_animation->admin_get_list($this->g_cgival["p"], $pcount);
		
		foreach ($list as $db_hotel_animation_key => $db_hotel_animation_value) {
		    $tmpValue = array();
		    $tmpValue["id"] = $db_hotel_animation_value["id"];
		    $tmpValue["url"] = $db_hotel_animation_value["url"];
		    $tmpValue["version"] = $db_hotel_animation_value["version"];
		    
		    $showValue[] = $tmpValue;
		}
		
		$this->g_show["count"] = $count;
		$this->g_show["list"] = $showValue;
		
		$Pages = new Pages($count, $p, $pcount);
		$page_bar = $Pages->getLinks_admin("hotel_animation_list.php?p=", 5);
		
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