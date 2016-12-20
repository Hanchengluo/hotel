<?php
/**
 * 管理员日志操作 业务层
 * @author huqq

 * @package user
 * @copyright huqq
 * @version 1.0
 * @code-encode utf-8
 * @data-encode utf-8
 */

class admin_log
{

	public function admin_log()
	{
		
	}
	
	/**
	 * 后台管理员日志查询，通过站点过滤，分页获取日志记录
	 * @param int $site_id	//当前登录用户的站点id
	 * @param int $p
	 * @param int $pcount
	 */
	public function admin_get_log_list($site_id, $p, $pcount)
	{
		$db_admin_log = new db_admin_log();
		return $db_admin_log->admin_get_log_list($site_id, $p, $pcount);
	}
	
	/**
	 * 后台管理员日志查询，获取符合站点权限的记录总数
	 * @param int $site_id
	 */
	public function admin_get_log_total_num($site_id=0)
	{
		$db_admin_log = new db_admin_log();
		return $db_admin_log->admin_get_log_total_num($site_id);
	}
	

	/**
	 * 通过登录用户的站点id，分页获取符合搜索条件的日志列表
	 * @param int $site_id
	 * @param int $se_uid
	 * @param int $se_op_type
	 * @param int $se_time_start
	 * @param int $se_time_end
	 * @param int $p
	 * @param int $pcount
	 */
	public function admin_get_log_list_by_key($site_id, $se_username="", $se_op_type="", $se_time_start="", $se_time_end="", $p, $pcount)
	{
		$db_admin_log = new db_admin_log();
		return $db_admin_log->admin_get_log_list_by_key($site_id, $se_username, $se_op_type, $se_time_start, $se_time_end, $p, $pcount);
	}
	
	/**
	 * 通过登录用户的站点id，获取符合条件的记录总数
	 * @param int $site_id
	 * @param int $se_uid
	 * @param int $se_op_type
	 * @param int $se_time_start
	 * @param int $se_time_end
	 */
	public function admin_get_log_total_num_by_key($site_id, $se_username="", $se_op_type="", $se_time_start="", $se_time_end="")
	{
		$db_admin_log = new db_admin_log();
		return $db_admin_log->admin_get_log_total_num_by_key($site_id, $se_username, $se_op_type, $se_time_start, $se_time_end);
	}
	
	/**
	 * 在每个程序文件中调用的接口函数，用于对日常行为操作进行日志保存
	 * @param int $current_uid
	 * @param int $site_id
	 * @param int $op_type
	 * @param int $op_content
	 */
	public function admin_insert_log_info($current_uid, $site_id, $op_type, $op_content)
	{
		$db_admin_log = new db_admin_log();
		$user_info = new db_admin_user();
		$user_global_config = user_global_config::get_instance();
		
		//通过当前用户的uid获取用户名
		$current_username = $user_info->admin_get_user_by_uid($current_uid);
		//通过op_type获取操作类型名称
		$op_type_name = $user_global_config->get_op_type_name_by_op_type($op_type);
		
		//完整的管理员操作说明		
		if ($op_type == 0)//登录操作记录
		{
			$op_content = $op_content . " 成功 " . $op_type_name;
		}
		/* elseif ($op_type > 0)
		{
			$op_content = $op_content . " 被 ". $current_username . " ". $op_type_name;
		} */
	
		$result = $db_admin_log->admin_insert_log_info($current_uid, $current_username, $site_id, $op_type, $op_content);
		
		return $result;
	}

}//end class admin_log

?>