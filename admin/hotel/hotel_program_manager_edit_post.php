<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
	    
		cgi::both($this->g_cgival["id"], "id", 0);
		
		cgi::both($this->g_cgival["program_json_address"], "program_json_address", "");
		$this->g_cgival["program_json_address"] = string::un_html($this->g_cgival["program_json_address"]);
		
		cgi::both($this->g_cgival["type"], "type", "add");

	}
	
	function get_data() {
		
		$id = $this->g_cgival["id"];
		$program_json_address = $this->g_cgival["program_json_address"];
		$type = $this->g_cgival["type"];
		
		$db_hotel_program_manager = new db_hotel_program_manager();
	
		if ($type== "add") {
			
			$json_string = file_get_contents("../../" . $program_json_address);
			$obj = json_decode($json_string, true);
			$program_version = $obj["version"];
			
			
			$program_channel = $obj["channel"];
			$program_channel_info = array();
			$length = count($program_channel);
			
			for ($i = 0; $i < $length; $i++) {
				$tmp_value = array();
				$tmp_value["name"] = $program_channel[$i]["name"];
				$tmp_value["program_num"] = $program_channel[$i]["program_number"];
				$tmp_value["url"] = $program_channel[$i]["url"];
				$tmp_value["playing_state"] = "on";
					
				$program_channel_info[] = $tmp_value;
			}
			$db_hotel_program_info = new db_hotel_program_info();
			
			
			
			if ($id) {
			    
				$res = $db_hotel_program_manager->
					admin_update_hotel_program_manager_by_id($id, $program_json_address, $program_version);
				
				if (!$res) {
					echo "<script>alert('数据库操作失败！');location.href='hotel_program_manager_list.php';</script>";
					exit;
				}
				
				$db_hotel_program_info->admin_insert_hotel_program_info($program_channel_info, $res, $program_version);
				
				echo "<script>alert('操作成功');location.href='hotel_program_manager_list.php';</script>";
				
// 				$db_hotel_program_info->admin_insert_hotel_program_info($program_channel_info, $id);
				
				exit;
			} else {
				
				$hotel_program_manager_list = $db_hotel_program_manager->admin_get_list(1, -1);
				
				if ($hotel_program_manager_list) {
					$tmp_url = substr($hotel_program_manager_list[0]['program_json_address'], 0, 13);
					$this->deldir('../..' . $tmp_url);
				}
				
				$res = $db_hotel_program_manager->admin_insert_hotel_program_manager($program_json_address, $program_version);
				
				
				if (!$res) {
					echo "<script>alert('数据库操作失败！');location.href='hotel_program_manager_list.php';</script>";
					exit;
				}
				
				$db_hotel_program_info->admin_insert_hotel_program_info($program_channel_info, $res, $program_version);
				
				echo "<script>alert('操作成功');location.href='hotel_program_manager_list.php';</script>";
				
				exit;
			}
				
		} elseif ($type == "del") {
			
			$data = $db_hotel_program_manager->admin_get_hotel_program_manager_by_id($id);
			if (!$data) {
				throw new Exception("数据库操作失败！");
				exit;
			}
			
			$tmp_url = substr($data[0]['program_json_address'], 0, 13);
			$this->deldir('../..' . $tmp_url);
			
			$res = $db_hotel_program_manager->admin_del_hotel_program_manager_by_id($id);
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