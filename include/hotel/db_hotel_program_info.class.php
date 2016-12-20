<?php

/*
 * group hotel_program_info
 * @author osbornyang
 * @package group
 * @copyright osbornyang
 * @version 1.2
 * @code-encode utf-8
 * @data-encode utf-8
*/

/*
 * create table tbl_hotel_program_info (id int unsigned primary key auto_increment, program_name text default null, program_num int unsigned, program_url text default null, hotel_program_manager_id int unsigned, version int unsigned, playing_state varchar(10) DEFAULT NULL, create_time TIMESTAMP NULL DEFAULT now(), KEY idx_fk_hotel_program (hotel_program_manager_id), CONSTRAINT fk_hotel_program FOREIGN KEY (hotel_program_manager_id) REFERENCES tbl_hotel_program_manager (id) ON DELETE CASCADE ON UPDATE CASCADE);
 */

class db_hotel_program_info extends db_base {
	
	var $tbl_name = "tbl_hotel_program_info";

	function tbl_hotel_program_info() {
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
	function admin_update_hotel_program_info_by_id($id, $program_channel_info, $program_manager_id, $version) {
		global $config;

		//检查字段
		$id = intval($id);
		if (!$id) throw new Exception("DB:id有错误！");
		//如果id是字符串，并且在where条件中使用 ：$id = string::esc_mysql($id);
		
		//详细字段
		$ary = array();
		$ary["program_name"] = $program_channel_info[0]["name"];
		$ary["program_num"] = $program_channel_info[0]["program_num"];
		$ary["program_url"] = $program_channel_info[0]["url"];
		$ary["playing_state"] = $program_channel_info[0]["playing_state"];
		$ary["hotel_program_manager_id"] = $program_manager_id;
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
	function admin_insert_hotel_program_info($program_channel_info, $program_manager_id, $version) {
		global $config;
		
		for ($i = 0; $i < count($program_channel_info); $i++) {
			//详细字段
			$ary = array();
			$ary["program_name"] = $program_channel_info[$i]["name"];
			$ary["program_num"] = $program_channel_info[$i]["program_num"];
			$ary["program_url"] = $program_channel_info[$i]["url"];
			$ary["playing_state"] = $program_channel_info[$i]["playing_state"];
			$ary["hotel_program_manager_id"] = $program_manager_id;
			
			$ary["version"] = $version;
			
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
	function admin_del_hotel_program_info_by_id($id) {
		global $config;
	
		//检查字段
		$id = intval($id);
		if (!$id) throw new Exception("DB:id有错误！");

		$where = " id = $id ";
		$ret = $this->delete($this->tbl_name, $where);
		
		return $ret;
	}
	
	function admin_get_list($p = 1, $pcount = 20, $program_num = "") { 
		
		if ($program_num) {
			$where = "program_num = $program_num";
		}
		
		//验证传入参数
		$data = $this->get_alllist($this->tbl_name, $p, $pcount, "program_num asc", $where);
		
		return $data;
	}
	
	function admin_get_hotel_program_info_by_id($id) {
	
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
