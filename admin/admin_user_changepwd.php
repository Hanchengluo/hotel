<?php
//error_reporting(0);
include_once($_SERVER["DOCUMENT_ROOT"] . "/core/inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/core/admin.inc.php");



$g_cgival = array();
$g_pro = array();
$g_show = array();

function check_cgi_pro()
{
}

function get_data()
{
	global $g_show;

	$g_show['user_name'] = admin::admin_get_login_user_name();
}


try
{
	admin_check_login();
	admin_check_user_priv("admin_user_changepwd.php");
	check_cgi_pro();
	get_data();
	$g_show["error"] = "0";
	$g_show["errmsg"] = "";			
}
catch(Exception $e)
{
	$g_show["error"] = "1";
	$g_show["errmsg"] = $e->getMessage();
}
show_pro();
exit;

function show_pro()
{
	global $g_cgival, $g_pro, $g_show;
	
	
	$smarty = p_get_smarty();
	$smarty->assign('g_show', $g_show);
	
	if (isset($_GET["debug"]))
	{
		print_r($smarty);
	}
		
	if ($g_show["error"] == "0")
	{
		$smarty->display("admin_admin_user_changpwd.html");
	}
	else
	{
		$smarty->display("admin_error.html");//指定错误页面
	}
		
	
}
?>