<?php
/**
 * 查看表状态
 * 
 * @author junyang
 * @package user
 * @copyright junyang
 * @version 1.0
 * @code-encode utf-8
 * @data-encode utf-8
 */

//加载个人中心配置文件
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/inc.php");

$g_cgival = array();
$g_pro = array();
$g_show = array();

function check_cgi_pro()
{
	global $g_cgival, $g_pro, $g_show, $config;
	
	cgi::both($g_cgival["order"], "order", "");
	cgi::both($g_cgival["desc"], "desc", 1);
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show, $config;
	
	$db_base = new db_base();
	$sql =" show table status";
	$result = $db_base->select($sql);
	$search_array = array();
	foreach($result as $key => $value)
	{
		$length    =  doubleval($value['Data_length']) + doubleval($value['Index_length']);
		$result[$key]["length"] = $length;
		if($length >= 1048576)
		{
			$size = round($length/1048576,2)."M";
		}
		elseif($length >= 1024)
		{
			$size = round($length/1024,2)."K";
		}
		else
		{
			$size = "1.00K";
		}
		
		if($result[$key]["Index_length"] > 1048576)
		{
			$result[$key]["Index_length"] = round($result[$key]["Index_length"]/1048576,2)."M";
		}
		elseif($result[$key]["Index_length"] > 1024)
		{
			$result[$key]["Index_length"] = round($result[$key]["Index_length"]/1024,2)."K";
		}
		else
		{
			$result[$key]["Index_length"] = $result[$key]["Index_length"];
		}		
		
		if($result[$key]["Data_length"] > 1048576)
		{
			$result[$key]["Data_length"] = round($result[$key]["Data_length"]/1048576,2)."M";
		}
		elseif($result[$key]["Data_length"] > 1024)
		{
			$result[$key]["Data_length"] = round($result[$key]["Data_length"]/1024,2)."K";
		}
		else
		{
			$result[$key]["Data_length"] = $result[$key]["Data_length"];
		}			
		
		$result[$key]["table_size"] = $size;
		
		if($g_cgival["order"] == "row")
		{
			$search_array[] = $result[$key]["Rows"];
		}
		elseif($g_cgival["order"] == "size")
		{
			$search_array[] = $length;
		}
		elseif($g_cgival["order"] == "index_length")
		{
			$search_array[] = $result[$key]["Index_length"];
		}
		elseif($g_cgival["order"] == "data_length")
		{
			$search_array[] = $result[$key]["Data_length"];
		}				
		
	}
	
	if(count($search_array) > 0)
	{
	
		if($g_cgival["desc"] == 1)
		{
			array_multisort($search_array,SORT_DESC,$result );
		}
		else
		{
			array_multisort($search_array ,SORT_ASC,$result);
		}
	}
	
	
	$g_show["table_status_list"] = $result;
	
	
}

try 
{
	check_cgi_pro();
	get_data();	
	$g_show["error"] = "0";
	$g_show["errmsg"] = "";
} 
catch (Exception $e) 
{
	$g_show["error"] = "1";
	$g_show["errmsg"] = $e->getMessage();
}
show_pro();
exit;

function show_pro()
{
	global $g_cgival, $g_pro, $g_show, $config;
	
	$smarty = p_get_smarty();
	$smarty->assign("g_show", $g_show);
	
	if (isset($_GET["debug"]))
	{
		echo "<pre>";
		print_r($g_show);
	}
	
	if ($g_show["error"] == "0")
	{
		$smarty->display("admin_table_status.html");
	}
	else
	{
		$smarty->assign("errmsg", $g_show["errmsg"]);
		$smarty->display("error.html");	
	}
}

?>