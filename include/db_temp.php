<?php

/*
 * group temp_example 
 * @author yangchao
 * @package group
 * @copyright yangchao
 * @version 1.2
 * @code-encode utf-8
 * @data-encode utf-8
*/

if (isset($_GET["test_db"]))
{
	include_once($_SERVER["DOCUMENT_ROOT"] . "/core/inc.php");
}

class db_temp_example extends db_base
{
	var $tbl_name = "temp_example";

	function db_temp_example()
	{
		parent::db_base();
	}

//前台程序开始	
	/**
	 * 前台显示单个数据
	 * @param int primary_id
	 */
	function get_item_by_primary_id($primary_id)
	{       
		//验证传入参数
		$primary_id = intval($primary_id);
		if(!$primary_id) throw new Exception("DB:primary_id错误！");
		//如果primary_id是字符串，并且在where条件中使用 ：$primary_id = string::esc_mysql($primary_id);
			 
		$data = false;
		$key = "cache 前缀 未定" . "-get_item_by_primary_id-{$primary_id}";
		$mc = mem_cache::get_instance();
		$cache = $mc->get($key);
		if ($cache === false)
		{
			//处理where条件
			$where = " primary_id = {$primary_id} and status = 1 " ;	
			$data = $this->get_alllist($this->tbl_name, 1, 1, "",$where);
			$mc->set($key, serialize($data), 0, "cachetime未定");
		}
		else
		{
			$data = unserialize($cache);
		}

		return $data[0];
	}	
	
		
	//添加一条数据
	function insert_temp_example(
		$need_replace_field_parameter
		
	)
	{
		global $config;
		//详细字段
		$ary = array();
		$need_replace_field_array;
		
		$ary["create_time"] = Date::get_date_time();
		$ary["create_ip"] = IP::get_client_ip_long();
		$ary["update_time"] = Date::get_date_time();
		$ary["update_ip"] = IP::get_client_ip_long();
		$ary["status"] = 1;
		
		$ret = $this->insert($this->tbl_name, $ary);
		if ($ret)
		{
			$memcache = mem_cache::get_instance();
			$key[] = "need to delete";
			$memcache->delete_ary($key);
		}
		else
		{
			return false;
		}

		return $this->get_lastinsertid();
	}

	
	//修改一条数据
	function update_temp_example_by_primary_id(
		$need_replace_field_parameter,
		$primary_id
		
	)
	{
		global $config;

		//检查字段
		$primary_id = intval($primary_id);
		if(!$primary_id) throw new Exception("DB:primary_id有错误！");
		//如果primary_id是字符串，并且在where条件中使用 ：$primary_id = string::esc_mysql($primary_id);
		
		//详细字段
		$ary = array();
		$need_replace_field_array;
		
		$ary["update_time"] = Date::get_date_time();
		$ary["update_ip"] = IP::get_client_ip_long();
	
		$where = " primary_id = $primary_id and status = 1";
		$ret = $this->update($this->tbl_name, $ary,$where);
		if ($ret)
		{
			$memcache = mem_cache::get_instance();
			$key[] = "need to delete";
			$memcache->delete_ary($key);
		}
		else
		{
			return false;
		}


		return $ret;
	}
//前台程序结束
	

	
//后台程序开始	
	/**
	 * 后台取单个数据
	 * @param int primary_id
	 */
	function admin_get_item_by_primary_id($primary_id)
	{       
		//验证传入参数
		$primary_id = intval($primary_id);
		if(!$primary_id) throw new Exception("DB:primary_id错误！");
		//如果$primary_id是字符串，并且在where条件中使用 ：$primary_id = string::esc_mysql($primary_id);
		
		//处理where条件
		$where = " primary_id = {$primary_id} and status = 1 " ;	
		$data = $this->get_alllist($this->tbl_name, 1, 1, "",$where);
		
		return $data[0];
	}	
	
}

?>
