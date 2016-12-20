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
	
	cgi::both($g_cgival["gid"], "gid", 0);
	cgi::both($g_cgival["group_title"], "group_title", "");
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show;
	
	if ($g_cgival["gid"])
	{
		$d = new db_admin_group();
		if (!$d->update_group($g_cgival["gid"], $g_cgival["group_title"]))
		{
			throw new Exception("更新失败，请重试！");
		}
	}
	else
	{
		$d = new db_admin_group();
		if (!$d->insert_group($g_cgival["group_title"]))
		{
			throw new Exception("更新失败，请重试！");
		}
	}
}

try
{
	admin_check_login();
	admin_check_user_priv("admin_group_edit.php");
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