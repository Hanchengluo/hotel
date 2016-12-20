<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
		cgi::both($this->g_cgival["id"], "id", 0);
		
		cgi::both($this->g_cgival["cookbook_category_id"], "cookbook_category", 0);
		
		cgi::both($this->g_cgival["cookbook_name"], "cookbook_name", "");
		$this->g_cgival["cookbook_name"] = string::un_html($this->g_cgival["cookbook_name"]);
		
		cgi::both($this->g_cgival["cookbook_thumbnail_address"], "cookbook_thumbnail_address", "");
		$this->g_cgival["cookbook_thumbnail_address"] = string::un_html($this->g_cgival["cookbook_thumbnail_address"]);
		
		cgi::both($this->g_cgival["cookbook_introduction"], "cookbook_introduction", "");
		$this->g_cgival["cookbook_introduction"] = string::un_html($this->g_cgival["cookbook_introduction"]);
		
		cgi::both($this->g_cgival["cookbook_price"], "cookbook_price", "");
		$this->g_cgival["cookbook_price"] = string::un_html($this->g_cgival["cookbook_price"]);
		
		cgi::both($this->g_cgival["cookbook_category_id_fetch"], "cookbook_category_id", -1);
		
		cgi::both($this->g_cgival["type"], "type", "add");
	}
	
	function get_data() {
		
		$id = $this->g_cgival["id"];
		$cookbook_category_id = $this->g_cgival["cookbook_category_id"];
		$cookbook_name = $this->g_cgival["cookbook_name"];
		$cookbook_thumbnail_address = $this->g_cgival["cookbook_thumbnail_address"];
		$cookbook_introduction = $this->g_cgival["cookbook_introduction"];
		$cookbook_price = $this->g_cgival["cookbook_price"];
		$type = $this->g_cgival["type"];
		$db_hotel_cookbook_detail = new db_hotel_cookbook_detail();
	
		if ($type== "add") {
			if ($id) {
			    
				$res = $db_hotel_cookbook_detail->
					admin_update_hotel_cookbook_detail_by_id($id, $cookbook_category_id, $cookbook_name, $cookbook_thumbnail_address, $cookbook_introduction, $cookbook_price);
				
				if (!$res) {
					echo "<script>alert('数据库操作失败！');location.href='hotel_cookbook_detail_list.php';</script>";
					exit;
				}
				
				echo "<script>alert('操作成功');location.href='hotel_cookbook_detail_list.php';</script>";
				
				exit;
			} else {
				$res = $db_hotel_cookbook_detail->admin_insert_hotel_cookbook_detail($cookbook_category_id, $cookbook_name, $cookbook_thumbnail_address, $cookbook_introduction, $cookbook_price);
				
				if (!$res) {
					echo "<script>alert('数据库操作失败！');location.href='hotel_cookbook_detail_list.php';</script>";
					exit;
				}
				
				echo "<script>alert('操作成功');location.href='hotel_cookbook_detail_list.php';</script>";
				exit;
			}
				
		} elseif ($type == "del") {
			$res = $db_hotel_cookbook_detail->admin_del_hotel_cookbook_detail_by_id($id);
			if (!$res) {
				throw new Exception("数据库操作失败！");
			}
		} elseif ($type == "fetch") {
			$cookbook_category_id = $this->g_cgival["cookbook_category_id_fetch"];
			
			$db_hotel_cookbook_detail = new db_hotel_cookbook_detail();
			$hotel_videl_detail_list = $db_hotel_cookbook_detail->admin_get_list(1, 100);
			
			$cookbook_info = array();
			foreach ($hotel_videl_detail_list as $hotel_videl_detail) {
				if ($ad_image["cookbook_category_id"] == $cookbook_category_id) {
					$tmp_cookbook_detail_info = array();
					$tmp_cookbook_detail_info["id"] = $hotel_videl_detail["id"];
					$tmp_cookbook_detail_info["cookbook_name"] = $hotel_videl_detail["cookbook_name"];
					$tmp_cookbook_detail_info["cookbook_thumbnail_address"] = $hotel_videl_detail["cookbook_thumbnail_address"];
					$tmp_cookbook_detail_info["cookbook_introduction"] = $hotel_videl_detail["cookbook_introduction"];

					$cookbook_info[] = $tmp_cookbook_detail_info;
				}
			}
			
			echo json_encode($cookbook_info);
			exit;
		}
		
	}
	
	function show_pro() {
		$file_type ="interface"; //or interface
		parent::show_pro($file_type);		
	}
	
}

$prodect_main = new prodect_main();
$prodect_main->admin_check();//后台程序检查
$prodect_main->main_do();

?>