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
	
	cgi::both($g_cgival["pid"], "pid", 0);
	$g_show['gid']=$g_cgival["gid"];
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show;
	
	if ($g_cgival["pid"] > 0)
	{
		
		$d = new db_admin_priv();
		$priv_data = $d->get_priv_item($g_cgival["pid"]);
		if (is_array($priv_data))
		{
			$priv = $priv_data[0];

			$g_show["list"] .= <<<ZZ
<tr><td>pid</td>			<td>{$priv['pid']}<input type='hidden' size='80' id='pid' name='pid' value='{$priv['pid']}' /></td></tr>
<tr><td>priv_name</td>		<td><input type='text)' size='80' id='priv_name' name='priv_name' value='{$priv['priv_name']}' /></td></tr>
<tr><td>priv_link</td>		<td><input type='text' size='80' id='priv_link' name='priv_link' value='{$priv['priv_link']}' /></td></tr>
<tr><td>priv_order</td>		<td><input type='text' size='80' id='priv_order' name='priv_order' value='{$priv['priv_order']}' /></td></tr>
<tr><td>is_show</td>		<td><input type='text' size='80' id='is_show' name='is_show' value='{$priv['is_show']}' /></td></tr>
<tr><td>parent_name</td>	<td><input type='text' size='80' id='parent_name' name='parent_name' value='{$priv['parent_name']}' /></td></tr>
<tr><td>status</td>			<td><input type='text' size='80' id='status' name='status' value='{$priv['status']}' /></td></tr>
<tr><td></td>				<td><input type='submit' value=' 提 交 ' onclick='on_submit();'/>&nbsp;<input type='submit' value=' 返 回 ' onclick='history.back()'/></td></tr>
ZZ;
		}
	}
	else
	{
			$g_show["list"] .= <<<ZZ
<tr><td>pid</td>			<td>NULL<input type='hidden' size='80' id='pid' name='pid' value='' /></td></tr>
<tr><td>priv_name</td>		<td><input type='text' size='80' id='priv_name' name='priv_name' value='' /></td></tr>
<tr><td>priv_link</td>		<td><input type='text' size='80' id='priv_link' name='priv_link' value='' /></td></tr>
<tr><td>priv_order</td>		<td><input type='text' size='80' id='priv_order' name='priv_order' value='' /></td></tr>
<tr><td>is_show</td>		<td><input type='text' size='80' id='is_show' name='is_show' value='' /></td></tr>
<tr><td>parent_name</td>	<td><input type='text' size='80' id='parent_name' name='parent_name' value='' /></td></tr>
<tr><td>status</td>			<td><input type='text' size='80' id='status' name='status' value='' /></td></tr>
<tr><td></td>				<td><input type='submit' value=' 提 交 ' onclick='on_submit();'/>&nbsp;<input type='submit' value=' 返 回 ' onclick='history.back()'/></td></tr>
ZZ;
	}
}


try
{
	admin_check_login();
	admin_check_user_priv("admin_priv_edit.php");
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
		$smarty->display("admin_admin_priv_edit.html");
	}
	else
	{
		$smarty->display("admin_error.html");//指定错误页面
	}
	
}
?>