<?php
//include_once($_SERVER['DOCUMENT_ROOT'] . '/include/db.class.php');
//include_once($_SERVER['DOCUMENT_ROOT'] . '/config/db_config.php');


class db_admin_user extends db_base 
{
	function insert_user($user_name, $user_passwd, $site_id=902)
	{
		if (strlen($user_name) == 0
			or strlen($user_passwd) == 0)
		{ 
			return false;		
		}
		
		$ary = array();
		$ary["user_name"] = $user_name;
		$ary["user_passwd"] = md5($user_passwd);
		$ary["site_id"] = $site_id; 
		$ary["status"] = 1;
		return $this->insert("admin_user", $ary);
	}
	
	function update_user($uid, $user_name, $site_id=902, $status=1)
	{
		if (strlen($user_name) == 0)
		{ 
			return false;		
		}
		
		$ary = array();
		$ary["user_name"] = $user_name;
		$ary["site_id"] = $site_id;
		$ary["status"] = $status;
		return $this->update("admin_user", $ary, "uid={$uid}");
	}
	
	function update_user_passwd($uid, $user_passwd)
	{
		$ary = array();
		$ary["user_passwd"] = md5($user_passwd);
		return $this->update("admin_user", $ary, "uid={$uid}");
	}
	
	function get_user_list($p=1, $pc=100)
	{
		//$this->debug = true;
		return $this->get_alllist("admin_user", $p, $pc, "uid asc");
	}
	
	function get_user_list_by_site_id($site_id, $p=1, $pc=1000)
	{
		//$this->debug = true;
		return $this->get_alllist("admin_user", $p, $pc, "uid asc", "site_id=$site_id");
	}
	
	function get_user($user_name)
	{
		if (strlen($user_name) == 0)
		{ 
			return false;		
		}	
		
		return $this->get_alllist("admin_user", 1, 1, "", "user_name='{$user_name}'");
	}
	
	
	/**
	 * 跟据用户UID得到用户名称
	 * @param $uid
	 */
	function get_user_by_uid($uid)
	{
		if (!is_numeric($uid) or $uid <= 0)
		{
			return false;
		}
		
		
		
		$mc = mem_cache::get_instance();
		
		$key = CACHE_PREFIX_PLATFORUM_ADMIN_USER . $uid;
		$cache = $mc->get($key);
		if ($cache === false)
		{
			$data = $this->get_alllist("admin_user", 1, 1, "", "uid={$uid}");
			
			// 保存
			$mc->set($key, serialize($data), 0, CACHE_TIME_PLATFORUM_ADMIN_USER);			
		}
		else
		{
			$data = unserialize($cache);
		}
		
		return $data;
	}
	
	
	/**
	 * 后台管理员日志，通过uid查询用户名
	 * @param $uid
	 */
	function admin_get_user_by_uid($uid)
	{
		if (!is_numeric($uid) or $uid <= 0)
		{
			return false;
		}
		$data = $this->get_alllist("admin_user", 1, 1, "", "uid={$uid}");
		
		return $data[0]['user_name'];
	}
	
	/**
	 * 后台管理员日志，通过uids查询多用户信息
	 * @param $uids
	 */
	function admin_get_user_by_uids($uids)
	{
		if (!$uids)
		{
			return false;
		}
		$data = $this->get_alllist("admin_user", 1, 100, "", "uid in ({$uids})");
		
		return $data;
	}	
	
	function delete_user($user_name)
	{
		if (strlen($user_name) == 0)
		{ 
			return false;		
		}	

		$ary = array();
		$ary["status"] = 0;
		
		return $this->update("admin_user", $ary, "user_name='{$user_name}'");
	}
	
	function active_user($user_name)
	{
		if (strlen($user_name) == 0)
		{ 
			return false;		
		}	

		$ary = array();
		$ary["status"] = 1;
		
		return $this->update("admin_user", $ary, "user_name='{$user_name}'");
	}	
}

class db_admin_priv extends db_base 
{
	function insert_priv($priv_name, $priv_link, $priv_order, $is_show, $parent_name)
	{
		if (strlen($priv_name) == 0)
		{ 
			return false;		
		}
		
		$ary = array();
		$ary["priv_name"] = mysql_escape_string($priv_name);
		$ary["priv_link"] = mysql_escape_string($priv_link);
		$ary["priv_order"] = $priv_order;
		$ary["is_show"] = $is_show;
		$ary["parent_name"] = $parent_name;
		$ary["status"] = 1;
		return $this->insert("admin_priv", $ary);
	}
	
	function update_priv($pid, $priv_name, $priv_link, $priv_order, $is_show, $parent_name, $status)
	{
		if (strlen($priv_name) == 0)
		{ 
			return false;		
		}
		
		$ary = array();
		$ary["priv_name"] = mysql_escape_string($priv_name);
		$ary["priv_link"] = mysql_escape_string($priv_link);
		$ary["priv_order"] = $priv_order;
		$ary["is_show"] = $is_show;
		$ary["parent_name"] = $parent_name;
		$ary["status"] = $status;
		return $this->update("admin_priv", $ary, "pid={$pid}");
	}
	
	function get_priv_item($pid)
	{
		return $this->get_alllist("admin_priv", 1, 1, "", "pid={$pid}");
	}
	
	function get_priv_all_show()
	{
		return $this->get_alllist("admin_priv", 1, 10000, "priv_order", "is_show=1 and status=1");
	}
	
	function get_priv_all($parent_name="")
	{
		if (strlen($parent_name) == 0)
		{
			$where = "status = 1";
		}
		else
		{
			$parent_name = mysql_escape_string($parent_name);
			$where = "parent_name='{$parent_name}' and status=1";
		}
		return $this->get_alllist("admin_priv", 1, 10000, "parent_name asc, priv_order asc ", $where);
	}	
	
	function delete_priv($priv_name)
	{
		if (strlen($priv_name) == 0)
		{ 
			return false;		
		}	

		$ary = array();
		$ary["status"] = 0;
		
		return $this->update("admin_priv", $ary, "priv_name='{$priv_name}'");
	}
	
	function active_priv($priv_name)
	{
		if (strlen($priv_name) == 0)
		{ 
			return false;		
		}	

		$ary = array();
		$ary["status"] = 1;
		
		return $this->update("admin_priv", $ary, "priv_name='{$priv_name}'");
	}		
}

class db_admin_group extends db_base 
{
	function insert_group($group_title)
	{
		if (strlen($group_title) == 0)
		{ 
			return false;		
		}
		
		$ary = array();
		$ary["group_title"] = $group_title;
		$ary["status"] = 1;
		return $this->insert("admin_group", $ary);
	}
	
	function update_group($gid, $group_title)
	{
		if (strlen($group_title) == 0)
		{ 
			return false;		
		}
		$ary = array();
		$ary["group_title"] = $group_title;
		return $this->update("admin_group", $ary, "gid={$gid}");
	}
	
	function get_group_by_gid($gid)
	{
		return $this->get_alllist("admin_group", 1, 1, "", "gid={$gid}");
	}
	
	function get_group_by_gids($gids)
	{
		if(!$gids)
		{
			throw new Exception("管理组ids不能为空。");
		}
		return $this->get_alllist("admin_group", 1, 100, "", "gid in ({$gids})");
	}	
	
	function get_group_all()
	{
		return $this->get_alllist("admin_group", 1, 10000, "", "");
	}
	
	function delete_group($group_title)
	{
		if (strlen($group_title) == 0)
		{ 
			return false;		
		}	

		$ary = array();
		$ary["status"] = 0;
		
		return $this->update("admin_group", $ary, "group_title='{$group_title}'");
	}
	
	function active_group($group_title)
	{
		if (strlen($group_title) == 0)
		{ 
			return false;		
		}	

		$ary = array();
		$ary["status"] = 1;
		
		return $this->update("admin_group", $ary, "group_title='{$group_title}'");
	}		
}


class db_admin_group_priv extends db_base 
{
	function insert_group_priv($gid, $pid)
	{
		if (!is_numeric($gid) or $gid <= 0)
		{
			return false;
		}
		
		if (!is_numeric($pid) or $pid <= 0)
		{
			return false;
		}
		
		
		$ary = array();
		$ary["gid"] = $gid;
		$ary["pid"] = $pid;
		$ary["status"] = 1;
		return $this->insert("admin_group_priv", $ary);
	}
	
	function get_group_priv($gid)
	{
		if (!is_numeric($gid) or $gid <= 0)
		{
			return false;
		}
		return $this->get_alllist("admin_group_priv", 1, 10000, "", "gid={$gid} and status=1");
	}
	
	function delete_group_priv($gid, $pid)
	{
		if (!is_numeric($gid) or $gid <= 0)
		{
			return false;
		}
		
		if (!is_numeric($pid) or $pid <= 0)
		{
			return false;
		}
		
		$ary = array();
		$ary["status"] = 0;
		
		return $this->update("admin_group", $ary, "gid={$gid} and pid={$pid}");
	}
	
	function active_group_priv($gid, $pid)
	{
		if (!is_numeric($gid) or $gid <= 0)
		{
			return false;
		}
		
		if (!is_numeric($pid) or $pid <= 0)
		{
			return false;
		}

		$ary = array();
		$ary["status"] = 1;
		
		return $this->update("admin_group", $ary, "gid={$gid} and pid={$pid}");
	}		
}

class db_admin_group_user extends db_base 
{
	function insert_group_user($gid, $uid)
	{
		if (!is_numeric($gid) or $gid <= 0)
		{
			return false;
		}
		
		if (!is_numeric($uid) or $uid <= 0)
		{
			return false;
		}
		
		
		$ary = array();
		$ary["gid"] = $gid;
		$ary["uid"] = $uid;
		$ary["status"] = 1;
		return $this->insert("admin_group_user", $ary);
	}
	
	function get_group_user($gid)
	{
		if (!is_numeric($gid) or $gid <= 0)
		{
			return false;
		}
		return $this->get_alllist("admin_group_user", 1, 10000, "", "gid={$gid} and status=1");
	}

	
	function get_group_by_user($uid)
	{
		if (!is_numeric($uid) or $uid <= 0)
		{
			return false;
		}
		$data = $this->get_alllist("admin_group_user", 1, 10000, "", "uid='{$uid}' and status=1");
		if (is_array($data))
		{
			$d = new db_admin_group();
			foreach($data as $k => $v)
			{
				$gid = $v["gid"];
				$data2 = $d->get_group_by_gid($gid);
				$data2 = $data2[0];
				$data[$k]["gid"] = $gid;
				$data[$k]["group_title"] = $data2["group_title"];
				$data[$k]["group_status"] = $data2["status"];
			}
		}
		
		return $data;
	}
	
	function delete_group_user($gid, $uid)
	{
		if (!is_numeric($gid) or $gid <= 0)
		{
			return false;
		}
		
		if (!is_numeric($uid) or $uid <= 0)
		{
			return false;
		}
		
		$ary = array();
		$ary["status"] = 0;
		
		return $this->update("admin_group_user", $ary, "gid={$gid} and uid={$uid} and status=1");
	}
	
	function active_group_user($gid, $uid)
	{
		if (!is_numeric($gid) or $gid <= 0)
		{
			return false;
		}
		
		if (!is_numeric($uid) or $uid <= 0)
		{
			return false;
		}
		
		$ary = array();
		$ary["status"] = 0;
		
		return $this->update("admin_group_user", $ary, "gid={$gid} and uid={$uid} and status=1");
	}		
}

// init add admin user
//print_r($db_config_master);
//$db = new db_admin_user();
//$db->insert_user("admin", "123456");
//print_r($db->get_user("admin"));


?>