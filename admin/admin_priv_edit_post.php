<?php
error_reporting(0);
include_once($_SERVER["DOCUMENT_ROOT"] . "/core/inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/core/admin.inc.php");




$g_cgival = array();
$g_pro = array();
$g_show = array();


function check_cgi_pro()
{
	global $g_cgival, $g_pro, $g_show;
	
	cgi::both($g_cgival["pid"], "pid", 0);
	cgi::both($g_cgival["priv_name"], "priv_name", "");
	cgi::both($g_cgival["priv_link"], "priv_link", "");
	cgi::both($g_cgival["priv_order"], "priv_order", 0);
	cgi::both($g_cgival["is_show"], "is_show", 0);
	cgi::both($g_cgival["parent_name"], "parent_name", "");
	cgi::both($g_cgival["status"], "status", 0);

}

function get_data()
{
	global $g_cgival, $g_pro, $g_show;
	
	
	$d = new db_admin_priv();
	if ($g_cgival["pid"] > 0)
	{

		if (!$d->update_priv($g_cgival["pid"], $g_cgival["priv_name"], $g_cgival["priv_link"],
		$g_cgival["priv_order"], $g_cgival["is_show"], $g_cgival["parent_name"], $g_cgival["status"]))
		{
			throw new Exception("更新数据库时出错！");
		}
	}
	else
	{
//		$d->debug = true;
//		print_r($g_cgival);
		if (!$d->insert_priv($g_cgival["priv_name"], $g_cgival["priv_link"], $g_cgival["priv_order"],
		$g_cgival["is_show"], $g_cgival["parent_name"], $g_cgival["status"]))
		{
			throw new Exception("添加到数据库时出错！有可能是数据库中已经存在当前提交的内容！");
		}
	}
}


try {
	admin_check_login();
	admin_check_user_priv("admin_priv_edit_post.php");
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