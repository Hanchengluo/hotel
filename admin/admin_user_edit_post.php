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
	
	cgi::both($g_cgival["uid"], "uid", 0);
	cgi::both($g_cgival["user_name"], "user_name", "");
	cgi::both($g_cgival["user_passwd"], "user_passwd", "");
	cgi::both($g_cgival["site_id"], "site_id", "");
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show;
	
	if ($g_cgival["uid"] > 0)
	{
		$d = new db_admin_user();
		if (strlen($g_cgival["user_passwd"]) > 0)
		{
			// 有必要才更新密码
			if (!$d->update_user_passwd($g_cgival["uid"], $g_cgival["user_passwd"]))
			{
				throw new Exception("更新数据库时出错！update passwd");
			}
		}
		
		// 更新其它内容
		if(!$d->update_user($g_cgival["uid"], $g_cgival["user_name"], $g_cgival["site_id"]))
		{
			throw new Exception("更新数据库时出错！update content");
		}
	}
	else
	{
		$d = new db_admin_user();
		if (!$d->insert_user($g_cgival["user_name"], $g_cgival["user_passwd"], $g_cgival["site_id"]))
		{
			throw new Exception("添加用户时出错！");
		}
	}
}


try
{
	admin_check_login();
	admin_check_user_priv("admin_user_edit_post.php");
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