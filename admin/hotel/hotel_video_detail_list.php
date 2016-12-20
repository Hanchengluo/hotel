<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
		cgi::both($this->g_cgival["p"], "p", 1);
		
		cgi::both($this->g_cgival["video_category_id"], "video_category_id", 0);
	}
	
	function get_data() {
		
		$p = $this->g_cgival["p"];
		$pcount = 10;	
		$video_category_id = $this->g_cgival["video_category_id"];

		$showValue = array();
		
		$db_hotel_video_detail = new db_hotel_video_detail();
		$count = $db_hotel_video_detail->admin_get_count($video_category_id);
		$list = $db_hotel_video_detail->
				admin_get_list($this->g_cgival["p"], $pcount, $video_category_id);
		
		$db_hotel_video_category = new db_hotel_video_category();
		$video_category_list = $db_hotel_video_category->admin_get_list(1, 100);
		
		$this->g_show["video_category_list"] = $video_category_list;
		
		foreach ($list as $videl_detail_key => $videl_detail_value) {
			$tmpValue = array();
			$tmpValue["id"] = $videl_detail_value["id"];
			
			foreach ($video_category_list as $video_category_key => $video_category_value) {
				if ($videl_detail_value["video_category_id"] == $video_category_value["id"]) {
					$tmpValue["video_category_name"] = $video_category_value["video_category_name"];
					break;
				}
			}
			
			$tmpValue["video_name"] = $videl_detail_value["video_name"];
			$tmpValue["video_thumbnail_address"] = $videl_detail_value["video_thumbnail_address"];
			$tmpValue["video_introduction"] = $videl_detail_value["video_introduction"];
			$tmpValue["video_url"] = $videl_detail_value["video_url"];
			
			$showValue[] = $tmpValue;
		}
		
		
		$this->g_show["count"] = $count;
		$this->g_show["list"] = $showValue;
		
		$Pages = new Pages($count, $p, $pcount);
		$page_bar = $Pages->getLinks_admin("hotel_video_detail_list.php?p=", 5);
		
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