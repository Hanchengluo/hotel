<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
	    
		cgi::both($this->g_cgival["id"], "id", 0);
		
		cgi::both($this->g_cgival["room_file_address"], "room_file_address", "");
		$this->g_cgival["room_file_address"] = string::un_html($this->g_cgival["room_file_address"]);
		
		cgi::both($this->g_cgival["type"], "type", "add");

	}
	
	function get_data() {
		
		$id = $this->g_cgival["id"];
		$room_file_address = $this->g_cgival["room_file_address"];
		$type = $this->g_cgival["type"];

		$db_hotel_room_manager = new db_hotel_room_manager();
	
		if ($type== "add") {
			
			$room_info = array();
			
			$lines = file("../../" . $room_file_address);
			foreach ($lines as $line_num => $line) {
				$line_arr = explode("#", $line);
				$tmp_info = array();
				$tmp_info["room_num"] = $line_arr[0];
				if ($tmp_info["room_num"] == 0) {
					continue;
				}
				$tmp_info["room_mac"] = $line_arr[1];
				
				$room_info[] = $tmp_info;
			}
			
			$db_hotel_room_info = new db_hotel_room_info();
			
			if ($id) {
			    
				$res = $db_hotel_room_manager->
					admin_update_hotel_room_manager_by_id($id, $room_file_address);
				
				if (!$res) {
					echo "<script>alert('数据库操作失败！');location.href='hotel_room_manager_list.php';</script>";
					exit;
				}
				
				$db_hotel_room_info->admin_insert_hotel_room_info($room_info, $res);
				
				echo "<script>alert('操作成功');location.href='hotel_room_manager_list.php';</script>";
				
				exit;
			} else {
				
				$hotel_room_manager_list = $db_hotel_room_manager->admin_get_list(1, -1);
				
				if ($hotel_room_manager_list) {
					$tmp_url = substr($hotel_room_manager_list[0]['room_file_address'], 0, 13);
					$this->deldir('../..' . $tmp_url);
				}
				
				$res = $db_hotel_room_manager->admin_insert_hotel_room_manager($room_file_address);
				
				if (!$res) {
					echo "<script>alert('数据库操作失败！');location.href='hotel_room_manager_list.php';</script>";
					exit;
				}
				
				$db_hotel_room_info->admin_insert_hotel_room_info($room_info, $res);
				
				echo "<script>alert('操作成功');location.href='hotel_room_manager_list.php';</script>";
				
				exit;
			}
			
			
				
			
				
		} elseif ($type == "del") {
			
			$data = $db_hotel_room_manager->admin_get_hotel_room_manager_by_id($id);
			if (!$data) {
				throw new Exception("数据库操作失败！");
				exit;
			}
				
			$tmp_url = substr($data[0]['room_file_address'], 0, 13);
			$this->deldir('../..' . $tmp_url);
			
			$res = $db_hotel_room_manager->admin_del_hotel_room_manager_by_id($id);
			if (!$res) {
				throw new Exception("数据库操作失败！");
			}
			
		} /* elseif ($type == "fetch") {
			
			$db_hotel_program_manager = new db_hotel_program_manager();
			$hotel_welcome_list = $db_hotel_program_manager->admin_get_list(1, 100);
			
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
		} */
		
	}
	
	function show_pro() {
		$file_type ="interface"; //or interface
		parent::show_pro($file_type);		
	}
	
	function deldir($dir) {
		$dh=opendir($dir);
		while ($file=readdir($dh)) {
			if($file!="." && $file!="..") {
				$fullpath=$dir."/".$file;
				if(!is_dir($fullpath)) {
					unlink($fullpath);
				} else {
					$this -> deldir($fullpath);
				}
			}
		}
	
		closedir($dh);
	
		if(rmdir($dir)) {
			return true;
		} else  {
			return false;
		}
	}
	
}

$prodect_main = new prodect_main();
$prodect_main->admin_check();//后台程序检查
$prodect_main->main_do();

?>