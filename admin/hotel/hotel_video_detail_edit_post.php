<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

class prodect_main extends main {
	
	function check_cgi_pro() {	
		cgi::both($this->g_cgival["id"], "id", 0);
		
		cgi::both($this->g_cgival["video_category_id"], "video_category", 0);
		
		cgi::both($this->g_cgival["video_name"], "video_name", "");
		$this->g_cgival["video_name"] = string::un_html($this->g_cgival["video_name"]);
		
		cgi::both($this->g_cgival["video_thumbnail_address"], "video_thumbnail_address", "");
		$this->g_cgival["video_thumbnail_address"] = string::un_html($this->g_cgival["video_thumbnail_address"]);
		
		cgi::both($this->g_cgival["video_introduction"], "video_introduction", "");
		$this->g_cgival["video_introduction"] = string::un_html($this->g_cgival["video_introduction"]);
		
		cgi::both($this->g_cgival["video_url"], "video_url", "");
		$this->g_cgival["video_url"] = string::un_html($this->g_cgival["video_url"]);
		
		cgi::both($this->g_cgival["video_price_single"], "video_price_single", "");
		$this->g_cgival["video_price_single"] = string::un_html($this->g_cgival["video_price_single"]);
		
		cgi::both($this->g_cgival["video_rating"], "video_rating", "");
		$this->g_cgival["video_rating"] = string::un_html($this->g_cgival["video_rating"]);
		
		cgi::both($this->g_cgival["video_area"], "video_area", "");
		$this->g_cgival["video_area"] = string::un_html($this->g_cgival["video_area"]);
		
		cgi::both($this->g_cgival["video_online_time"], "video_online_time", "");
		$this->g_cgival["video_online_time"] = string::un_html($this->g_cgival["video_online_time"]);
		
		cgi::both($this->g_cgival["video_duration"], "video_duration", "");
		$this->g_cgival["video_duration"] = string::un_html($this->g_cgival["video_duration"]);
		
		cgi::both($this->g_cgival["video_director"], "video_director", "");
		$this->g_cgival["video_director"] = string::un_html($this->g_cgival["video_director"]);
		
		cgi::both($this->g_cgival["video_star"], "video_star", "");
		$this->g_cgival["video_star"] = string::un_html($this->g_cgival["video_star"]);
		
		cgi::both($this->g_cgival["video_price_one_day"], "video_price_one_day", "");
		$this->g_cgival["video_price_one_day"] = string::un_html($this->g_cgival["video_price_one_day"]);
		
		cgi::both($this->g_cgival["video_category_id_fetch"], "video_category_id", -1);
		
		cgi::both($this->g_cgival["type"], "type", "add");
	}
	
	function get_data() {
		
		$id = $this->g_cgival["id"];
		
		$video_details = array();
		
		$video_details["video_category_id"] = $this->g_cgival["video_category_id"];
		$video_details["video_name"] = $this->g_cgival["video_name"];
		$video_details["video_thumbnail_address"] = $this->g_cgival["video_thumbnail_address"];
		$video_details["video_introduction"] = $this->g_cgival["video_introduction"];
		$video_details["video_url"] = $this->g_cgival["video_url"];
		$video_details["video_price_single"] = $this->g_cgival["video_price_single"];
		$video_details["video_rating"] = $this->g_cgival["video_rating"];
		$video_details["video_area"] = $this->g_cgival["video_area"];
		$video_details["video_online_time"] = $this->g_cgival["video_online_time"];
		$video_details["video_duration"] = $this->g_cgival["video_duration"];
		$video_details["video_director"] = $this->g_cgival["video_director"];
		$video_details["video_star"] = $this->g_cgival["video_star"];
		$video_details["video_price_one_day"] = $this->g_cgival["video_price_one_day"];
		$type = $this->g_cgival["type"];
		$db_hotel_video_detail = new db_hotel_video_detail();
	
		if ($type== "add") {
			if ($id) {
			    
				$res = $db_hotel_video_detail->
					admin_update_hotel_video_detail_by_id($id, $video_details);
				
				if (!$res) {
					echo "<script>alert('数据库操作失败！');location.href='hotel_video_detail_list.php';</script>";
					exit;
				}
				
				echo "<script>alert('操作成功');location.href='hotel_video_detail_list.php';</script>";
				
				exit;
			} else {
				$res = $db_hotel_video_detail->admin_insert_hotel_video_detail($video_details);
				
				if (!$res) {
					echo "<script>alert('数据库操作失败！');location.href='hotel_video_detail_list.php';</script>";
					exit;
				}
				
				echo "<script>alert('操作成功');location.href='hotel_video_detail_list.php';</script>";
				exit;
			}
				
		} elseif ($type == "del") {
			$res = $db_hotel_video_detail->admin_del_hotel_video_detail_by_id($id);
			if (!$res) {
				throw new Exception("数据库操作失败！");
			}
		} elseif ($type == "fetch") {
			$video_category_id = $this->g_cgival["video_category_id_fetch"];
			
			$db_hotel_video_detail = new db_hotel_video_detail();
			$hotel_videl_detail_list = $db_hotel_video_detail->admin_get_list(1, 100);
			
			$video_info = array();
			foreach ($hotel_videl_detail_list as $hotel_videl_detail) {
				if ($ad_image["video_category_id"] == $video_category_id) {
					$tmp_video_detail_info = array();
					$tmp_video_detail_info["id"] = $hotel_videl_detail["id"];
					$tmp_video_detail_info["video_name"] = $hotel_videl_detail["video_name"];
					$tmp_video_detail_info["video_thumbnail_address"] = $hotel_videl_detail["video_thumbnail_address"];
					$tmp_video_detail_info["video_introduction"] = $hotel_videl_detail["video_introduction"];
					$tmp_video_detail_info["video_url"] = $hotel_videl_detail["video_url"];

					$video_info[] = $tmp_video_detail_info;
				}
			}
			
			echo json_encode($video_info);
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