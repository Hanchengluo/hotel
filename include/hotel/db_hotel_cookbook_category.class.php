<?php

/*
 * group hotel_cookbook_category
 * @author osbornyang
 * @package group
 * @copyright osbornyang
 * @version 1.2
 * @code-encode utf-8
 * @data-encode utf-8
*/

/*
 * create table tbl_hotel_cookbook_category (id int unsigned primary key auto_increment, cookbook_category_name varchar(255) unique not null, create_time TIMESTAMP NULL DEFAULT now());
 */

class db_hotel_cookbook_category extends db_base {
	
	var $tbl_name = "tbl_hotel_cookbook_category";

	function db_hotel_cookbook_category() {
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
	function admin_update_hotel_cookbook_category_by_id($id, $cookbook_category_name="") {
		global $config;

		//检查字段
		$id = intval($id);
		if (!$id) throw new Exception("DB:id有错误！");
		//如果id是字符串，并且在where条件中使用 ：$id = string::esc_mysql($id);
		
		//详细字段
		$ary = array();
		if (strlen($cookbook_category_name)>0) {
			$ary["cookbook_category_name"] = $cookbook_category_name;
		}
		
		$ary["create_time"] = Date::get_date_time();
		
		$where = " id = $id";
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
	function admin_insert_hotel_cookbook_category($cookbook_category_name) {
		global $config;
		//详细字段
		$ary = array();
		$ary["cookbook_category_name"] = $cookbook_category_name;
		
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
	function admin_del_hotel_cookbook_category_by_id($id) {
		global $config;
	
		//检查字段
		$id = intval($id);
		if (!$id) throw new Exception("DB:id有错误！");

		$where = " id = $id";
		$ret = $this->delete($this->tbl_name, $where);
		
		return $ret;
	}
	
	function admin_get_list($p = 1, $pcount = 20, $cookbook_category_name = "") {       
		if (strlen($cookbook_category_name) > 0) {
			$where = "cookbook_category_name like '%{$cookbook_category_name}%'";
		}

		//验证传入参数
		$data = $this->get_alllist($this->tbl_name, $p, $pcount, "id desc", $where);
		
		return $data;
	}	
	
	function admin_get_count($cookbook_category_name = "") {       
		if (strlen($cookbook_category_name) > 0) {
			$where = "name like '%{$cookbook_category_name}%'";
		}
		
		//验证传入参数
		$data = $this->get_listcount($this->tbl_name, $where);
		
		return $data;
	}	
	
}

?>
