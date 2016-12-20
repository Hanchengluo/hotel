<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
		cgi::both($this->g_cgival["id"], "id", 0);
	}
	
	function get_data() {
		
		$id = $this->g_cgival["id"];
		
		if ($id) {
			
			$db_hotel_video_category = new db_hotel_video_category();
			$item = $db_hotel_video_category->admin_get_item_by_id($id);
		}
		
		$this->g_show["item"] = $item;
		
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