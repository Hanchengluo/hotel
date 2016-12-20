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
	
	$g_cgival["pids"] = array();
	if (isset($_POST["pids"]) and is_array($_POST["pids"]))
	{
		foreach ($_POST["pids"] as $v)
		{
			$g_cgival["pids"][] = $v;
		}
	}
	
	
	if ($g_cgival["gid"] <= 0)
	{
		throw new Exception("非法gid");
	}
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show;
	

	// 先把原有数据删除掉
	$d = new db_admin_group_priv();
	$d->delete("admin_group_priv", "gid={$g_cgival['gid']}");
	
	
	// 添加现有数据
	foreach($g_cgival["pids"] as $pid)
	{
		$d->insert_group_priv($g_cgival["gid"], $pid);
	}
}

try
{
	admin_check_login();
	admin_check_user_priv("admin_group_priv_edit_post.php");
	check_cgi_pro();
	get_data();
}
catch(Exception $e)
{
	$g_show["list"] = $e->getMessage();
	show_pro2();
	exit;
}
show_pro();
exit;

function show_pro()
{
	global $g_cgival, $g_pro, $g_show;
	
	echo <<<ZZ
<SCRIPT type='text/javascript'>
alert("更新成功！");
parent.location.href='admin_group_priv_list.php?gid={$g_cgival["gid"]}';
</SCRIPT>
ZZ;
}

function show_pro2()
{
	global $g_cgival, $g_pro, $g_show;
	
	echo <<<ZZ
<SCRIPT type='text/javascript'>
alert("更新失败！");
parent.location.href='admin_group_priv_list.php?gid={$g_cgival["gid"]}';
</SCRIPT>
ZZ;
}
?>