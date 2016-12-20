<?php
//error_reporting(200);
include_once($_SERVER["DOCUMENT_ROOT"] . "/core/inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/core/admin.inc.php");



$g_cgival = array();
$g_pro = array();
$g_show = array();

function check_cgi_pro()
{
	global $g_cgival, $g_pro, $g_show;
	
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show;
	
	$d = new db_admin_group();
	$data = $d->get_group_all();
	if (is_array($data))
	{
		foreach($data as $k => $v)
		{
			$g_show["list"] .= <<<ZZ
<tr>
	<td>{$v['gid']}</td>
	<td>
		<a href='admin_group_edit.php?gid={$v["gid"]}'>{$v['group_title']}</a>
		<a href='admin_group_user_list.php?gid={$v["gid"]}'>(用户成员管理)</a>
		<a href='admin_group_priv_list.php?gid={$v["gid"]}'>(组功能管理)</a>
	</td>
	<td>{$v['status']}</td>
	<td><a href='admin_group_edit.php?gid={$v["gid"]}'>编辑</a>&nbsp;<a href='javascript:;' onclick="on_delete({$v['gid']})">删除</a></td>
</tr>
ZZ;
		}
	}
}


try
{
	admin_check_login();
	admin_check_user_priv("admin_group_list.php");
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
		$smarty->display("admin_admin_group_list.html");
	}
	else
	{
		$smarty->display("admin_error.html");//指定错误页面
	}
	

	
}
?>