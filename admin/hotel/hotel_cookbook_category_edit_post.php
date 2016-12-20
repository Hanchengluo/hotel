<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
		cgi::both($this->g_cgival["id"], "id", 0);
		
		cgi::both($this->g_cgival["cookbook_category_name"], "cookbook_category_name", "");
		
		$this->g_cgival["cookbook_category_name"] = string::un_html($this->g_cgival["cookbook_category_name"]);
		
		cgi::both($this->g_cgival["type"], "type", "add");
	}
	
	function get_data() {
		
		$id = $this->g_cgival["id"];
		$cookbook_category_name = $this->g_cgival["cookbook_category_name"];
		$type = $this->g_cgival["type"];
		$db_hotel_cookbook_category = new db_hotel_cookbook_category();
		
		if ($type== "add") {
			if ($id) {
				$res = $db_hotel_cookbook_category->admin_update_hotel_cookbook_category_by_id($id, $cookbook_category_name);
				
				if (!$res) {
					echo "<script>alert('数据库操作失败！');location.href='hotel_cookbook_category_list.php';</script>";
					exit;
				}
				
				echo "<script>alert('操作成功');location.href='hotel_cookbook_category_list.php';</script>";
				
				exit;
			} else {
				
				$res = $db_hotel_cookbook_category->admin_insert_hotel_cookbook_category($cookbook_category_name);
				
				if (!$res) {
					echo "<script>alert('数据库操作失败！');location.href='hotel_cookbook_category_list.php';</script>";
					exit;
				}
				
				echo "<script>alert('操作成功');location.href='hotel_cookbook_category_list.php';</script>";
				exit;
			}	
		} elseif ($type == "del") {
		
			$res = $db_hotel_cookbook_category->admin_del_hotel_cookbook_category_by_id($id);
			if (!$res) {
				throw new Exception("数据库操作失败！");
			}
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