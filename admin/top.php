<?php
// error_reporting(E_ALL);
include_once($_SERVER["DOCUMENT_ROOT"] . "/core/inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/core/admin.inc.php");




$g_cgival = array();
$g_pro = array();
$g_show = array();

function check_cgi_pro()
{
	global $g_cgival, $g_pro, $g_show;
	
	cgi::both($g_cgival["url"], "url", "welcome.php");	
	cgi::both($g_cgival["gid"], "gid", -1); 
	
	
	if ($g_cgival["gid"] < 0)
	{
		$gid2 = $_COOKIE["admin_group_id"];
		if($gid2 < 0)
		{
			$g_cgival["gid"] = 0;
		}
		else
		{
			$g_cgival["gid"] = $gid2;
		}
	}
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show, $config;
	
	// 记录组ID到COOKIE，以便下次登录时直接进这个组
	setcookie("admin_group_id", $g_cgival["gid"]);
	$admin = new admin();
	$priv_data = $admin->admin_get_user_priv($g_cgival["gid"]);
	$user_name = $admin->admin_get_login_user_name();
	$site_id = $admin->admin_get_user_site_id();
	$site_name = $config["site_name"][$site_id];
	
	
	
	// 登录名
	$g_show["user_name"] = $user_name;
	$g_show["site_name"] = $site_name;
	
	// 所属用户组
	$group_name = "<select id='group_select'><option value=0>全部</option>";
	$d_g = new db_admin_group_user();
	$data = $d_g->get_group_by_user(admin::admin_get_login_uid());
	if (is_array($data))
	{
		foreach($data as $k => $v)
		{
			$gid = $v["gid"];
			if ($gid == $g_cgival["gid"])
			{
				$group_name .= "<option value={$gid} selected=selected>" . $v["group_title"] . "</option>";
			}
			else 
			{
				$group_name .= "<option value={$gid}>" . $v["group_title"] . "</option>";
			} 
		}
	}
	$g_show["group_name"] = $group_name . "</select>";
	
	$priv_ary = array();
	if(is_array($priv_data))
	{
		foreach($priv_data as $priv)
		{
			$parent_name = $priv["parent_name"];

			// 去掉排序用的数字标签 
			$pattern = '/%[0-9]{1,2}%/';
			$parent_name = preg_replace($pattern, "", $parent_name);

			
			$is_show = $priv["is_show"];
			if ($is_show == 1)
			{
				// 如果是admin，只用显示后台管理相关的功能 
				if ($user_name == "admin")
				{
					if ($parent_name == "后台管理")
					{
						$priv_ary[$parent_name][] = $priv;
					}
				}
				else
				{
					$priv_ary[$parent_name][] = $priv;
				}
			}
		}
	}
	
	$g_show['i'] = 0;
	$g_show['priv_ary'] = $priv_ary;

}


try
{
	admin_check_login();
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
	global $config;
	
	$smarty = p_get_smarty();
	$smarty->assign('g_show', $g_show);
	
	if (isset($_GET["debug"]))
	{
		print_r($smarty);
	}
		
	if ($g_show["error"] == "0")
	{
		$smarty->display("top.html");
	}
	else
	{
		$smarty->display("admin_error.html");//指定错误页面
	}
	
	if(isset($_GET["debug"]))
	{
		echo "<pre>";
		print_r($g_show);
		
	}
}
?>