<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
		cgi::both($this->g_cgival["id"], "id", 0);

		cgi::both($this->g_cgival["room_num"], "room_num", "");
		$this->g_cgival["room_num"] = string::un_html($this->g_cgival["room_num"]);
		
		cgi::both($this->g_cgival["room_mac_1"], "room_mac_1", "");
		$this->g_cgival["room_mac_1"] = string::un_html($this->g_cgival["room_mac_1"]);
		
		cgi::both($this->g_cgival["room_mac_2"], "room_mac_2", "");
		$this->g_cgival["room_mac_2"] = string::un_html($this->g_cgival["room_mac_2"]);
		
		cgi::both($this->g_cgival["room_mac_3"], "room_mac_3", "");
		$this->g_cgival["room_mac_3"] = string::un_html($this->g_cgival["room_mac_3"]);
		
		cgi::both($this->g_cgival["room_mac_4"], "room_mac_4", "");
		$this->g_cgival["room_mac_4"] = string::un_html($this->g_cgival["room_mac_4"]);
		
		cgi::both($this->g_cgival["room_mac_5"], "room_mac_5", "");
		$this->g_cgival["room_mac_5"] = string::un_html($this->g_cgival["room_mac_5"]);
		
		cgi::both($this->g_cgival["room_mac_6"], "room_mac_6", "");
		$this->g_cgival["room_mac_6"] = string::un_html($this->g_cgival["room_mac_6"]);
		
		cgi::both($this->g_cgival["type"], "type", "add");
	}
	
	function get_data() {
		
		$id = $this->g_cgival["id"];
		$room_num = $this->g_cgival["room_num"];
		$room_mac_1 = $this->g_cgival["room_mac_1"];
		$room_mac_2 = $this->g_cgival["room_mac_2"];
		$room_mac_3 = $this->g_cgival["room_mac_3"];
		$room_mac_4 = $this->g_cgival["room_mac_4"];
		$room_mac_5 = $this->g_cgival["room_mac_5"];
		$room_mac_6 = $this->g_cgival["room_mac_6"];
		$room_mac = $room_mac_1 . ":" . $room_mac_2 . ":" . $room_mac_3 . ":" . $room_mac_4 . ":" . $room_mac_5 . ":" . $room_mac_6;

		$type = $this->g_cgival["type"];
		
		$db_hotel_room_info = new db_hotel_room_info();
		
		if ($type== "add") {

			if ($id) {

				/* if ($room_num_old != $room_num) {
					$list = $db_hotel_room_info->admin_get_list(1, -1, $room_num);
					
					if ($list == null) {
						$res = $db_hotel_room_info->admin_update_hotel_room_info_by_id($id, $room_num, $room_mac, $hotel_room_manager_id);
						if (!$res) {
							echo "<script>alert('数据库操作失败！');location.href='hotel_room_info_list.php';</script>";
							exit;
						}
					} else {

						$tmp_room_num = $room_num_old;//$list[0]['room_num'];
						$tmp_room_mac = $list[0]['room_mac'];
						
						$db_hotel_room_info->admin_update_hotel_room_info_by_id($list[0]['id'], $tmp_room_num, $tmp_room_mac, $hotel_room_manager_id);
						$db_hotel_room_info->admin_update_hotel_room_info_by_id($id, $room_num, $room_mac, $hotel_room_manager_id);
						echo "<script>alert('操作成功!房间号冲突,已交换！');location.href='hotel_room_info_list.php';</script>";
						exit;
					}
				} else {
					$res = $db_hotel_room_info->admin_update_hotel_room_info_by_id($id, $room_num, $room_mac, $hotel_room_manager_id);
					if (!$res) {
						echo "<script>alert('数据库操作失败！');location.href='hotel_room_info_list.php';</script>";
						exit;
					}
				}
				
				echo "<script>alert('操作成功');location.href='hotel_room_info_list.php';</script>";
				
				exit; */
			} else {
				
				$room_info = array();
				
				$tmp_info = array();
				$tmp_info["room_num"] = $room_num;
				$tmp_info["room_mac"] = $room_mac;
				$room_info[] = $tmp_info;
				
				$db_hotel_room_manager = new db_hotel_room_manager();
				
				$list_by_num = $db_hotel_room_info->admin_get_list(1, -1, $room_num);
				$list_by_mac = $db_hotel_room_info->admin_get_list_by_mac(1, -1, $room_mac);
				echo($list_by_mac[0]['room_mac']);

				$list_room_manager = $db_hotel_room_manager->admin_get_list($this->g_cgival["p"], 1);
					
				$hotel_room_manager_id = $list_room_manager[0]["id"];
				if ($list_by_num == null && $list_by_mac == null) {
					$res = $db_hotel_room_info->admin_insert_hotel_room_info($room_info, $hotel_room_manager_id, false);
					if (!$res) {
						echo "<script>alert('数据库操作失败！');location.href='hotel_room_info_list.php';</script>";
						exit;
					}
				} else {

					if ($list_by_num != null) {
						echo "<script>alert('数据库操作失败!房间号冲突！');location.href='hotel_room_info_list.php';</script>";
						exit;
					}
					
					if ($list_by_mac != null) {
						echo "<script>alert('数据库操作失败!mac地址冲突！');location.href='hotel_room_info_list.php';</script>";
						exit;
					}
					
					
				}
				
				echo "<script>alert('操作成功');location.href='hotel_room_info_list.php';</script>";
				
				exit;
			}
			
		} elseif ($type == "del") {
			$res = $db_hotel_room_info->admin_del_hotel_room_info_by_id($id);
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