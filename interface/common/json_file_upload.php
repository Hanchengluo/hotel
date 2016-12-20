<?php

include_once($_SERVER["DOCUMENT_ROOT"]. "/core/inc.php");

/*ini_set("display_errors",true);
error_reporting(E_ALL);
*/
$g_cgival = array();
$g_show = array();
$g_pro = array();


function check_cgi_pro()
{
	global $g_cgival, $g_show, $g_pro;
	cgi::both($g_cgival['t'],"t","json");
	$g_cgival['t'] = string::un_html($g_cgival['t']);
	
	cgi::both($g_cgival['cb'],"cb","");
	$g_cgival['cb'] = string::un_html($g_cgival['cb']);
	
	cgi::both($g_cgival['form_id'],"form_id","");
	$g_cgival['form_id'] = string::un_html($g_cgival['form_id']);
	
	
	cgi::both($g_cgival['callback'],"callback","");
	$g_cgival['callback'] = string::un_html($g_cgival['callback']);
	
	cgi::both($g_cgival['pic_name'],"pic_name","");
	$g_cgival['pic_name'] = string::un_html($g_cgival['pic_name']);
	
	cgi::both($g_cgival['thumbstatus'],"thumbstatus",1);
	if($g_cgival['thumbstatus'] != 1)
	{
		$g_cgival['thumbstatus'] = 2;
	}
	
	cgi::both($g_cgival['thumbsize'],"thumbsize","100|75");
	$g_cgival['thumbsize'] = string::un_html($g_cgival['thumbsize']);
	
		
	
}


function get_data()
{
	global $g_cgival, $g_show, $g_pro;
	
	$upload = new file_upload();
	$link = $upload->saveFile($_FILES["pic_name"]);//传入表单图片名

	
	if(!$link)
	{
		throw new Exception("上传失败!");
	}
	
// 	$file_address = $_SERVER["DOCUMENT_ROOT"].$link;
// 	$data_link = $file_address;
	$g_show["link"] = $link;
	/* if(file_exists($data_link))
	{
		$zip=zip_open(($data_link));
	
		if(is_resource($zip)){
				
			$get_manifest = false;
			while($zip_entry=zip_read($zip))
			{
				$entry_name = zip_entry_name($zip_entry);
				$pathinfo = pathinfo($entry_name);
				if($pathinfo["basename"]== "manifest.json")
				{
					$get_manifest = true;
					if(zip_entry_open($zip,$zip_entry,"r"))
					{
						$buf=zip_entry_read($zip_entry,zip_entry_filesize($zip_entry));
						$buf = preg_replace("/\s/","",$buf);
						//这里获取app信息
						$data_array = json_decode($buf,true);
						$manifest = serialize($data_array);
						break;
					}
					
				}
				else
				{
					continue;
				}
				
			
				zip_close($zip);
				
				if(!$get_manifest)
				{
					echo "manifest文件不存在！";
					exit;
				}
			}
		}
		else
		{
			
			echo "zip文件无法打开！";
			exit;
		}
	}
	
	$g_show["app_name"] = urlencode($data_array["name"]);
	$g_show["app_version"] = $data_array["version"];
	$g_show["app_desc"] = urlencode($data_array["description"]);
	
	
	$g_show["link"] = $link;
	$g_show["size"] = $_FILES["pic_name"]["size"];
	
	$name = $_FILES[$g_cgival['pic_name']]["name"]; */
/*	$encode = mb_detect_encoding($name, array('ASCII','GB2312','GBK','UTF-8'));
	mb_convert_encoding($name,"UTF-8","GBK");*/
	/* $g_show["name"] = urlencode($name);
	$g_show["form_id"]	= $g_cgival["form_id"]; */
}

 
try
{
	check_cgi_pro();
	get_data();

	$g_show["error"] = "0";
	$g_show["errmsg"] = "";
}
catch (Exception $e)
{
	$g_show["error"] = "1";
	$g_show["errmsg"] = $e->getMessage();
}
show_pro();
exit();


function show_pro()
{
	global $g_cgival, $g_show, $g_pro;
	
	if($g_cgival['cb'])
	{
		header("Location:".$g_cgival['cb']."?manifest={$g_show["manifest"]}&name={$g_show["name"]}&link={$g_show["link"]}&size={$g_show["size"]}&form_id={$g_show["form_id"]}&error={$g_show["error"]}&app_name={$g_show["app_name"]}&app_version={$g_show["app_version"]}&app_desc={$g_show["app_desc"]}&errormsg=".urlencode($g_show["errmsg"]));
	}
	else 
	{
		echo output::json($g_cgival["t"], $g_show, $g_cgival["callback"]);
	}
}