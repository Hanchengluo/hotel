<?php

/*
 * group hotel_customer_info
 * @author osbornyang
 * @package group
 * @copyright osbornyang
 * @version 1.2
 * @code-encode utf-8
 * @data-encode utf-8
*/

/*
 * create table tbl_hotel_customer_info (id int unsigned primary key auto_increment, cus_roomnum varchar(30) not null, cus_name char(30) not null, cus_sex varchar(20) not null, create_time TIMESTAMP NULL DEFAULT now());
 */

class db_hotel_customer_info extends db_base {
	
	var $tbl_name = "tbl_hotel_customer_info";

	function db_hotel_customer_info() {
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
	
	function admin_get_list($p = 1, $pcount = 20, $cus_roomnum) {
		
		if (strlen($cus_roomnum) > 0) {
			$where = "cus_roomnum like '%{$cus_roomnum}%'";
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
