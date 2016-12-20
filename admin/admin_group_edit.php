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
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show;
	
	if ($g_cgival["gid"])
	{
		// 获取组信息
		$d = new db_admin_group();
		$data = $d->get_group_by_gid($g_cgival["gid"]);
		if (is_array($data))
		{
			foreach($data as $k => $v)
			{
				$g_show["list"] .= <<<ZZ
<tr>
	<td>用户组ID</td><td>{$v["gid"]}<input type='hidden' id='gid' name='gid' value='{$v["gid"]}' size=80/></td>
</tr>
<tr>
	<td>用户组名称</td><td><input type='text' id='group_title' name='group_title' value='{$v["group_title"]}' size=80/></td>
</tr>
<tr>
	<td></td><td><input type='submit' onclick='on_submit()' value=' 提 交 '/> <input type='submit' onclick='history.back();' value=' 返 回 '/></td>
</tr>
ZZ;
			}
		}
	}
	else
	{
				$g_show["list"] .= <<<ZZ
<input type='hidden' id='gid' name='gid' value='' size=80/>
<tr>
	<td>用户组名称</td><td><input type='text' id='group_title' name='group_title' value='{$v["group_title"]}' size=80/></td>
</tr>
<tr>
	<td></td><td><input type='submit' onclick='on_submit()' value=' 提 交 '/> <input type='submit' onclick='history.back();' value=' 返 回 '/></td>
</tr>
ZZ;
	}
}

try
{
	admin_check_login();
	admin_check_user_priv("admin_group_edit.php");
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
		$smarty->display("admin_admin_group_edit.html");
	}
	else
	{
		$smarty->display("admin_error.html");//指定错误页面
	}
		

	
}
?>