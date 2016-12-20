<?php
/**
 * 获取距当前时间多久
 * @param string 时间戳
 */
function smarty_modifier_pretime($string) 
{
	//echo $string;
	preg_match("/^(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)$/i", $string,$o);
	/**
	 * print_r($o);
	 * (
    [0] => 2010-07-21 13:52:00
    [1] => 2010
    [2] => 07
    [3] => 21
    [4] => 13
    [5] => 52
    [6] => 00
    )
	 */
	$ts= time()-mktime($o[4], $o[5], $o[6], $o[2], $o[3], $o[1]);
	//echo $ts;
	$day=floor($ts/86400);
	if($day>0)
		return $day.'天';
	$h=floor($ts/3600);
	if($h>0)
		return $h.'小时';
	$i=floor($ts/60);
	if($i>0)
		return $i.'分钟';
	
	return $ts.'秒';
}
?>








