<?php

include_once($_SERVER["DOCUMENT_ROOT"]. "/core/inc.php");
/*ini_set("display_errors",true);
error_reporting(E_ALL);*/

$g_cgival = array();
$g_show = array();
$g_pro = array();


function check_cgi_pro()
{
	global $g_cgival, $g_show, $g_pro;
	cgi::both($g_cgival['t'], "t", "json");
	$g_cgival['t'] = string::un_html($g_cgival['t']);
	
	cgi::both($g_cgival['cb'], "cb", "");
	$g_cgival['cb'] = string::un_html($g_cgival['cb']);
	
	cgi::both($g_cgival['form_id'], "form_id", "");
	$g_cgival['form_id'] = string::un_html($g_cgival['form_id']);
	
	
	cgi::both($g_cgival['callback'], "callback", "");
	$g_cgival['callback'] = string::un_html($g_cgival['callback']);
	
	cgi::both($g_cgival['pic_name'], "pic_name", "");
	$g_cgival['pic_name'] = string::un_html($g_cgival['pic_name']);
	
	cgi::both($g_cgival['thumbstatus'], "thumbstatus", 1);
	if($g_cgival['thumbstatus'] != 1)
	{
		$g_cgival['thumbstatus'] = 2;
	}
	
	cgi::both($g_cgival['thumbsize'], "thumbsize", "100|75");
	$g_cgival['thumbsize'] = string::un_html($g_cgival['thumbsize']);
	
		
	
}


function get_data()
{
	global $g_cgival, $g_show, $g_pro;
	
	$ary_thumbSize	= explode(",", $g_cgival['thumbsize']);
	
	$upload_config=array(
	'targetDir' => 'pics',//文件保存路径
	'saveType' => 2, //保存目录结构，默认两级
	'thumbStatus'=> $g_cgival['thumbstatus'], //开启图片压缩，1为等比缩放，2为裁剪
	'thumbSize' => $ary_thumbSize, //压缩文件尺寸限制，原图为xxx.jpg压缩文件名为xxx_100.jpg(100为你填写的宽度限制值)
	// 'allowMaxSize' => 1024*1024*3, //允许上传图片大小		3M
	'allowMaxSize' => 1024*1024*2, //允许上传图片大小		2M
	'allowExtensions' => array('jpg', 'jpeg', 'gif', 'png', 'bmp')//允许上传的图片格式
	);
	$upload = new pic_upload($upload_config);
	$files = $upload->saveFiles($g_cgival['pic_name']);//传入表单图片名

	$pic_url = $files[0]["pic_return_info"]["pic"];
	if(!$pic_url)
	{
		throw new Exception("上传失败!");
	}
	
	$g_show["pic_path"] = $pic_url;
	$g_show["pic_path1"] = $files[0]["pic_return_info"]["pic_cut"][0];
	
	$g_show["size"] = $_FILES[$g_cgival['pic_name']]["size"];
	
	$pic_name = $_FILES[$g_cgival['pic_name']]["name"];
	/*$encode = mb_detect_encoding($pic_name, array('ASCII','GB2312','GBK','UTF-8'));
	
	
	mb_convert_encoding($pic_name,"UTF-8","GBK");*/
	$g_show["pic_name"] = urlencode($pic_name);
	$g_show["form_id"]	= $g_cgival["form_id"];
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
		header("Location:".$g_cgival['cb']."?pic_source={$g_show["pic_path"]}&pic={$g_show["pic_path1"]}&pic_name={$g_show["pic_name"]}&size={$g_show["size"]}&form_id={$g_show["form_id"]}&error={$g_show["error"]}&errormsg=".urlencode($g_show["errmsg"]));
	}
	else 
	{
		echo output::json($g_cgival["t"], $g_show, $g_cgival["callback"]);
	}
}