<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
		cgi::both($this->g_cgival["p"], "p", 1);
		
		cgi::both($this->g_cgival["cookbook_category_name"], "cookbook_category_name", "");
		$this->g_cgival["cookbook_category_name"] =
			string::un_html($this->g_cgival["cookbook_category_name"]);
		
	}
	
	function get_data() {
		
		$p = $this->g_cgival["p"];
		$pcount = 10;
		$cookbook_category_name = $this->g_cgival["cookbook_category_name"];

		$showValue = array();
		
		$db_hotel_cookbook_category = new db_hotel_cookbook_category();
		
		$count = $db_hotel_cookbook_category->admin_get_count($cookbook_category_name);
		
		$list = $db_hotel_cookbook_category->admin_get_list($this->g_cgival["p"], $pcount, $cookbook_category_name);
		
		foreach ($list as $hotel_welcome_key => $hotel_welcome_value) {
		    $tmpValue = array();
		    $tmpValue["id"] = $hotel_welcome_value["id"];
		    $tmpValue["cookbook_category_name"] = $hotel_welcome_value["cookbook_category_name"];
		    $showValue[] = $tmpValue;
		}
		
		$this->g_show["count"] = $count;
		$this->g_show["list"] = $showValue;
		
		// TODO
		$Pages = new Pages($count, $p, $pcount);
		$page_bar = $Pages->getLinks_admin("hotel_cookbook_category_list.php?p=", 5);
		
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