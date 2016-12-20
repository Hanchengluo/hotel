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
	
	cgi::both($g_cgival["url"], "url", "welcome.php");	
}

function get_data()
{
	global $g_cgival, $g_pro, $g_show;	
}
try
{
	check_cgi_pro();
	get_data();
}
catch(Exception $e)
{
	echo $e->getMessage();
}
show_pro();
exit;

function show_pro()
{
	global $g_cgival, $g_pro, $g_show;
	global $config;
	

	$smarty = p_get_smarty();
	$smarty->assign('g_show', $g_show);
	$smarty->display("admin_login.html");
	
}
?>