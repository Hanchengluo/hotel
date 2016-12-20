<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
		cgi::both($this->g_cgival["id"], "id", 0);
		
		cgi::both($this->g_cgival["program_name"], "program_name", "");
		$this->g_cgival["program_name"] = string::un_html($this->g_cgival["program_name"]);
		
		cgi::both($this->g_cgival["program_num"], "program_num", "");
		$this->g_cgival["program_num"] = string::un_html($this->g_cgival["program_num"]);
		
		cgi::both($this->g_cgival["program_url"], "program_url", "");
		$this->g_cgival["program_url"] = string::un_html($this->g_cgival["program_url"]);
		
		
		cgi::both($this->g_cgival["version"], "version", "");
		$this->g_cgival["version"] = string::un_html($this->g_cgival["version"]);
		
		cgi::both($this->g_cgival["hotel_program_manager_id"], "hotel_program_manager_id", "");
		$this->g_cgival["hotel_program_manager_id"] = string::un_html($this->g_cgival["hotel_program_manager_id"]);
		
		cgi::both($this->g_cgival["program_num_old"], "program_num_old", "");
		$this->g_cgival["program_num_old"] = string::un_html($this->g_cgival["program_num_old"]);
		

		cgi::both($this->g_cgival["type"], "type", "add");
	}
	
	function get_data() {
		
		$id = $this->g_cgival["id"];
		$program_name = $this->g_cgival["program_name"];
		$program_num = $this->g_cgival["program_num"];
		$program_url = $this->g_cgival["program_url"];
		$program_version = $this->g_cgival["version"];
		$hotel_program_manager_id = $this->g_cgival["hotel_program_manager_id"];
		$program_num_old = $this->g_cgival["program_num_old"];
		$type = $this->g_cgival["type"];
		
		$db_hotel_program_info = new db_hotel_program_info();
		
		if ($type== "add") {
			$program_channel_info = array();
			$tmp_value = array();
			$tmp_value["name"] = $program_name;
			$tmp_value["program_num"] = $program_num;
			$tmp_value["url"] = $program_url;
			$tmp_value["playing_state"] = "on";
			
			$program_channel_info[] = $tmp_value;

			if ($id) {

				/* if ($program_num_old != $program_num) {
					$list = $db_hotel_program_info->admin_get_list(1, -1, $program_num);
					
					if ($list == null) {
						$res = $db_hotel_program_info->admin_update_hotel_program_info_by_id($id, $program_channel_info, $hotel_program_manager_id, $program_version);
						if (!$res) {
							echo "<script>alert('数据库操作失败！');location.href='hotel_program_info_list.php';</script>";
							exit;
						}
					} else {

						$tmp_program_channel_info = array();
						$tmp_value = array();
						$tmp_value["name"] = $list[0]['program_name'];
						$tmp_value["program_num"] = $program_num_old;//$list[0]['program_num'];
						$tmp_value["url"] = $list[0]['program_url'];
						$tmp_program_channel_info[] = $tmp_value;
						$tmp_hotel_program_manager_id = $list[0]['hotel_program_manager_id'];
						$tmp_program_version = $list[0]['version'];
						
						$db_hotel_program_info->admin_update_hotel_program_info_by_id($list[0]['id'], $tmp_program_channel_info, $tmp_hotel_program_manager_id, $tmp_program_version);
						$db_hotel_program_info->admin_update_hotel_program_info_by_id($id, $program_channel_info, $hotel_program_manager_id, $program_version);
						echo "<script>alert('操作成功!节目号冲突,已交换！');location.href='hotel_program_info_list.php';</script>";
						exit;
					}
				} else {
					$res = $db_hotel_program_info->admin_update_hotel_program_info_by_id($id, $program_channel_info, $hotel_program_manager_id, $program_version);
					if (!$res) {
						echo "<script>alert('数据库操作失败！');location.href='hotel_program_info_list.php';</script>";
						exit;
					}
				}
				
				echo "<script>alert('操作成功');location.href='hotel_program_info_list.php';</script>";
				
				exit; */
			} else {
				$db_hotel_program_manager = new db_hotel_program_manager();
					
				$list_program_manager = $db_hotel_program_manager->admin_get_list($this->g_cgival["p"], 1);
					
				$hotel_program_manager_id = $list_program_manager[0]["id"];
				
				$list_program_info = $db_hotel_program_info->admin_get_list(1, 1, $program_num);
				
				if ($list_program_info == null) {
						
					$res = $db_hotel_program_info->admin_insert_hotel_program_info($program_channel_info, $hotel_program_manager_id, $program_version);
					if (!$res) {
						echo "<script>alert('数据库操作失败！');location.href='hotel_program_info_list.php';</script>";
						exit;
					}
					echo "<script>alert('操作成功');location.href='hotel_program_info_list.php';</script>";
					exit;
				} else {
					if ($list_program_info[0]["program_num"] == $program_num) {
						echo "<script>alert('节目号冲突！');location.href='hotel_program_info_list.php';</script>";
						exit;
					} else { // The program_num is 0
						$res = $db_hotel_program_info->admin_insert_hotel_program_info($program_channel_info, $hotel_program_manager_id, $program_version);
						if (!$res) {
							echo "<script>alert('数据库操作失败！');location.href='hotel_program_info_list.php';</script>";
							exit;
						}
						echo "<script>alert('操作成功');location.href='hotel_program_info_list.php';</script>";
						exit;
					}
					
				}
				
				
			}
			
		} elseif ($type == "del") {
			$res = $db_hotel_program_info->admin_del_hotel_program_info_by_id($id);
			if (!$res) {
				throw new Exception("数据库操作失败！");
			}
			
		}
	}
	
	function show_pro() {
		$file_type ="interface"; //or interface
		parent::show_pro($file_type);	
	}
	
	function check_version($version) {
		$version++;
		if ($version > 31) {
			$version = 0;
		}
		
		return $version;
	}
	
}

$prodect_main = new prodect_main();
$prodect_main->admin_check();//后台程序检查
$prodect_main->main_do();

?>