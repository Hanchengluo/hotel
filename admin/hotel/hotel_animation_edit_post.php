<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
		cgi::both($this->g_cgival["id"], "id", 0);
		
		cgi::both($this->g_cgival["url"], "url", "");
		$this->g_cgival["url"] = string::un_html($this->g_cgival["url"]);

		cgi::both($this->g_cgival["type"], "type", "add");
	}
	
	function get_data() {
		
		$id = $this->g_cgival["id"];
		$url = $this->g_cgival["url"];
		
		$type = $this->g_cgival["type"];

		$db_hotel_animation = new db_hotel_animation();
		
		if ($type== "add") {

			if ($id) {
				$list = $db_hotel_animation->admin_get_item_by_id($id);
				$version = $this->check_version($list["version"]);
				
				$res = $db_hotel_animation->
					admin_update_hotel_animation_by_id($id, $url, $version);
				
				if (!$res) {
					echo "<script>alert('数据库操作失败！');location.href='hotel_animation_list.php';</script>";
					exit;
				}
				
				echo "<script>alert('操作成功');location.href='hotel_animation_list.php';</script>";
				
				exit;
			} else {
				
				$list = $db_hotel_animation->admin_get_list(1, -1);
				
				if ($list != null) {
					foreach ($list as $hotel_animation_key => $hotel_animation_value) {
						$db_id = $hotel_animation_value["id"];
						$version = $this->check_version($hotel_animation_value["version"]);
						break;
					}
					
					$data = $db_hotel_animation->admin_get_animation_video_by_id($db_id);
					if (!$data) {
						throw new Exception("数据库操作失败！");
						exit;
					}
						
					$tmp_url = substr($data[0]['url'], 0, 13);
					$this->deldir('../..' . $tmp_url);
					
					$db_hotel_animation->admin_del_hotel_animation_by_id($db_id);
					
				} else {
					$version = 0;
				}
				
				$res = $db_hotel_animation->admin_insert_hotel_animation($url, $version);
				
				if (!$res) {
					echo "<script>alert('数据库操作失败！');location.href='hotel_animation_list.php';</script>";
					exit;
				}
				
				echo "<script>alert('操作成功');location.href='hotel_animation_list.php';</script>";
				
				exit;
			}
			
		} elseif ($type == "del") {
			
			$data = $db_hotel_animation->admin_get_animation_video_by_id($id);
			if (!$data) {
				throw new Exception("数据库操作失败！");
				exit;
			}
				
			$tmp_url = substr($data[0]['url'], 0, 13);
			$this->deldir('../..' . $tmp_url);
			
			$res = $db_hotel_animation->admin_del_hotel_animation_by_id($id);
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