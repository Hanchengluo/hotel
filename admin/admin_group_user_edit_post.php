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
	
	$g_cgival["uids"] = array();
	if (isset($_POST["uids"]) and is_array($_POST["uids"]))
	{
		foreach ($_POST["uids"] as $v)
		{
			$g_cgival["uids"][] = $v;
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
	$d = new db_admin_group_user();
	$d->delete("admin_group_user", "gid={$g_cgival['gid']}");
	
	print_r($g_cgival);
	
	// 添加现有数据
	foreach($g_cgival["uids"] as $uid)
	{
		$d->insert_group_user($g_cgival["gid"], $uid);
	}
}

try
{
	admin_check_login();
	admin_check_user_priv("admin_group_user_edit_post.php");
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
parent.location.href='admin_group_user_list.php?gid={$g_cgival["gid"]}';
</SCRIPT>
ZZ;
}
function show_pro2()
{
	global $g_cgival, $g_pro, $g_show;
	
	echo <<<ZZ
<SCRIPT type='text/javascript'>
alert("更新失败！");
parent.location.href='admin_group_user_list.php?gid={$g_cgival["gid"]}';
</SCRIPT>
ZZ;
}
?>