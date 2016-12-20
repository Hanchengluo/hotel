<?php

class user_global_config 
{
	private $config = array();
	static public $instance = null;
	
	private function user_global_config()
	{
		global $config;
		
		$this->config = $config;
		
			
	}
	
	static public function get_instance()
	{ 
		if (self::$instance == null)
		{
			self::$instance = new user_global_config();
		}
	
		return self::$instance;
	}
	
	/**
	 * 获取当前站点的站点ID
	 */
	function get_current_site_id()
	{
		return $this->config["current_site_id"];
	}
	
	/**
	 * 获取当前产品的产品ID
	 */
	function get_current_product_id()
	{
		return $this->config["current_product_id"];
	}
	
	/**
	 * 获取所有产品列表，管理后台除外。
	 */
	function get_product_list($show_name = false)
	{
		$data = $this->config["product"];
		
		foreach($data as $k => $v)
		{
			if (strpos($k, "admin") !== false)
			{
				unset($data[$k]);
			}
		}
		
		if ($show_name == true)
		{
			$data_new = array();
			foreach ($data as $k=>$v)
			{
				$product_item = array();
				$product_item['id'] = $v;
				$product_item['en_name'] = $k;
				$product_item['name'] = $this->get_product_name_by_id($v);
				$data_new[$v] = $product_item;
			}
			$data = $data_new;
		}
		
		return $data;
	}
	
	/**
	 * 取得应用的中文名子，通过id
	 * @param $id
	 */
	function get_product_name_by_id($id)
	{
		$data = $this->config["product_name"];
		return $data[$id];
	}
	
	/**
	 * 取得所有的站点列表
	 */
	function get_site_list()
	{
		$data = $this->config["site_name"];
		return $data;
	}
	
	/**
	 * 取得站点的中文名子，通过id
	 * @param $id
	 */
	function get_site_name_by_id($id)
	{
		$data = $this->config["site_name"];
		return $data[$id];
	}
	
	/**
	 * 获取当前站点的名称
	 */
	function get_current_site_name()
	{
		return $this->get_site_name_by_id($this->get_current_site_id());
	}
	
	/**
	 * 取得管理员日志的操作类型，通过op_type
	 * @param $op_type
	 */
	function get_op_type_name_by_op_type($op_type)
	{
		$data = $this->config["admin_log_type"];
		return $data[$op_type];
	}
	
	/**
	 * 取得所有的管理员日志操作类型列表
	 */
	function get_op_type_list()
	{
		$data = $this->config["admin_log"];
		return $data;
	}
	
	/**
	 * 通过省的中文名，获取投稿专题栏目的话题信息
	 * @param $province_zh 省的中文名
	 * @param $article_column 稿件分类Id
	 */
	function get_scolum_topic_by_province($province_zh, $article_column)
	{
		//获取省的英文名，如hn
		$en_data = $this->config["scolumn"]["shortname"]["{$province_zh}"];

		//获取话题信息
		$data = $this->config["scolumn"]["{$en_data}"]['topic'][$article_column];
		
		return $data;
	}
	
	
	//根据站点获取域名 
	function get_domain_by_site_id($site_id)
	{
		$data = $this->config["domain"];
		foreach($data as $key=> $value)
		{
			if($value["site"] == $site_id)
			{
				return $key;
			}
			
		}
		
		
		return "";
	}
	
	//获取当前site_id对应的前台demain
	function get_current_domain()
	{
		return $this->get_domain_by_site_id($this->get_current_site_id());
	}
}
