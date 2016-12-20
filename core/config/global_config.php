<?php

$config["current_real_domain"] = $_SERVER["HTTP_HOST"];
define("COOKIE_DOMAIN", ".{$config["current_real_domain"]}");						// 配置cookie域名

if(!isset($_GET["show_error"]))
{
	error_reporting(E_ERROR);
}

// 初始化时区
date_default_timezone_set('Asia/Shanghai');

// 初始化程序开始执行时间
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function __autoload($class_name) 
{
	$class_info = explode("_",$class_name);
	if($class_info[0]=="db" )
	{
		include_once($_SERVER['DOCUMENT_ROOT'] ."/include/{$class_info[1]}/{$class_name}.class.php");
	}
	elseif($class_info[0] == "mod")
	{
		include_once($_SERVER['DOCUMENT_ROOT'] ."/include/mod/{$class_name}.class.php");
		
	}
}


$program_execute_time_start = microtime_float();
$program_qapi_call_time = 0;										// 调用微群API的耗时统计
$program_wapi_call_time = 0;											// 调用微博API的耗时统计
$program_sql_call_time = 0;

?>
