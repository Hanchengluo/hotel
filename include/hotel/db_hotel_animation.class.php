<?php

/*
 * group hotel_animation
 * @author osbornyang
 * @package group
 * @copyright osbornyang
 * @version 1.2
 * @code-encode utf-8
 * @data-encode utf-8
*/

/*
 * create table tbl_hotel_animation (id int unsigned primary key auto_increment, version int unsigned default 0, url varchar(255) DEFAULT NULL, create_time TIMESTAMP NULL DEFAULT now());
 */

class db_hotel_animation extends db_base {
	
	var $tbl_name = "tbl_hotel_animation";

	function db_hotel_animation() {
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
	function admin_update_hotel_animation_by_id($id, $url, $version) {
		global $config;
		
		//检查字段
		$id = intval($id);
		
		if (!$id) throw new Exception("DB:id有错误！");
		//如果id是字符串，并且在where条件中使用 ：$id = string::esc_mysql($id);
		
		//详细字段
		$ary = array();
		$ary["url"] = $url;
		$ary["version"] = $version;
		
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
	function admin_insert_hotel_animation($url, $version) {
		global $config;
		
		$ary = array();
		$ary["url"] = $url;
		$ary["version"] = $version;

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
	function admin_del_hotel_animation_by_id($id) {
		global $config;
	
		//检查字段
		$id = intval($id);
		if (!$id) throw new Exception("DB:id有错误！");

		$where = " id = $id ";
		$ret = $this->delete($this->tbl_name, $where);
		
		return $ret;
	}
	
	function admin_get_list($p = 1, $pcount = 20) {
		
		//验证传入参数
		$data = $this->get_alllist($this->tbl_name, $p, $pcount, "id asc");
		
		return $data;
	}
	
	function admin_get_animation_video_by_id($id) {
	
		$db_base = new db_base();
		$sql = "select * from " . $this->tbl_name . " where id = " . $id;
		$data = $db_base->mix_query($sql);
		return $data;
	}
	
	function admin_get_count() {       

		//验证传入参数
		$data = $this->get_listcount($this->tbl_name);
		
		return $data;
	}	
	
}

?>
