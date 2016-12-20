<?php
/**
 * 管理员日志操作 DB层
 * @author huqq

 * @package user
 * @copyright huqq
 * @version 1.0
 * @code-encode utf-8
 * @data-encode utf-8
 */

if (isset($_GET["test_db"]))
{
	include_once($_SERVER["DOCUMENT_ROOT"] . "/config/global_config.php");
	include_once($_SERVER["DOCUMENT_ROOT"] . "/config/db_config.php");
	include_once($_SERVER["DOCUMENT_ROOT"] . "/config/user_config.php");
	include_once($_SERVER["DOCUMENT_ROOT"] . "/include/base.class.php");
	include_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");
	include_once($_SERVER["DOCUMENT_ROOT"] . "/include/mem_cache.class.php");
}

class db_admin_log extends db_base {
    
	var $table_name = "admin_log";
	
	function db_admin_log()
	{
		parent::db_base();
	}
	
	/**
	 * 后台管理员日志，分页获取日志列表
	 * @param $site_id
	 * @param $p
	 * @param $pcount
	 */
	function admin_get_log_list($site_id, $p, $pcount)
	{
		$where = "";
		if ($site_id && $site_id != 900)
		{
			$where .= "site_id={$site_id}";
		}
		$result = $this->get_alllist($this->table_name, $p, $pcount, "create_time desc", $where);
		
		return $result;
	}
	
	/**
	 * 后台管理员日志查询，获取符合站点权限的记录总数
	 * @param $site_id
	 */
	function admin_get_log_total_num($site_id)
	{
		$where = "";
		if ($site_id && $site_id != 900)
		{
			$where .= "site_id={$site_id}";
		}
		$result = $this->get_alllist($this->table_name, "", "", "create_time desc", $where);
		
		return count($result);		
	}
	
	/**
	 * 通过登录用户的站点id，分页获取符合搜索条件的日志列表
	 * @param $site_id
	 * @param $se_uid
	 * @param $se_op_type
	 * @param $se_time_start
	 * @param $se_time_end
	 * @param $p
	 * @param $pcount
	 */
	function admin_get_log_list_by_key($site_id, $se_username, $se_op_type, $se_time_start, $se_time_end, $p, $pcount)
	{
		$where_arr = array();
				
		if (!empty($se_username))
		{
			$where_arr[] = " admin_username='{$se_username}'";
		}
		
		if ($se_op_type != "")
		{
			$where_arr[] = " op_type={$se_op_type}";
		}
		
		if (empty($se_time_start)) 
		{
			$se_time_start = "1970-01-01 00:00:00";
		}
		if (empty($se_time_end))
		{
			$where_arr[] = " create_time>='{$se_time_start}'";
		}
		elseif (!empty($se_time_end))
		{
			$where_arr[] = " create_time>='{$se_time_start}' and create_time<='{$se_time_end}'";
		}
	
		if ($site_id && $site_id != 900)
		{
			$where_arr[] = " site_id={$site_id}";
		}
		
		$where_arr[] = " status=1";
		$where = implode(" AND ", $where_arr);
		
		$result = $this->get_alllist($this->table_name, $p, $pcount, "create_time desc", $where);

		return $result;
	}
	
	/**
	 * 通过登录用户的站点id，获取符合条件的记录总数
	 * @param $site_id
	 * @param $se_uid
	 * @param $se_op_type
	 * @param $se_time_start
	 * @param $se_time_end
	 */
	function admin_get_log_total_num_by_key($site_id, $se_username, $se_op_type, $se_time_start, $se_time_end)
	{
		$where_arr = array();
		
		if (!empty($se_username))
		{
			$where_arr[] = " admin_username='{$se_username}'";
		}
		
		if ($se_op_type != "")
		{
			$where_arr[] = " op_type={$se_op_type}";
		}
		
		if (empty($se_time_start)) 
		{
			$se_time_start = "1970-01-01 00:00:00";
		}
		if (empty($se_time_end))
		{
			$where_arr[] = " create_time>='{$se_time_start}'";
		}
		elseif (!empty($se_time_end))
		{
			$where_arr[] = " create_time>='{$se_time_start}' and create_time<='{$se_time_end}'";
		}
		
		if ($site_id && $site_id != 900)
		{
			$where_arr[] = " site_id={$site_id}";
		}
		
		$where_arr[] = " status=1";
		$where = implode(" AND ", $where_arr);
		
		$result = $this->get_alllist($this->table_name, "", "", "", $where);

		return count($result);
	}
	
	/**
	 * 在每个程序文件中调用的接口函数，用于对日常行为操作进行日志保存
	 * @param $current_uid	//当前操作的用户uid
	 * @param $current_username	//当前操作的用户名
	 * @param $site_id	//当前操作用户所属的站点id
	 * @param $op_type	操作的类型
	 * @param $op_content	操作的行为说明
	 */
	function admin_insert_log_info($current_uid, $current_username, $site_id, $op_type="", $op_content="", $status=DB_STATUS_OK)
	{			
		if (strlen($site_id) == 0)
		{
			global $config;
			$site_id = $config["current_site_id"];
		}
		
		$insert_data["admin_uid"] = $current_uid;
		$insert_data["admin_username"] = $current_username;
		$insert_data["site_id"] = $site_id;
		$insert_data["op_type"] = $op_type;
		$insert_data["op_content"] = $op_content;
		
		$insert_data["create_time"] = Date::get_date_time();
		$insert_data["create_ip"] = ip2long(IP::get_client_ip());
		$insert_data["create_uid"] = $current_uid;
		$insert_data["update_time"] = Date::get_date_time();
		$insert_data["update_ip"] = ip2long(IP::get_client_ip());
		$insert_data["update_uid"] = $current_uid;
		$insert_data["status"] = $status;

		$result = $this->insert($this->table_name, $insert_data);
		if ($result)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
}
?>