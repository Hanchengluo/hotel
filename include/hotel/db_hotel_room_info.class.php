<?php

/*
 * group hotel_room_info
 * @author osbornyang
 * @package group
 * @copyright osbornyang
 * @version 1.2
 * @code-encode utf-8
 * @data-encode utf-8
*/

/*
 * create table tbl_hotel_room_info (id int unsigned primary key auto_increment, room_num int unsigned, room_mac text default null, hotel_room_manager_id int unsigned, create_time TIMESTAMP NULL DEFAULT now(), KEY idx_fk_hotel_room (hotel_room_manager_id), CONSTRAINT fk_hotel_room FOREIGN KEY (hotel_room_manager_id) REFERENCES tbl_hotel_room_manager (id) ON DELETE CASCADE ON UPDATE CASCADE);
 */

class db_hotel_room_info extends db_base {
	
	var $tbl_name = "tbl_hotel_room_info";

	function tbl_hotel_room_info() {
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
	function admin_update_hotel_room_info_by_id($id, $room_num, $room_mac, $room_manager_id) {
		global $config;

		//检查字段
		$id = intval($id);
		if (!$id) throw new Exception("DB:id有错误！");
		//如果id是字符串，并且在where条件中使用 ：$id = string::esc_mysql($id);
		
		//详细字段
		$ary = array();
		$ary["room_num"] = $room_num;
		$ary["room_mac"] = $room_mac;
		$ary["hotel_room_manager_id"] = $room_manager_id;
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
	function admin_insert_hotel_room_info($room_info, $room_manager_id, $flag = true) {
		global $config;
		
		// Keep only one group related recode in the database
		if ($flag) {
			$this->delete($this->tbl_name, "id > 0");
		}

		for ($i = 0; $i < count($room_info); $i++) {
			//详细字段
			$ary = array();
			$ary["room_num"] = $room_info[$i]["room_num"];
			$ary["room_mac"] = $room_info[$i]["room_mac"];
			$ary["hotel_room_manager_id"] = $room_manager_id;
			
			$ary["create_time"] = Date::get_date_time();
			$ret = $this->insert($this->tbl_name, $ary);
			if ($ret) {
				$memcache = mem_cache::get_instance();
				$key[] = "need to delete";
				$memcache->delete_ary($key);
			}
		}

		return $this->get_lastinsertid();
	}
	
	// 删除一条数据
	function admin_del_hotel_room_info_by_id($id) {
		global $config;
	
		//检查字段
		$id = intval($id);
		if (!$id) throw new Exception("DB:id有错误！");

		$where = " id = $id ";
		$ret = $this->delete($this->tbl_name, $where);
		
		return $ret;
	}
	
	function admin_get_list_by_mac($p = 1, $pcount = 20, $room_mac = "") {  
		
		if (strlen($room_mac) > 0) {
			$where = "room_mac like '%$room_mac%'";
		}
		
		//验证传入参数
		$data = $this->get_alllist($this->tbl_name, $p, $pcount, "id desc", $where);
		
		return $data;
	}
	
	function admin_get_list($p = 1, $pcount = 20, $room_num = "") {
	
		if (strlen($room_num) > 0) {
			$where = "room_num = $room_num";
		}
	
		//验证传入参数
		$data = $this->get_alllist($this->tbl_name, $p, $pcount, "id desc", $where);
	
		return $data;
	}
	
	function admin_get_count() {       

		//验证传入参数
		$data = $this->get_listcount($this->tbl_name);
		
		return $data;
	}	
	
}

?>
