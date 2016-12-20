<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/core/inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/core/admin.inc.php");

$g_cgival = array();
$g_pro = array();
$g_show = array();

function check_cgi_pro()
{
	global $g_cgival, $g_pro, $g_show, $config;
	
	if(! security_check::check_refer())
	{
		throw new Exception("来路不明");
	}

	cgi::both($g_cgival["username"], "username", "");
	if (isset($_POST["username"]) && trim($g_cgival["username"]) == "")
	{
		throw new exception("请输入用户名！");
	}
	cgi::both($g_cgival["passwd"], "passwd", "");
	if (isset($_POST["passwd"]) && trim($g_cgival["passwd"]) == "")
	{
		throw new exception("请输入密码！");
	}
	
	if (substr($g_cgival["username"], 0, 6) == "system")
	{
		throw new Exception("系统帐号不允许登录！请向管理申请帐号。。。");
	}
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show, $config;

	$admin = new admin();
	$admin_log = new admin_log();
    
	if ($admin->admin_login($g_cgival["username"], $g_cgival["passwd"]) == false)
	{
		throw new exception("用户名或密码错误！");
	}
	else
	{
		//当前登录用户的站点id
	    $g_pro["cur_user_site_id"] = admin::admin_get_user_site_id();  
		//初始化总站的站点id
		if ($g_pro["cur_user_site_id"] == $config["site"]["china"])
		{
			$g_pro["cur_user_site_id"] = 0;
		}
	    //当前登录用户的uid
	    $g_pro["current_uid"] = admin::admin_get_login_uid();
    
	 	$admin_log->admin_insert_log_info($g_pro["current_uid"], $g_pro["cur_user_site_id"], 0, "用户 {$g_cgival["username"]}登陆后台");
	
	}   

}

try
{
	$g_show["status"] = 1;
	$g_show["error"] = "";
	check_cgi_pro();
	get_data();
	$g_show["status"] = 0;
	$g_show["error"] = "登录成功！";	
}
catch(exception $e)
{
	$g_show["status"] = 1;
	$g_show["error"] = $e->getMessage();
}

echo json_encode($g_show);
?>