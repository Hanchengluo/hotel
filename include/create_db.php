<?php 
include_once($_SERVER["DOCUMENT_ROOT"] . "/core/inc.php");

class create_db extends db_base
{ 
	var $table_name = "";
	var $primary_key = "";
	var $other_field = array();
	var $field_default = array("create_time","create_ip","create_uid","update_time","update_ip","update_uid","site_id","status");
	function create_db()
	{
		parent::db_base();
	}
		
	function get_tables()
	{
		$sql = "show tables";
		$res = $this->select($sql);
		return $res;
	}
	
	function set_table_name($table_name)
	{
		if(!$table_name) return false;
		$this->table_name = $table_name;
		return true;
	}
	
	function get_detail_from_table($table_name)
	{
		$sql =" desc {$table_name}";
		$res = $this->select($sql);
		
		$i=1;
		foreach($res as $key => $value)
		{
			if(in_array($value["Field"],$this->field_default))continue;
			if($i == 1 ) 
			{
				$this->primary_key = $value["Field"];
			}
			else
			{
				$other_field[] = $value["Field"];
			}
			$i++;
		}
		
		$this->other_field = $other_field;
		return $res;
	}
	
	
	function create_file()
	{
		//建mod时候写成 $temp_path = "mod_temp.php";
		$temp_path = "db_temp.php";
		$temp = file_get_contents($temp_path);
		$need_replace_field_array = array();
		$need_replace_field_parameter = "";
		$need_replace_field_parameter[] = "\$current_uid";
		foreach($this->other_field as $key => $value)
		{
			$need_replace_field_parameter[] = '$'.$value;
			$need_replace_field_array[] = "\$ary[\"{$value}\"] = \${$value};";
		}
		
		$need_replace_field_parameter_value = join(",
		",$need_replace_field_parameter);
		$need_replace_field_array_value = join("
		",$need_replace_field_array);
		
		$need_replace_field_array_value = substr($need_replace_field_array_value,0,count($need_replace_field_array_value)-2);
		
		$temp = str_replace("\$need_replace_field_parameter",$need_replace_field_parameter_value,$temp);
		$temp = str_replace("\$need_replace_field_array",$need_replace_field_array_value,$temp);
		
		echo $this->table_name."<br>";
		echo $this->primary_key."<br>";
		$temp = str_replace("temp_example",$this->table_name,$temp);
		$temp = str_replace("primary_id",$this->primary_key,$temp);
		
		//建mod时候前缀写成mod_
		$qianzui = "db_";
		$res = file_put_contents($qianzui.$this->table_name.".class.php",$temp) ;
		echo "success!";
		return $res;
	}
	
} 
$create_db = new create_db();
$table_name = $_GET["name"];

$table_list = $create_db->get_tables();

foreach($table_list as $key => $value)
{
	
	$table_name = $value["Tables_in_tv"];
	$res = $create_db->set_table_name($table_name);
	$table_detail = $create_db->get_detail_from_table($table_name);
	$table_detail = $create_db->create_file();
}




?>