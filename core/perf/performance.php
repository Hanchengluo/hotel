<?php

/**
 * 程序运行时间输出 (性能低则入库)
 * @author yangchao
 *
 *
 * 查询所有性能差的程序，按次数倒排：
 * select id, sum(execute_time)/count(*) as avg_time, sum(sql_count)/count(*) as avg_sqlcount, php_file, uid, product_id, count(*) as cc from monitor_performance group by php_file order by cc desc;
 */

//定义程序执行时间大于PROGRAM_EXECUTE_TIME秒则入库 
define("PROGRAM_EXECUTE_TIME",1);

class performance
{

	/**
 	* 申明程序开始时间全局变量
 	*/
	static function global_program_start_time()	
	{
		global $program_execute_time_start;
		$program_execute_time_start = performance::microtime_float();
		
	}

	/**
	 * 申明程序执行时间全局变量
	 */
	static function _get_program_execute_time()
	{
		global $program_execute_time_start;
		
		$program_execute_time_end = performance::microtime_float();
		$program_execute_time = $program_execute_time_end-$program_execute_time_start;
		
		return $program_execute_time;
	}
	/**
	 * 取unix时间戳和微秒数
	 */
	static function microtime_float()
	{
	    list($usec, $sec) = explode(" ", microtime());
	    return ((float)$usec + (float)$sec);
	}
	
	/*
	 * 检查运行时间并入库
	 *  @param $time_need_big_than 大于$time_need_big_than运行时间的程序需要被记录
	 *  @return 返回运行时间
	 */
	static function check_execute_time_and_to_db($time_need_big_than)
	{
		global $config;
		
		$execute_time = performance::_get_program_execute_time();
		if($execute_time < $time_need_big_than) return $execute_time;
		
		$sql_count = db_base::perf_get_count();
		$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
		$url = substr($url,0,200);
		$php_file = $_SERVER['PHP_SELF'];
		$site_id = "";//$config["current_site_id"];
		$product_id = "";//$config["current_product_id"];
		$create_ip =  IP::get_client_ip_long();
		
		try {
			$user_info = new user_info();
			$uid = @$user_info->get_cur_uid();
			
		} 
		catch (Exception $e) 
		{
			//$error_message = $e->getMessage();
		}
		/*
		//如果是个人中心产品直接操作数据库
		if($config["current_product_id"] == 100)
		{	
			$ret  = db_performanace::_insert_performance($execute_time,$sql_count,$php_file,$url,$site_id,$product_id,$create_ip,$uid);
		}
*/
		
		return $execute_time;
		
	}
	
}
?>