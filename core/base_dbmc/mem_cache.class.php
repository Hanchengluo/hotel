<?php
/**
 * memcache 操作类 实现memcache的单件模式
 * @author liujia

 * @package shneghuo_db
 * @copyright liujia
 * @version 1.0
 * @code-encode utf-8
 * @data-encode utf-8
 */

class mem_cache extends Memcache
{	
	static $instance = NULL;
	var $debug = false;							// 控制输出调试信息
	var $use_cache = true;						// 控制是否使用MC，由于是 instance 模式，所以一旦关闭，所有与MC相关的操作都不会使用MC
	
	static function get_instance()
	{
		if(self::$instance == NULL)
		{
			self::$instance = new mem_cache();
		}
		return self::$instance;
	}

	function __construct()
	{
		global $config;
		
		$memcached_servers = explode(' ', $_SERVER['SINASRV_MEMCACHED_SERVERS']);
        foreach ($memcached_servers as $memcached) {
                list($server, $port) = explode(':', $memcached);
                //echo "> $server:$port\n";
                parent::addServer($server, $port, FALSE);
        }
        
        if (isset($_GET["mc_debug"]))
        {
        	$config["mc_debug"] = true;
        }
        if ($config["mc_debug"] == true)
        {
        	$this->debug = true;
        }
        else
        {
        	$this->debug = false;
        }
        
//         debug_print_backtrace();
	}
	
	private function __clone()
	{
	}
	
	function get($key, $must_use_mc = false /*如果有些功能必须要用MC，则不用考虑use_cache参数和recache参数*/)
	{
		if ($this->debug)
		{
			if (!is_array($key))
			{
				echo "<!-- mem_cache::get({$key}) -->\n";
			}
			else
			{
				foreach($key as $v)
				{
					echo "<!-- mem_cache::get({$v}) -->\n";
				}
			}
		}
			
		if ($this->use_cache == false)
		{
			return false;
		}
		if (isset($_GET["recache"]))
		{
			return false;
		}
			
		// 如果有些功能必须要用MC，则不用考虑use_cache参数和recache参数
		/*if ($must_use_mc == false)
		{
			if ($this->use_cache == false)
			{
				return false;
			}
			if (isset($_GET["recache"]))
			{
				return false;
			}
		}
		*/

		return parent::get($key);
	}
	
	function set($key, $var, $flag=0, $expire=0)
	{
		if ($this->debug)
		{
			echo "<!-- mem_cache::set({$key}, {$var}, {$flag}, {$expire}) -->\n";
		}
		
		return parent::set($key, $var, $flag, $expire);
	}
	
	function delete($key)
	{
		if ($this->debug)
		{
			echo "<!-- mem_cache::delete({$key}) -->\n";
		}
		
		return parent::delete($key);
	}
	
	/**
	 * 批量删除缓存
	 * @param $key_ary
	 */
	function delete_ary($key_ary)
	{
		if (!is_array($key_ary))
		{
			$this->delete($key_ary);
		}
		
		foreach($key_ary as $key)
		{
			$this->delete($key);
		}
		
		return true;
	}
	
	function delete_remote($url, $key_ary)
	{
		$curl = new Curl_Class();
		$keys = implode(",",$key_ary);
		$curl->post($url,"keys=".$keys);
		
		// 删除本地
		$this->delete_ary($key_ary);
	}
}



?>
