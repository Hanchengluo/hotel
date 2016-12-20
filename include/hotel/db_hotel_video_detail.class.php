<?php

/*
 * group hotel_video_detail
 * @author osbornyang
 * @package group
 * @copyright osbornyang
 * @version 1.2
 * @code-encode utf-8
 * @data-encode utf-8
*/

/*
 * create table tbl_hotel_video_detail (id int unsigned primary key auto_increment, video_category_id int unsigned, video_name text default null, video_thumbnail_address text default null, video_introduction text default null, video_url text default null, video_price_single double default 0, video_rating int unsigned default 0, video_area text default null, video_online_time text default null, video_duration text default null, video_director text default null, video_star text default null, video_price_one_day double default 0, create_time TIMESTAMP NULL DEFAULT now(), KEY idx_fk_detail_category (video_category_id), CONSTRAINT fk_detail_category FOREIGN KEY (video_category_id) REFERENCES tbl_hotel_video_category (id) ON DELETE CASCADE ON UPDATE CASCADE);
 */

class db_hotel_video_detail extends db_base {
	
	var $tbl_name = "tbl_hotel_video_detail";

	function db_hotel_video_detail() {
		parent::db_base();
	}

	/**
	 * 后台取单个数据
	 * @param int id
	 */
	function admin_get_item_by_id($id) {       
		//验证传入参数
		$id = intval($id);
		if (!$id) throw new Exception("DB:id错误！");
		//如果$id是字符串，并且在where条件中使用 ：$id = string::esc_mysql($id);
		
		//处理where条件
		$where = " id = {$id} ";	
		$data = $this->get_alllist($this->tbl_name, 1, 1, "", $where);
		
		return $data[0];
	}	
	
	//修改一条数据
	function admin_update_hotel_video_detail_by_id($id, $video_details) {
		global $config;

		//检查字段
		$id = intval($id);
		if (!$id) throw new Exception("DB:id有错误！");
		//如果id是字符串，并且在where条件中使用 ：$id = string::esc_mysql($id);
		
		//详细字段
		$ary = array();
		$ary["video_category_id"] = $video_details["video_category_id"];
		$ary["video_name"] = $video_details["video_name"];
		$ary["video_thumbnail_address"] = $video_details["video_thumbnail_address"];
		$ary["video_introduction"] = $video_details["video_introduction"];
		$ary["video_url"] = $video_details["video_url"];
		$ary["video_price_single"] = $video_details["video_price_single"];
		$ary["video_rating"] = $video_details["video_rating"];
		$ary["video_area"] = $video_details["video_area"];
		$ary["video_online_time"] = $video_details["video_online_time"];
		$ary["video_duration"] = $video_details["video_duration"];
		$ary["video_director"] = $video_details["video_director"];
		$ary["video_star"] = $video_details["video_star"];
		$ary["video_price_one_day"] = $video_details["video_price_one_day"];
		
		$ary["create_time"] = Date::get_date_time();
		
		$where = " id = $id ";
		$ret = $this->update($this->tbl_name, $ary, $where);
		if ($ret) {
			$memcache = mem_cache::get_instance();
			$key[] = "need to delete";
			$memcache->delete_ary($key);
		} else {
			return false;
		}

		return $ret;
	}
	//添加一条数据
	function admin_insert_hotel_video_detail($video_details) {
		global $config;
		//详细字段
		$ary = array();
		$ary["video_category_id"] = $video_details["video_category_id"];
		$ary["video_name"] = $video_details["video_name"];
		$ary["video_thumbnail_address"] = $video_details["video_thumbnail_address"];
		$ary["video_introduction"] = $video_details["video_introduction"];
		$ary["video_url"] = $video_details["video_url"];
		$ary["video_price_single"] = $video_details["video_price_single"];
		$ary["video_rating"] = $video_details["video_rating"];
		$ary["video_area"] = $video_details["video_area"];
		$ary["video_online_time"] = $video_details["video_online_time"];
		$ary["video_duration"] = $video_details["video_duration"];
		$ary["video_director"] = $video_details["video_director"];
		$ary["video_star"] = $video_details["video_star"];
		$ary["video_price_one_day"] = $video_details["video_price_one_day"];
		
		$ary["create_time"] = Date::get_date_time();
		
		$ret = $this->insert($this->tbl_name, $ary);
		if ($ret) {
			$memcache = mem_cache::get_instance();
			$key[] = "need to delete";
			$memcache->delete_ary($key);
		} else {
			return false;
		}

		return $this->get_lastinsertid();
	}
	
	// 删除一条数据
	function admin_del_hotel_video_detail_by_id($id) {
		global $config;
	
		//检查字段
		$id = intval($id);
		if (!$id) throw new Exception("DB:id有错误！");

		$where = " id = $id ";
		$ret = $this->delete($this->tbl_name, $where);
		
		return $ret;
	}
	
	function admin_get_list($p = 1, $pcount = 20, $video_category_id = "") {     
		if ($video_category_id) {
			$where = "video_category_id = $video_category_id";
		}
		  
		//验证传入参数
		$data = $this->get_alllist($this->tbl_name, $p, $pcount, "id desc", $where);
		
		return $data;
	}	
	
	function admin_get_count($video_category_id = "") {       
		if ($video_category_id) {
			$where = "video_category_id = $video_category_id";
		}
		
		//验证传入参数
		$data = $this->get_listcount($this->tbl_name, $where);
		
		return $data;
	}	
	
}

?>
