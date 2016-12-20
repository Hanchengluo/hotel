<?php
//error_reporting(0);
include_once($_SERVER["DOCUMENT_ROOT"] . "/core/inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/core/admin.inc.php");




$g_cgival = array();
$g_pro = array();
$g_show = array();

function check_cgi_pro()
{
	global $g_cgival, $g_pro, $g_show;
	
	cgi::both($g_cgival["passwd"], "passwd", "");
	cgi::both($g_cgival["repasswd"], "repasswd", "");
	cgi::both($g_cgival["oldpasswd"], "oldpasswd", "");
	if($g_cgival["passwd"]!=$g_cgival["repasswd"])
	{
		throw new Exception("两次输入的新密码不一致！");
	}
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show;
	
	$user_id = admin::admin_get_login_uid();
	$user_name = admin::admin_get_login_user_name();

	$db_admin_user = new db_admin_user();
	$admin_user = $db_admin_user->get_user($user_name);

	if(md5($g_cgival["oldpasswd"])!=$admin_user[0]["user_passwd"])
	{
		throw new Exception("旧密码不正确！");
	}

	// 有必要才更新密码
	if (!$db_admin_user->update_user_passwd($user_id, $g_cgival["passwd"]))
	{
		throw new Exception("更新数据库时出错！update passwd");
	}

}


try
{
	admin_check_login();
	admin_check_user_priv("admin_user_changepwd.php");
	check_cgi_pro();
	get_data();
	
	$g_show["status"] = 0;
}
catch(Exception $e)
{
	$g_show["status"] = 1;
	$g_show["error"] = $e->getMessage();
}
show_pro();
exit;

function show_pro()
{
	global $g_cgival, $g_pro, $g_show;
	
	echo json_encode($g_show);
}
?>