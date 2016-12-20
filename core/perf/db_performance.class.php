<?php

class db_performanace 
{
	private static $tbl_name = "monitor_performance";
	
	/**
	 * 数据入库
	 */
	static function api_insert_performance($execute_time,$sql_count,$php_file,$url,$site_id,$product_id,$create_ip,$uid="")
	{
		
		global $config;
		// 插入数据
		$ary = array();
		$ary["execute_time"] = $execute_time;
		$ary["sql_count"] = $sql_count;
		$ary["php_file"] = $php_file;
		$ary["url"] = $url;
		$ary["uid"] = $uid;
		$ary["product_id"] = $product_id;
		$ary["site_id"] = $site_id;
		$ary["create_time"] = Date::get_date_time();
		$ary["create_ip"] = $create_ip;
		$ary["status"] = 1;
		
		$db_base = new db_base();
		$ret = $db_base->insert(performance::$tbl_name, $ary);
		
		if($ret)
		{
			return $ret;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 数据入库
	 */
	static function _insert_performance($execute_time,$sql_count,$php_file,$url,$site_id,$product_id,$create_ip,$uid="")
	{
		global $config;
		
		
		// 插入数据
		$ary = array();
		$ary["execute_time"] = $execute_time;
		$ary["sql_count"] = $sql_count;
		$ary["php_file"] = $php_file;
		$ary["url"] = $url;
		$ary["uid"] = $uid;
		$ary["product_id"] = $product_id;
		$ary["site_id"] = $site_id;
		$ary["create_time"] = Date::get_date_time();
		$ary["create_ip"] = $create_ip;
		$ary["status"] = 1;
		
		$db_base = new db_base();
		$ret = $db_base->insert(db_performanace::$tbl_name, $ary);
		
		if($ret)
		{
			return $ret;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 读取列表
	 */
	static function get_performance()
	{
		$db_base = new db_base();
		$data = $db_base->select("select id,sum(execute_time)/count(*) as avg_time,sum(sql_count)/count(*) as avg_sqlcount,php_file,uid,product_id,count(*) as cc from monitor_performance group by php_file order by cc desc");
		
		
		if ($data)
		{
			return $data;
		}
		else
		{
			return false;
		}		
	}
	
	/**
	 * 读取详情
	 */
	static function get_performance_detail($php_file, $p=1, $pcount=10)
	{
		$where_arr = array();
		
		if ($php_file)
		{
			$php_file = mysql_escape_string($php_file);
			$where_arr[] = " php_file='{$php_file}'";
		}
		
		$where_arr[] = " status=1";
		
		$where = implode(" AND ", $where_arr);
		$order = "create_time desc";
		
		$db_base = new db_base();
		$data = $db_base->get_alllist(performance::$tbl_name, $p, $pcount, $order, $where);
		
		return $data;
	}
	
	/**
	 * 读取详情总数
	 */
	static function get_performance_detail_count($php_file)
	{
		$where_arr = array();
		
		if ($php_file)
		{
			$php_file = mysql_escape_string($php_file);
			$where_arr[] = " php_file='{$php_file}'";
		}
		
		$where_arr[] = " status=1";
		
		$where = implode(" AND ", $where_arr);
		
		$db_base = new db_base();
		$data = $db_base->get_listcount(performance::$tbl_name, $where);
		
		return $data;	
	}
	
}

?>