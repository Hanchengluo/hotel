<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
		cgi::both($this->g_cgival["p"], "p", 1);
		
		cgi::both($this->g_cgival["cookbook_category_id"], "cookbook_category_id", 0);
	}
	
	function get_data() {
		
		$p = $this->g_cgival["p"];
		$pcount = 10;	
		$cookbook_category_id = $this->g_cgival["cookbook_category_id"];

		$showValue = array();
		
		$db_hotel_cookbook_detail = new db_hotel_cookbook_detail();
		$count = $db_hotel_cookbook_detail->admin_get_count($cookbook_category_id);
		$list = $db_hotel_cookbook_detail->
				admin_get_list($this->g_cgival["p"], $pcount, $cookbook_category_id);
		
		$db_hotel_cookbook_category = new db_hotel_cookbook_category();
		$cookbook_category_list = $db_hotel_cookbook_category->admin_get_list(1, 100);
		
		$this->g_show["cookbook_category_list"] = $cookbook_category_list;
		
		foreach ($list as $cookbook_detail_key => $cookbook_detail_value) {
			$tmpValue = array();
			$tmpValue["id"] = $cookbook_detail_value["id"];
			
			foreach ($cookbook_category_list as $cookbook_category_key => $cookbook_category_value) {
				if ($videl_detail_value["cookbook_category_id"] == $cookbook_category_value["id"]) {
					$tmpValue["cookbook_category_name"] = $cookbook_category_value["cookbook_category_name"];
					break;
				}
			}
			
			$tmpValue["cookbook_name"] = $cookbook_detail_value["cookbook_name"];
			$tmpValue["cookbook_thumbnail_address"] = $cookbook_detail_value["cookbook_thumbnail_address"];
			$tmpValue["cookbook_introduction"] = $cookbook_detail_value["cookbook_introduction"];
			$tmpValue["cookbook_price"] = $cookbook_detail_value["cookbook_price"];
			
			$showValue[] = $tmpValue;
		}
		
		
		$this->g_show["count"] = $count;
		$this->g_show["list"] = $showValue;
		
		$Pages = new Pages($count, $p, $pcount);
		$page_bar = $Pages->getLinks_admin("hotel_cookbook_detail_list.php?p=", 5);
		
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