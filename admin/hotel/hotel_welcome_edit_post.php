<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
	    
		cgi::both($this->g_cgival["id"], "id", 0);

		cgi::both($this->g_cgival["welcome_info"], "welcome_info", "");
		$this->g_cgival["welcome_info"] = string::un_html($this->g_cgival["welcome_info"]);
		
		cgi::both($this->g_cgival["image_address"], "image_address", "");
		$this->g_cgival["image_address"] = string::un_html($this->g_cgival["image_address"]);
		
		cgi::both($this->g_cgival["type"], "type", "add");

	}
	
	function get_data() {
		
		$id = $this->g_cgival["id"];
		$image_address = $this->g_cgival["image_address"];
		$welcome_info = $this->g_cgival["welcome_info"];

// 		echo $this->g_cgival["welcome_info"];
		
		$type = $this->g_cgival["type"];

		$db_hotel_welcome = new db_hotel_welcome();
	
		if ($type== "add") {
			if ($id) {
			    
				$res = $db_hotel_welcome->
					admin_update_hotel_welcome_info_by_id($id, $image_address, $welcome_info);
				
				if (!$res) {
					echo "<script>alert('数据库操作失败！');location.href='hotel_welcome_list.php';</script>";
					exit;
				}
				
				echo "<script>alert('操作成功');location.href='hotel_welcome_list.php';</script>";
				
				exit;
			} else {
				$res = $db_hotel_welcome->admin_insert_hotel_welcome_info($image_address, $welcome_info);
				
				if (!$res) {
					echo "<script>alert('数据库操作失败！');location.href='hotel_welcome_list.php';</script>";
					exit;
				}
				
				echo "<script>alert('操作成功');location.href='hotel_welcome_list.php';</script>";
				exit;
			}
				
		} elseif ($type == "del") {

			$res = $db_hotel_welcome->admin_del_hotel_welcome_info_by_id($id);
			if (!$res) {
				throw new Exception("数据库操作失败！");
			}
			
		} elseif ($type == "fetch") {
			
			$db_hotel_welcome = new db_hotel_welcome();
			$hotel_welcome_list = $db_hotel_welcome->admin_get_list(1, 100);
			
			$hotel_welcome_info = array();
			foreach ($hotel_welcome_list as $hotel_welcome) {
				$tmp_hotel_welcome_info = array();
				$tmp_hotel_welcome_info["id"] = $hotel_welcome["id"];
				$tmp_hotel_welcome_info["image_address"] = $hotel_welcome["image_address"];
				$tmp_hotel_welcome_info["welcome_info"] = $hotel_welcome["welcome_info"];
				
				$hotel_welcome_info[] = $tmp_hotel_welcome_info;
			}
			
			echo json_encode($hotel_welcome_info);
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