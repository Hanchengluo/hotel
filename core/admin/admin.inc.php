<?php
	session_start();

class admin
{
	/**
	 * 用户登录 
	 *
	 * @param unknown_type $user_name
	 * @param unknown_type $passwd
	 * @return unknown
	 */
	static function admin_login($user_name, $passwd)
	{
		$db = new db_admin_user();
		$data = $db->get_user($user_name);
//		print_r($data);
		if ($data and isset($data[0]))
		{
			if ($data[0]["user_passwd"] == md5($passwd) and $data[0]["status"] == 1)
			{
				$_SESSION["admin"] = $data[0];
				return true;
			}
		}
		
		return false;
	}
	
	static function admin_logout()
	{
		unset($_SESSION["admin"]);
	}
	
	static function admin_check_login()
	{
		if (isset($_SESSION["admin"]["user_name"]) and $_SESSION["admin"]["status"] == 1)
		{
			return true;
		}
		
		return false;
	}
	
	static function admin_get_login_uid()
	{
		if (!admin_check_login())
		{
			return false;
		}
		
		return $_SESSION["admin"]["uid"];
	}
	
	static function admin_get_login_user_name()
	{
		if (!admin_check_login())
		{
			return false;
		}
		
		return $_SESSION["admin"]["user_name"];
	}
	
	static function admin_get_user_site_id()
	{
		if (!admin_check_login())
		{
			return false;
		}
		
		return $_SESSION["admin"]["site_id"];
	}
	
	static function admin_get_login_passwd()
	{
		if (!admin_check_login())
		{
			return false;
		}
		
		return $_SESSION["admin"]["user_passwd"];
	}
	
	/**
	 * 获取用户所能使用的功能列表
	 *
	 * $gid = 0		所有组
	 * $gid = 1 	只返回第1组的所有功能 
	 * @return unknown
	 */
	static function admin_get_user_priv($gid=0)
	{
		if (!admin_check_login())
		{
			return false;
		}
		
		
		$d = new db_admin_priv();
		$priv_data = $d->get_priv_all();
		

		// 如果用户登录名为 admin ，则显示所有功能 
		if (admin::admin_get_login_user_name() == "admin")
		{
			return $priv_data;
		}
		
		// 查询用户所在组
		$gid_ary = array();
		$d_g = new db_admin_group_user();
		$data = $d_g->get_group_by_user(admin::admin_get_login_uid());

		if (!is_array($data))
		{
			return array();				// 用户没有初始化
		}
		foreach($data as $v)
		{
			$data = $v;
			$gid_ary[] = $data["gid"];
			$group_name = $data["group_title"];

			if ($group_name == "administrator")
			{
				return $priv_data;
			}
		}

		
		// 查询用户所在组的功能 列表
		$x = array();	// 存储用户有权限使用的功能
		foreach($gid_ary as $gid2)
		{
			// 假如只需要某个组，则返回当前组的所有功能列表
			if ($gid != 0 and $gid != $gid2)
			{
				continue;
			}
			
			$d_gp = new db_admin_group_priv();
			$data = $d_gp->get_group_priv($gid2);
			if (!is_array($data))
			{
				continue;
			}

			foreach($data as $v)
			{
				$pid = $v["pid"];
				$x[$pid] = 1;
			}
		}

		
		// 把不属于用户的功能去掉
		foreach($priv_data as $k => $v)
		{
			$pid = $v["pid"];
			if (!array_key_exists($pid, $x))
			{
				unset($priv_data[$k]);
			}
		}
		

		
		// 存入SESSION
		$_SESSION["admin"]["user_priv"] = $priv_data;
		return $priv_data;
	}
	
	static function admin_get_username_by_uid($uid)
	{
		$d = new db_admin_user();
		$data = $d->get_user_by_uid($uid);
		if (isset($data[0]))
		{
			return $data[0]["user_name"];
		}
		
		return $uid;
	}
	
	static function admin_get_uid_by_username($username)
	{
		$d = new db_admin_user();
		$data = $d->get_user($username);
		if (isset($data[0]))
		{
			return $data[0]["uid"];
		}	
		return 0;
	}
}


/**
 * 检查用户登录状态
 *
 * @return unknown
 */
function admin_check_login($login_url = false)
{
	global $config;
	/*if (strpos($_SERVER["HTTP_HOST"], "admin.") === false
		and strpos($_SERVER["HTTP_HOST"], "8080") === false
		and  !in_array($_SERVER['HTTP_HOST'],$config['test_domain'])
		)
	{
		header('HTTP/1.1 404 Not Found'); 
		header("status: 404 Not Found"); 
		echo "404 Not Found!<br/>Not a administrator domain ... <br/>";
		exit;
	}
*/

	if (!admin::admin_check_login())
	{
		if ($login_url)
		{
			header("Location: {$login_url}");
		}
		else
		{
			header("Location: /admin/login.php");
		}
		exit;
	}
	
	return true;
}

function admin_check_user_priv($priv_link, $debug = false)
{
	if (isset($_GET["db_debug"]) or isset($_GET["mc_debug"]))
	{
		echo "<!--================ Start admin_check_user_priv() ========================-->\n";
	}
	
	// 如果用户登录名为 admin ，则显示所有功能 
	if (admin::admin_get_login_user_name() == "admin")
	{
		return true;
	}
	
	
// FOR TEST
	//unset($_SESSION["admin"]["user_priv"]);
// FOR TEST	

	$priv_data = array();
	if (isset($_SESSION["admin"]["user_priv"]))
	{
		$priv_data = $_SESSION["admin"]["user_priv"];
	}
	else
	{
		$priv_data = admin::admin_get_user_priv();
	}
	//print_r($priv_data);
	foreach($priv_data as $v)
	{
		$priv_link1 = $v["priv_link"];
		if ($priv_link1 == $priv_link)
		{
			if (isset($_GET["db_debug"]) or isset($_GET["mc_debug"]))
			{
				echo "<!--================ End admin_check_user_priv() ========================-->\n";
			}			
			
			return true;
		}
	}
	echo "<!--================ End admin_check_user_priv() ========================-->\n";
	echo "<!--================ ERROR : NO PRIVATE  ========================-->\n";
	
	throw new Exception("<span style='color:#f00'>您没有权限查看当前功能页面！</span><a href='#' onclick='history.back();'>返回</a>");
}


?>
