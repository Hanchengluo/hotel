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
	
	cgi::both($g_cgival["p"], "p", 1);
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show;
	global $config;
	
	$d_gu = new db_admin_group_user();
	$d = new db_admin_user();
	$data = $d->get_user_list($g_cgival["p"], 10000);
	if (is_array($data))
	{
		foreach($data as $k => $priv)
		{
			$site_id = $priv["site_id"];
			$site_name = $config["site_name"][$site_id];
			$g_show["list"] .= <<<ZZ
<tr>
	<td>{$priv['uid']}</td>
	<td>{$site_name}</td>
	<td><a href='admin_user_edit.php?uid={$priv["uid"]}'>{$priv['user_name']}</a></td>
	<td>{$priv['status']}</td>
	<td><a href='admin_user_edit.php?uid={$priv["uid"]}'>编辑</a>&nbsp;<a href='javascript:;' onclick="on_delete({$priv['uid']})">删除</a></td>
</tr>
ZZ;

			// 用户所属组
			$group = $d_gu->get_group_by_user($priv["uid"]);
			$group_str = "";
			foreach($group as $g => $g_data)
			{
				$group_str .= "<a href='/admin/admin_group_priv_list.php?gid={$g_data['gid']}' >{$g_data['group_title']}</a>&nbsp;&nbsp;";
			}
			
			$g_show["list"] .= <<<ZZ
<TR>
	<td colspan=5>
		所属组：{$group_str}
	</td>
</TR>
ZZ;
		}
	}
}


try
{
	admin_check_login();
	admin_check_user_priv("admin_user_list.php");
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
		$smarty->display("admin_admin_user_list.html");
	}
	else
	{
		$smarty->display("admin_error.html");//指定错误页面
	}
		
}
?>