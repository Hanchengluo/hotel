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
	
	cgi::both($g_cgival["uid"], "uid", 0);
	$g_show['uid']=$g_cgival["uid"];
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show;
	global $config;
	
	if ($g_cgival["uid"] > 0)
	{
		$d = new db_admin_user();
		$data = $d->get_user_by_uid($g_cgival["uid"]);
		if (is_array($data))
		{
			foreach($data as $k => $v)
			{
				$site_id = $v["site_id"];
				$site_list = "";
				foreach($config["site_name"] as $k => $site_name)
				{
					if ($k == $site_id)
					{
						$site_list .= "<option value='$k' selected='selected'>{$site_name}</option>\n";
					}
					else
					{
						$site_list .= "<option value='$k'>{$site_name}</option>\n";
					}
				}
				
				$g_show["list"] .= <<<ZZ
<tr>
	<td>用户ID</td><td>{$v["uid"]}<input type='hidden' id='uid' name='uid' value='{$v["uid"]}' size=80/></td>
</tr>
<tr>
	<td>用户名称</td><td>{$v["user_name"]}<input type='hidden' id='user_name' name='user_name' value='{$v["user_name"]}' size=80/></td>
</tr>
<tr>
	<td>用户密码</td><td><input type='text' id='user_passwd' name='user_passwd' value='' size=80/></td>
</tr>
<tr>
	<td>用户地区</td><td>
		<select id="site_id" name="site_id">
			{$site_list}
		</select>
	</td>
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
		
			$site_list = "";
			foreach($config["site_name"] as $k => $site_name)
			{
				$site_list .= "<option value='$k'>{$site_name}</option>\n";
			}
					
			$g_show["list"] .= <<<ZZ
<tr>
	<td>用户名称</td><td><input type='text' id='user_name' name='user_name' value='{$v["user_name"]}' size=80/></td>
</tr>
<tr>
	<td>用户密码</td><td><input type='text' id='user_passwd' name='user_passwd' value='' size=80/></td>
</tr>
<tr>
	<td>用户地区</td><td>
		<select id="site_id" name="site_id">
			{$site_list}
		</select>
	</td>
</tr>
<tr>
	<td></td><td><input type='hidden' id='uid' name='uid' value='' size=80/><input type='submit' onclick='on_submit()' value=' 提 交 '/> <input type='submit' onclick='history.back();' value=' 返 回 '/></td>
</tr>
ZZ;
	}
}


try
{
	admin_check_login();
	admin_check_user_priv("admin_user_edit.php");
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
		$smarty->display("admin_admin_user_edit.html");
	}
	else
	{
		$smarty->display("admin_error.html");//指定错误页面
	}
		
	
}
?>