<?php

/*
 * group ad_image
 * @author osbornyang
 * @package group
 * @copyright osbornyang
 * @version 1.2
 * @code-encode utf-8
 * @data-encode utf-8
*/

/*
 * create table tbl_hotel_cookbook_detail (id int unsigned primary key auto_increment, cookbook_category_id int unsigned, cookbook_name text default null, cookbook_thumbnail_address text default null, cookbook_introduction text default null, cookbook_price double default 0, create_time TIMESTAMP NULL DEFAULT now(), KEY idx_fk_cookbook_detail_category (cookbook_category_id), CONSTRAINT fk_cookbook_detail_category FOREIGN KEY (cookbook_category_id) REFERENCES tbl_hotel_cookbook_category (id) ON DELETE CASCADE ON UPDATE CASCADE);
 */

class db_hotel_cookbook_detail extends db_base {
	
	var $tbl_name = "tbl_hotel_cookbook_detail";

	function db_hotel_cookbook_detail() {
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
	function admin_update_hotel_cookbook_detail_by_id($id, $cookbook_category_id, $cookbook_name, 
			$cookbook_thumbnail_address, $cookbook_introduction, $cookbook_price) {
		global $config;

		//检查字段
		$id = intval($id);
		if (!$id) throw new Exception("DB:id有错误！");
		//如果id是字符串，并且在where条件中使用 ：$id = string::esc_mysql($id);
		
		//详细字段
		$ary = array();
		$ary["cookbook_category_id"] = $cookbook_category_id;
		$ary["cookbook_name"] = $cookbook_name;
		$ary["cookbook_thumbnail_address"] = $cookbook_thumbnail_address;
		$ary["cookbook_introduction"] = $cookbook_introduction;
		$ary["cookbook_price"] = $cookbook_price;
		
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
	function admin_insert_hotel_cookbook_detail($cookbook_category_id, $cookbook_name, 
			$cookbook_thumbnail_address, $cookbook_introduction, $cookbook_price) {
		global $config;
		//详细字段
		$ary = array();
		$ary["cookbook_category_id"] = $cookbook_category_id;
		$ary["cookbook_name"] = $cookbook_name;
		$ary["cookbook_thumbnail_address"] = $cookbook_thumbnail_address;
		$ary["cookbook_introduction"] = $cookbook_introduction;
		$ary["cookbook_price"] = $cookbook_price;
		
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
	function admin_del_hotel_cookbook_detail_by_id($id) {
		global $config;
	
		//检查字段
		$id = intval($id);
		if (!$id) throw new Exception("DB:id有错误！");

		$where = " id = $id ";
		$ret = $this->delete($this->tbl_name, $where);
		
		return $ret;
	}
	
	function admin_get_list($p = 1, $pcount = 20, $cookbook_category_id = "") {     
		if ($cookbook_category_id) {
			$where = "cookbook_category_id = $cookbook_category_id";
		}
		  
		//验证传入参数
		$data = $this->get_alllist($this->tbl_name, $p, $pcount, "id desc", $where);
		
		return $data;
	}	
	
	function admin_get_count($cookbook_category_id = "") {       
		if ($cookbook_category_id) {
			$where = "cookbook_category_id = $cookbook_category_id";
		}
		
		//验证传入参数
		$data = $this->get_listcount($this->tbl_name, $where);
		
		return $data;
	}	
	
}

?>
