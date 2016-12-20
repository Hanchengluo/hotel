<?php
function p_get_smarty()
{
	global $config;	
	$obj = new Smarty();
	
// 性能监控
	//程序执行时间（执行时间超过1秒 则入库）
	$time_last = performance::check_execute_time_and_to_db(PROGRAM_EXECUTE_TIME);
	$obj->assign("execute_time_last", $time_last);
	
	$sql_count = db_base::perf_get_count();
	$obj->assign("execute_sql_count", $sql_count);
	
	$tpl = $_SERVER['DOCUMENT_ROOT']."/tpl/";
	
	if(stripos($_SERVER['PHP_SELF'],"/admin/") !== false)
	{
		$tpl = $_SERVER['DOCUMENT_ROOT']."/tpl/admin/";
	}
	
	$compile_dir = $_SERVER['DOCUMENT_ROOT']."/cache/compile_dir/";
	
	
/*	if (!file_exists($_SERVER['SINASRV_CACHE_DIR']."/smarty_compiles/"))
	{
		mkdir($_SERVER['SINASRV_CACHE_DIR']."/smarty_compiles/");
	}
	
	if (!file_exists($_SERVER['SINASRV_CACHE_DIR']."/smarty_compiles/$compile_pre/"))
	{
		mkdir($_SERVER['SINASRV_CACHE_DIR']."/smarty_compiles/$compile_pre/");
	}
	*/
	
// SMARTY 配置
	$smarty_con_arr = Array('template_dir' => $tpl,
						'compile_dir' => $compile_dir,
						'left_delimiter' => '{%',
						'right_delimiter' => '%}'
						);
	foreach ($smarty_con_arr as $key=>$value)
	{
		$obj->{$key} = $value;
	}
	$obj->assign("host_url", "http://{$_SERVER["SERVER_NAME"]}/");
	$obj->register_function('html_decode', "smarty_html_decode");
	
	
	
// 清除页面缓存
	@header('Expires: Thu, 01 Jan 1970 00:00:01 GMT');  
	@header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');  
	@header('Cache-Control: no-cache, must-revalidate, max-age=0');  
	@header('Pragma: no-cache');  


	return $obj;	
}
?>