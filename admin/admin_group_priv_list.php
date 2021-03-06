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
	$g_show['gid']=$g_cgival["gid"];
	if ($g_cgival["gid"] <= 0)
	{
		throw new Exception("非法用户组ID");
	}
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show;
	
	if ($g_cgival["gid"])
	{
		// 获取组成员列表
		$dd = new db_admin_group_priv();
		$data = $dd->get_group_priv($g_cgival["gid"]);
		if (!is_array($data))
		{
			return ;
		}
		
		$pid_ary = array();
		$pid_status = array();
		foreach($data as $v)
		{
			$pid_ary[] = $v["pid"];
			$pid_status[$v["pid"]] = $v["status"];
		}
		
		$pid_list = implode(",", $pid_ary);
		$d_u = new db_admin_priv();
		$data_user = $d_u->get_alllist("admin_priv", 1, 1000, "parent_name, pid", "status=1");
		if (is_array($data_user))
		{
			foreach ($data_user as $v)
			{
				$style = "";
				if (isset($pid_status[$v["pid"]]) and $pid_status[$v["pid"]] == 1)
				{
					$checkbox = "<input type='checkbox' id='pids[]' name='pids[]' value={$v['pid']} checked=checked/>";
					$style = "style='background-color:#ff0'";
				}
				else
				{
					$checkbox = "<input type='checkbox' id='pids[]' name='pids[]' value={$v['pid']} />";
				}
			
				$g_show["list"] .= <<<ZZ
<tr>
	<td {$style}>{$v['pid']}</td>
	<td {$style}>{$v['parent_name']}</td>
	<td {$style}>{$v['priv_name']}</td>
	<td {$style}>{$v['priv_link']}</td>
	<td {$style}>{$checkbox}</td>
</tr>
ZZ;
			}
		}
		
		
		// 获取小组名
		$d_g = new db_admin_group();
		$data = $d_g->get_group_by_gid($g_cgival["gid"]);
		if (is_array($data) and count($data) > 0)
		{
			$g_show["group_name"] = $data[0]["group_title"];
		}		
	}

}

try
{
	admin_check_login();
	admin_check_user_priv("admin_group_priv_list.php");
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
		$smarty->display("admin_admin_group_priv_list.html");
	}
	else
	{
		$smarty->display("admin_error.html");//指定错误页面
	}
	

}
?>