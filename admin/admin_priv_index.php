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
	
	cgi::both($g_cgival["parent_name"], "parent_name", "");
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show;
	
	$d = new db_admin_priv();
	$priv_data = $d->get_priv_all($g_cgival["parent_name"]);
	if (is_array($priv_data))
	{
		foreach($priv_data as $k => $priv)
		{
			$g_show["list"] .= <<<ZZ
<tr>
	<td>{$priv['pid']}</td>
	<td>{$priv['priv_name']}</td>
	<td>{$priv['priv_link']}</td>
	<td>{$priv['priv_order']}</td>
	<td>{$priv['is_show']}</td>
	<td><a href='/admin/admin_priv_index.php?parent_name={$priv['parent_name']}'>{$priv['parent_name']}</a></td>
	<td>{$priv['status']}</td>
	<td><a href='admin_priv_edit.php?pid={$priv["pid"]}'>编辑</a>&nbsp;<a href='javascript:;' onclick="on_delete({$priv['pid']})">删除</a></td>
</tr>
ZZ;
		}
	}
}


try
{
	admin_check_login();
	admin_check_user_priv("admin_priv_index.php");
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
		$smarty->display("admin_admin_priv_index.html");
	}
	else
	{
		$smarty->display("admin_error.html");//指定错误页面
	}
		

	
}
?>