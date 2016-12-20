<?php

Class Date
{
	function Date()
	{
		/****/
	}
	
	/**
	 * 获取当前年
	 * @return int
	 * @param boolean $all 是否返回4位数的年份 默认true 
	 */	
	
	function get_year($all = true)
	{
		return $all ? date("Y") : date("y");
	}
	
	/**
	 * 获取当前月份
	 * @return int
	 */	
	
	function get_month()
	{
		return date("m");
	}
	
	/**
	 * 获取当前英文月份
	 * @return string
	 * @param boolean $all 是否返回全部英文 默认true 否则则返回简写 
	 */	
	
	function get_month_en($all = true)
	{
		return $all ? date("F") : date("M");
	}
	
	/**
	 * 获取当前日
	 * @return int
	 */	
	
	function get_day()
	{
		return date("d");
	}
	
	/**
	 * 获取当前小时
	 * @return int
	 */	
	
	function get_hour()
	{
		return date("H");
	}
	
	/**
	 * 获取当前分
	 * @return int
	 */	
	
	function get_min()
	{
		return date("i");
	}
	
	/**
	 * 获取当前秒
	 * @return int
	 */	
	
	function get_sec()
	{
		return date("s");
	}
	
	/**
	 * 获取当前英文星期
	 * @return string
	 * @param boolean $all 是否返回全部英文 默认true 否则则返回简写 
	 */	
	
	function get_week_en($all = true)
	{
		return $all ? date("l") : date("D");
	}
	
	/**
	 * 获取当前星期(0-6)0是星期天或者当前是第几周
	 * @return int
	 * @param boolean $all true 返回星期几 false 返回当前是今年的第几周 默认是true
	 */	
	
	function get_week($all = true)
	{
		return $all ? date("w") : date("W");
	}
	
	/**
	 * 获取日期
	 * @return string
	 */	
	
	function get_date($t = false)
	{
		if ($t)
			return date("Y-m-d", $t);
		else
			return date("Y-m-d");
	}
	
	/**
	 * 获取时间
	 * @return string
	 */	
	
	function get_time()
	{
		return date("H:i:s");
	}
	
	/**
	 * 获取日期和时间
	 * @return string
	 */	
	
	static function get_date_time($t = false)
	{
		if ($t)
			return date("Y-m-d H:i:s", $t);
		else
			return date("Y-m-d H:i:s");
	}
	
	/**
	 * 计算N秒后（前）的时间
	 * @return string
	 * @param int $sec  秒
	 * @param string $d  返回的时间格式 默认 Y-m-d H:i:s
	 */	
	 	
	function get_new_date($sec, $d = "Y-m-d H:i:s")
	{
		$sec = intval($sec);
		return date($d, mktime(date("H"), date("i"), (date("s") + $sec), date("m"), date("d"), date("Y")));
	}
	
	/**
	 * 计算两个时间的差
	 * @return int
	 * @param string $oldTime
	 * @param string $newTime 两个时间参数不分前后
	 * @param string $type 计算相差的类型 d 是计算天,h是小时,i是分钟,s小秒  默认是d
	 */	
	function diff_date($oldTime, $newTime, $type = "d")
	{
		if (preg_match("/^(\d+)-(\d+)-(\d+)$/i", $oldTime))
		{
			$oldTime .= " 00:00:00";
		}
		if (preg_match("/^(\d+)-(\d+)-(\d+)$/i", $newTime))
		{
			$newTime .= " 00:00:00";
		}
		preg_match("/^(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)$/i", $oldTime, $o);
		preg_match("/^(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)$/i", $newTime, $n);
		$o_t = getdate(mktime($o[4], $o[5], $o[6], $o[2], $o[3], $o[1]));
		$o_n = getdate(mktime($n[4], $n[5], $n[6], $n[2], $n[3], $n[1]));
		$sec = abs($o_n[0] - $o_t[0]);
		switch ($type)
		{
			case "d":
				return floor($sec / (60*60*24));
				break;
			case "h":
				return floor($sec / (60*60));
				break;
			case "i":
				return floor($sec / (60));
				break;
			case "s":
				return $sec;
				break;
		}
	}
}


///////////////////////////////////////////////////////////


/**
 * CGI相关LIB包， 包含cgi获取类和cgi校验类
 * @package baseLib
 * @version 1.00
 * @copyright (c) 2004, 新浪网研发中心 All rights reserved.
 * @example	./cgi.class.php 查看源代码
 * @example ./cgi.class.example.php 如何使用请点这里
 */

/**
 * cgi输入获取类
 */
class cgi
{
	/**
	 * 以get方式取cgi变量
	 * @return mexid
	 * @param	string	$cgivv
	 *			string	$cgi_instr
	 *			integer	$defval
	 */
	static function get(&$cgivv, $cgi_instr, $defval = 0)
	{
		return cgi::input($cgivv, $cgi_instr, $defval, 0);
	}
	
	/**
	 * 以get方式取cgi变量
	 * @return mexid
	 * @param	string	$cgivv
	 *			string	$cgi_instr
	 *			integer	$defval
	 */
	static function post(&$cgivv, $cgi_instr, $defval = 0)
	{
		return cgi::input($cgivv, $cgi_instr, $defval, 1);
	}
	
	/**
	 * 以get方式取cgi变量
	 * @return mexid
	 * @param	string	$cgivv
	 *			string	$cgi_instr
	 *			integer	$defval
	 */
	static function both(&$cgivv, $cgi_instr, $defval = 0)
	{
		return cgi::input($cgivv, $cgi_instr, $defval, 2);
	}
	
	/**
	 * 取post方式的变量值
	 * @return mexid
	 * @param	string	$v	取值得名称
	 */
	static function _method_post($v)
	{
		if (isset($_POST[$v]))
		{
			return $_POST[$v];
		}
	}
	
	/**
	 * 取post方式的变量值
	 * @return mexid
	 * @param	string	$v	取值得名称
	 */
	static function _method_get($v)
	{
		if (isset($_GET[$v]))
		{
			return $_GET[$v];
		}
	}
	
	/**
	 * 取post方式如过不存在，取get方式的变量值
	 * @return mexid
	 * @param	string	$v	取值得名称
	 */
	static function _method_both($v)
	{
		if (isset($_POST[$v]))
		{
			return $_POST[$v];
		}
		else if (isset($_GET[$v]))
		{
			return $_GET[$v];
		}
	}

	/**
	 * CGI变量接收
	 * @return mexid
	 * @param	string	$cgivv
	 *			string	$cgi_instr
	 *			integer	$defval
	 */
	static function input(&$cgivv, $cgi_instr, $defval, $cgitype)
	{
		$cgi_in = NULL;
		switch($cgitype)
		{
			case 1:
				$cgi_in = cgi::_method_post($cgi_instr);
				break;
			case 2:
				$cgi_in = cgi::_method_both($cgi_instr);
				break;
			default:
				$cgi_in = cgi::_method_get($cgi_instr);
				break;
		}
		
		if (is_null($cgi_in) or $cgi_in == '')
		{
			if (is_numeric($cgivv))
			{
				$cgivv = $defval + 0;
			}
			else
			{
				$cgivv = $defval . '';
			}
			return false;
		}
		else
		{
			if (is_numeric($cgivv))
			{
				if (!is_numeric($cgi_in))	// 如果要求是数值，而传入是非数值
				{
					$cgivv	= $defval + 0;
					return false;
				}
			}
			$cgivv	= $cgi_in;
			return true;
		}
	}
}

/**
 * cgi校验类
 */
class cgi_chk
{
	/**
	 * 验证Email的合法性
	 * @return boolean
	 * @param string $str Email字符串
	 */
	function email($str)
	{
		return preg_match('/^[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+){1,4}$/', $str) ? true : false;
	}
	
	/**
	 * 验证年份的合法性
	 * @return boolean
	 * @param string $str 年份字符串
	 */
	function year($str)
	{
		if (is_numeric($str))
		{
			preg_match('/^19|20[0-9]{2}$/', $str) ? true : false;
		}
		return false;
	}

	/**
	 * 验证月份的合法性
	 * @return boolean
	 * @param string $str 月份字符串
	 */
	function month($str)
	{
		if (is_numeric($str) && $str > 0 && $str < 13)
		{
			return true;
		}
		return false;
	}

	/**
	 * 验证日期的合法性
	 * @return boolean
	 * @param string $str 月份字符串
	 */
	function day($str)
	{
		if (is_numeric($str) && $str > 0 && $str < 32)
		{
			return true;
		}
		return false;
	}
	
	/**
	 * 检查URL的合法性，检测URL头是否为 http, https, ftp
	 * @return boolean
	 * @param string $str 年份字符串
	 */
	function uri($str)
	{
		$allow = array('http', 'https', 'ftp');
		
		if (preg_match('!^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?!', $str, $matchs))
		{
			$scheme = $matches[2];
			if (in_array($scheme, $allow))
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * 检查uid的合法性
	 * @return boolean
	 * @param string $str 新浪uid 
	 */

	function uid($str)
	{
		return (is_numeric(trim($str)) && strlen(trim($str)) >=5 && strlen(trim($str)) <= 10);
	}

	/**
	 * 检查资源号的合法性
	 * @return boolean
	 */

	//-- 检查文章号 ---
	function blog_id($str)
	{
		return preg_match("/^[0-9a-f]{8}01[0-9a-z]{6}$/i", $str) ? TRUE : FALSE;
	}

	//-- 检查图片号 ---
	function pic_id($str)
	{
		return preg_match("/^[0-9a-f]{8}02[0-9a-z]{6}$/i", $str) ? TRUE : FALSE;
	}

	//-- 检查Mysina资源号 ---
	function my_id($str)
	{
		return preg_match("/^[0-9a-f]{8}05[0-9a-z]{6}$/i", $str) ? TRUE : FALSE;
	}

	//-- 检查现有的资源号 ---
	function res_id($str)
	{
		return preg_match("/^[0-9a-f]{8}0[1-5][0-9a-z]{6}$/i", $str) ? TRUE : FALSE;
	}

	// 判断字符串长度是否有效
	static function check_str_len($str, $len_max, $len_min = 0)
	{
		$len = string::length($str);
		if ($len > $len_max)
			return false;
	
		if ($len < $len_min)
			return false;
	
		return true;
	}

	// 判断字符串长度是否有效(中文字符算1个)
	function check_str_len_new($str)
	{

		$str = preg_replace("/[".chr(0x80)."-".chr(0xff)."]{2}/",'*', $str);
		$len = string::length($str);

		return $len;

	}
	
	/**
	 * 支持utf的计算字符串长度函数
	 * @author liujia0905@gmail.com
	 * @param $str
	 * @return int
	 */
	function check_str_len_utf8($str)
	{
		$n = 0; $p = 0; $c = '';
		$len = strlen($str);

		for($i = 0; $i < $len; $i++) 
		{
			$c = ord($str{$i});
			if($c > 252) 
			{
				$p = 5;
			} 
			elseif($c > 248) 
			{
				$p = 4;
			} 
			elseif($c > 240) 
			{
				$p = 3;
			} 
			elseif($c > 224) 
			{
				$p = 2;
			} 
			elseif($c > 192) 
			{
				$p = 1;
			} 
			else 
			{
				$p = 0;
			}
			$i+=$p;
			$n++;
		}
		
		return $n;
	}
}


///////////////////////////////////////////////////////////

/**
 * FILE相关LIB包
 * @package baseLib
 * @author 刘程辉 <chenghui@staff.sina.com.cn>
 * @version 1.00
 * @copyright (c) 2004, 新浪网研发中心 All rights reserved.
 * @example	./file.class.php 查看源代码
 * @example ./file.class.example.php 如何使用请点这里
 */

/**
 * 文件相关LIB包
 * History: 2005-6-22  创建类
 */



///////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////

/**
 * STRING处理类
 * @package baseLib
 * @author 张市军 <shijun@staff.sina.com.cn>
 * @version 1.0
 * @copyright (c) 2005, 新浪网研发中心 All rights reserved.
 * @example ./string.php 查看源代码
 * @example ./string.example.php 如何使用请点这里(请在环境中运行)
 */

Class string
{
	function string()
	{
		/****/
	} 
	
	/**
	 * 处理截取中文字符串的操作
     * @return string
     * @param string $str 要处理的字符
	 * 		  string $start 开始位置
	 *        string $offset 偏移量
	 *        string $t_str 字符结果尾部增加的字符串，默认为空
	 *        boolen $ignore $start位置上如果是中文的某个字后半部分是否忽略该字符，默认true
	 */
	
	function substr_cn($str, $start, $offset, $t_str = '', $ignore = true)
	{
	 	$length  = strlen($str);
		if ($length <=  $offset && $start == 0)
		{
			return $str;
		}
		if ($start > $length)
		{
			return $str;
		}
		$r_str     = "";
		for ($i = $start; $i < ($start + $offset); $i++)
		{ 
			if (ord($str{$i}) > 127)
			{
				if ($i == $start)  //检测头一个字符的时候，是否需要忽略半个中文
				{
					if (string::is_cn_str($str, $i) == 1)
					{
						if ($ignore)
						{
							continue;
						}
						else
						{
							$r_str .= $str{($i - 1)}.$str{$i};
						}
					}
					else
					{
						$r_str .= $str{$i}.$str{++$i};
					}
				}
				else
				{
					$r_str .= $str{$i}.$str{++$i};
				}
			}
			else
			{
				$r_str .= $str{$i};
				continue;
			}
		}
		return $r_str . $t_str;
		//return preg_replace("/(&)(#\d{5};)/e", "string::un_html_callback('\\1', '\\2')", $r_str . $t_str);
		
	}
	
	/**
	function un_html_callback($a, $b){
        	if ($b){
                	return $a. $b;
        	}
        	return '&amp;';
	}
**/
	
	//-- 判断字符串是否含有非法字符 -------
	function check_badchar($str, $allowSpace = false)
	{
		if ($allowSpace)
			return preg_match ("/[><,.\][{}?\/+=|\\\'\":;~!@#*$%^&()`\t\r\n-]/i", $str) == 0 ? true : false;
		else
			return preg_match ("/[><,.\][{}?\/+=|\\\'\":;~!@#*$%^&()` \t\r\n-]/i", $str) == 0 ? true : false;
	}
	
	/**
	 * 判断字符某个位置是中文字符的左半部分还是右半部分，或不是中文
	 * 返回 1 是左边 0 不是中文 -1是右边
     * @return int
	 * @param string $str 开始位置
	 * @param int $location 位置
	 */
	 
	function is_cn_str($str, $location)
	{ 
		$result	= 1;
		$i		= $location;
		while(ord($str{$i}) > 127 && $i >= 0)
		{ 
			$result *= -1; 
			$i --; 
		} 
		
		if($i == $location)
		{ 
			$result = 0; 
		} 
		return $result; 
	} 
	
	/**
	 * 判断字符是否全是中文字符组成
	 * 2 全是 1部分是 0没有中文
     * @return boolean
	 * @param string $str 要判断的字符串
	 */
	 
	function chk_cn_str($str)
	{ 
		$result = 0;
		$len = strlen($str);
		for ($i = 0; $i < $len; $i++)
		{
			if (ord($str{$i}) > 127)
			{
				$result ++;
				$i ++;
			}
			elseif ($result)
			{
				$result = 1;
				break;
			}
		}
		if ($result > 1)
		{
			$result = 2;
		}
		return $result;
	} 
	
	/**
	 * 判断邮件地址的正确性
	 * @return boolean
	 * @param string $mail 邮件地址
	 */
	
	function is_mail($mail)
	{
		//return preg_match("/^[a-z0-9_\-\.]+@[a-z0-9_]+\.[a-z0-9_\.]+$/i" , $mail);
		return preg_match('/^[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+){1,4}$/', $mail) ? true : false;
	}
	
	/**
	 * 判断App的CallbackURL是否合法（可以包含端口号）
	 * @return boolean
	 * @param string $url URL地址
	 */
	
	function is_callback_url($url)
	{
		return  preg_match("/(ht|f)tp(s?):\/\/([\w-]+\.)+[\w-]+(\/[\w-.\/?%&=]*)?/i" , $url);
	}
	
	/**
	 * 判断URL是否以http(s):// ftp://格式开始的地址
	 * @return boolean
	 * @param string $url URL地址
	 */
	
	function is_http_url($url)
	{
		return  preg_match("/^(https?|ftp):\/\/([\w-]+\.)+[\w-]+(\/[\w;\/?:@&=+$,# _.!~*'\"()%-]*)?$/i" , $url);
		//return preg_match("/^(http(s)|ftp):\/\/[a-z0-9\.\/_-]*?$/i" , $url);
	}
	
	/**
	 * 允许中文
	 */
	function is_url($url)
	{
		//return  preg_match("/^(https?|ftp|mms|mmsu|mmst|rtsp):\/\/([\w-]+\.)+[\w-]+(\/[\w;\/?:@&=+$,# _.!~*'\"()%-]*)?$/i" , $url);
		//return  preg_match("/^(https?|ftp|mms|mmsu|mmst|rtsp):\/\/([\w-]+\.)+[\w-]+(\/[^ \t\r\n{}\[\]`^<>\\\\]*)?$/i" , $url);
		//return preg_match("/^(http(s)|ftp):\/\/[a-z0-9\.\/_-]*?$/i" , $url);
		return preg_match("/^(https?|ftp|mms|mmsu|mmst|rtsp):\/\/([\w-]+\.)+[\w-]+(:\d{1,9}+)?(\/[^ \t\r\n{}\[\]`^<>\\\\]*)?$/i" , $url);

	}

	/**
	 * 判断URL是否是正确的音乐地址
	 * @return boolean
	 * @param string $url URL地址
	 */
	
	function is_music_url($url)
	{
		return preg_match("/^(https?|ftp|mms|mmsu|mmst|rtsp):\/\/([\w-]+\.)+[\w-]+(:\d{1,9}+)?(\/[^ \t\r\n{}\[\]`^<>\\\\]*)?$/i" , $url);
		//return preg_match("/^(https?|ftp|mms|mmsu|mmst|rtsp):\/\/([\w-]+\.)+[\w-]+(\/[^ \t\r\n{}\[\]`^<>\\\\]*)?$/i" , $url);
		//return  preg_match("/^(https?|ftp|mms|mmsu|mmst|rtsp):\/\/([\w-]+\.)+[\w-]+(\/[\w;\/?:@&=+$,# _.!~*'\"()%-]*)?$/i" , $url);
		//return preg_match("/^(http(s)|ftp):\/\/[a-z0-9\.\/_-]*?$/i" , $url);
	}

	/**
	 * 判断URL是否是新浪域的地址
	 * @return boolean
	 * @param string $url URL地址
	 */
	
	function is_sina_url($url)
	{
		//return preg_match("/^http:\/\/[a-z0-9_]*?.sina.com.cn[a-z0-9\.\/_-]*?$/i" , $url);
		return  preg_match("/^https?:\/\/([\w-]+\.)+sina.com.cn(\/[\w;\/?:@&=+$, _.!~*'\"()%-]*)?$/i" , $url);
	}
	
	//-- 判断字符串是否含有非法词汇 -------
	function check_badword($str, $bad_words)
	{
		//$str = strtolower($str);

		$words = split(',', $bad_words);

		for ($i = 0; $i < sizeof($words); $i++)
		{
			if (stristr($str, $words[$i]))
				return $words[$i];
		}
		return '';
	}

	/**
	 * 过滤字符串中的特殊字符
	 * @return string
	 * @param string $str 需要过滤的字符
	 * @param string $filtStr 需要过滤字符的数组（下标为需要过滤的字符，值为过滤后的字符）
	 * @param boolen $regexp 是否进行正则表达试进行替换，默认false
	 */
	
	function filt_string($str, $filtStr, $regexp = false)
	{
		if (!is_array($filtStr))
		{
			return $str;
		}
		$search		= array_keys($filtStr);
		$replace	= array_values($filtStr);
				
		if ($regexp)
		{
			return preg_replace($search, $replace, $str);
		}
		else
		{
			return str_replace($search, $replace, $str);
		}
	}

	/**
	 * 过滤/验证 指定的特殊字符
	 * @param string $str 要过滤的字符串
	 * @param bool $is_filt true:进行过 滤，false:验证字符  默认为false 
	 * @return 如果开启过滤，返回过滤后的字符， 如果是验证，true:为有特殊字符，false:无特殊字符
	 * @author shaocong  add by 2012-05-31
	 */
	function filter_special_string($str,$is_filt = false)
	{
		$filtStr = array('￥','!','@','#','*','$','%','^','&');
		if ($is_filt)
		{
			$filtStrS = array_fill_keys($filtStr, '');
			return string::filt_string($str, $filtStrS);
		}else
		{
			$bad_words = implode(",",$filtStr);
			return string::check_badword($str, $bad_words);
		}
	}	
	
	/**
	 * 过滤字符串中的HTML标记 < >
	 * @return string
	 * @param string $str 需要过滤的字符
	 */
	
	function un_html($str)
	{
			$s	= array(
				"&"     => "&amp;",
				"<"	=> "&lt;",
				">"	=> "&gt;",
				"\n"	=> "<br>",
				"\t"	=> "&nbsp;&nbsp;&nbsp;&nbsp;",
				"\r"	=> "",
		//		" "	=> "&nbsp;",
				"\""	=> "&quot;",
				"'"	=> "&#039;",
			);
		$str = string::esc_korea_change($str);
		$str = strtr($str, $s);
		$str = string::esc_korea_restore($str);
		return $str;
	}
	
	/**
	 * 过滤字符串的特殊字符，以便把数据存入mysql数据库
	 */
	function esc_mysql($str)
	{
		return mysql_escape_string($str);
	}

	/**
	 * 过滤字符串的特殊字符，以便把数据输出到页面做编辑显示
	 */
	function esc_edit_html($str)
	{
		$s	= array(
			//"&"     => "&amp;",
			"<"		=> "&lt;",
			">"		=> "&gt;",
			"\""	=> "&quot;",
			"'"		=> "&#039;",
		);
		$str = string::esc_korea_change($str);
		$str = strtr($str, $s);
		$str = string::esc_korea_restore($str);        
		return $str;
	}


	/**
	 * 过滤字符串的特殊字符，以便把数据输出到页面做输出显示
	 */
	function esc_show_html($str)
	{
		$s	= array(
			"&"     => "&amp;",
			"<"		=> "&lt;",
			">"		=> "&gt;",
			"\n"	=> "<br>",
			"\t"	=> "&nbsp;&nbsp;&nbsp;&nbsp;",
			"\r"	=> "",
			" "		=> "&nbsp;",
			"\""	=> "&quot;",
			"'"		=> "&#039;",
		);
		
		
		$str = string::esc_korea_change($str);
		$str = strtr($str, $s);
		$str = string::esc_korea_restore($str);
		return $str;
	}
	
	/**
	 * 把字符串中的韩文,转换为省略形态的韩文.eg:&#44444->__sina_#44444_word__
	 */
	function esc_korea_change($str)	
	{
		$str = preg_replace("/&(#\d{5});/", "__sina_\\1_word__", $str);
		return $str;
	}
	
	/**
	 * 把字符串中已经转换省略形态的韩文,恢复成韩文.eg:__sina_#44444_word__->&#44444
	 */
	function esc_korea_restore($str)	
	{
        $str = preg_replace("/__sina_(#\d{5})_word__/U", "&\\1;", $str);
		return $str;
	}
       
	function esc_ascii($str)
	{
		$esc_ascii_table = array(
   	    	chr(0),chr(1), chr(2),chr(3),chr(4),chr(5),chr(6),chr(7),chr(8),
   		    chr(11),chr(12),chr(14),chr(15),chr(16),chr(17),chr(18),chr(19),
      		chr(20),chr(21),chr(22),chr(23),chr(24),chr(25),chr(26),chr(27),chr(28),
        	chr(29),chr(30),chr(31)
		);


		$str = str_replace($esc_ascii_table, '', $str);
		return $str;
	}

	function esc_user_input($str)
	{
		//$str = iconv("utf-8", "gb2312", $str);
		$str = iconv("utf-8", "gbk//IGNORE", $str);
		// 过滤非法词汇

		// 过滤非法ASCII字符串
		$str = string::esc_ascii($str);

		// 过滤SQL语句	
		//$str = string::esc_mysql($str);
		

		return $str;
	}
	
	/**
	 * 过滤字符串中的<script ...>....</script>
	 * @return string
	 * @param string $str 需要过滤的字符
	 */
	 
	function un_script_code($str)
	{
		$s			= array();
		$s["/<script[^>]*?>.*?<\/script>/si"] = "";
		return string::filt_string($str, $s, true);
	}
	
	/**
	 * 把HTML代码转化ducument.write输出的内容
	 * @return string
	 * @param string $html 需要处理的HTML代码
	 */
	 
	function html2script($html)
	{
		//需要进行转义的字符
		$s			= array();
		$s["\\"]	= "\\\\";
		$s["\""]	= "\\\"";
		$s["'"]		= "\\'";
		$html = string::filt_string($html, $s);
		$html = implode("\\\r\n", explode("\r\n", $html));
		
		return "document.write(\"\\\r\n" . $html . "\\\r\n\");";
	}
	
	// 转义js输出，返回合法的js字符串
	function js_esc($str)
	{
		$s_tag = array("\\", "\"", "/", "\r", "\n");
		$r_tag = array("\\\\", "\\\"", "\/", "\\r", "\\n");
		$str = str_replace($s_tag, $r_tag, $str);

		return $str;
	}

	/**
	 * 把ducument.write输出的内容转化成HTML代码(必须是html2script函数进行转化的结果)
	 * @return string
	 * @param string $jsCode 需要处理的JS代码
	 */
	 	 
	function script2html($jsCode)
	{
		$html = explode("\\\r\n", $jsCode);
		array_shift($html);		//去掉数组开头单元
		array_pop($html);		//去掉数组末尾单元
		return implode("\r\n", $html);
	}

	static function length($str)
	{
		$str = preg_replace("/&(#\d{5});/", "__", $str);
		return strlen($str);
	}
	
}


class network
{
	static function check_url($url)
	{
		$url = strtolower($url);
		if (strpos($url, "http://") !== 0)
		{
			return false;
		}
		if (!string::is_http_url($url))
		{
			return false;
		}
	
		return true;
	}
	
	static function get($url)
	{
		if (!network::check_url($url))
		{
			return false;
		}

		
		$result = "";
		
		$context =
		array('http' =>
		      array('method' => 'GET',
		            'header' => 'Content-type: application/x-www-form-urlencoded'."\r\n".
		                        'User-Agent: Facebook API PHP5 Client 1.1 (non-curl) '.phpversion()."\r\n",
		            'content' => ""));
		$contextid=stream_context_create($context);
		$sock=fopen($url, 'r', false, $contextid);
		if ($sock) {
			$result='';
			while (!feof($sock))
				$result.=fgets($sock, 4096);
			
			fclose($sock);
		}		
		
		
		return $result;
	}
	
	static function curl_submit($url,$params_arr, $debug=false, $auth_user="", $auth_passwd="", $isfile = false)
	{
		if (!network::check_url($url))
		{
			return false;
		}
		
	    if(sizeof($params_arr)&&!empty($url))
	    {
	        $fields_string = "";
            if (is_array($params_arr))
	        {
		        foreach($params_arr as $key=>$value) 
		        { 
		            $fields_string .= $key.'='.urlencode($value).'&' ; 
		        }
		        $fields_string = rtrim($fields_string ,'&');
	        }
	        else 
	        {
	        	 $fields_string .= $params_arr; //urlencode($params_arr);
	        }
	        
	        
	        if ($debug)
	        {
	        	echo "<!-- {$url}?{$fields_string} -->\n";
	        }
	        
	        $ch = curl_init() ;
            if (strlen($auth_user) > 0)
	        {
		        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	        	curl_setopt($ch, CURLOPT_USERPWD, "{$auth_user}:{$auth_passwd}");  
	        }   

        	
	        // 如果是文件
            if ($isfile)
	        {
	        	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
	        }
	        
	        //set the url, number of POST vars, POST data
	        curl_setopt($ch, CURLOPT_URL,$url);
	        curl_setopt($ch, CURLOPT_POST,count($params_arr));
	        curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   

	        
	        //execute post
	        $data = curl_exec($ch);

	        //如果返回的结果不为空，表示有错误。
	        $err = curl_error($ch);
	        if(!empty($err))
	        {
	            return false;
	        }

	        $info = curl_getinfo($ch); 
        	
	        curl_close($ch); 
   	        return $data;
	        
	    }
	    else return false;
	}	
	
	
	static function curl_submit_cmd($url,$params_arr, $debug=false, $auth_user="", $auth_passwd="", $isfile = false)
	{
		if (!network::check_url($url))
		{
			return false;
		}
				
	    if(sizeof($params_arr)&&!empty($url))
	    {
	        $fields_string = "";
	        if (is_array($params_arr))
	        {
		        foreach($params_arr as $key=>$value) 
		        { 
		            $fields_string .= $key.'='.urlencode($value).'&' ; 
		        }
		        $fields_string = rtrim($fields_string ,'&');
	        }
	        else 
	        {
	        	 $fields_string .= urlencode($params_arr);
	        }
//var_dump($params_arr);
//var_dump($fields_string);
//exit;	        
	        $cmd = <<<ZZ
curl {$url} -u {$auth_user}:{$auth_passwd} -H "application/x-www-form-urlencoded" -d "{$fields_string}"
ZZ;
            if ($debug)
	        {
	        	echo "<!-- {$cmd} -->\n";
	        }	

	        
	        return system($cmd);
	    }
	    else return false;
	}	
	
	
	function file_get_contents($url)
	{		
		if (!network::check_url($url))
		{
			return false;
		}
		
		return file_get_contents($url);
	}
}


/**
 * SPACE 时间值转换类
 *
 */
define("TIME_FORMAT_MINITE", "%s分钟前");
define("TIME_FORMAT_TODAY", "今天 %s");
define("TIME_FORMAT_YESTODAY", "昨天 %s");
define("TIME_FORMAT_HISTORY", "%s年%s月%s日");
define("TIME_FORMAT_HISTORY_VISITOR", "%s月%s日");
define('TIME_FORMAT_CAPTION_TODAY','今天');
define('TIME_FORMAT_CAPTION_YESTODAY','昨天');
define('TIME_FORMAT_CAPTION_YEAR','年');
define('TIME_FORMAT_CAPTION_MONTH','月');
define('TIME_FORMAT_CAPTION_DAY','日');
define('TIME_FORMAT_CAPTION_HOUR','点');
define('TIME_FORMAT_CAPTION_MINITE','分');
define('TIME_FORMAT_CAPTION_SECOND','秒');
class TimeFormatter {
	public static function timeFormat($time) {
		$now = time();
		if(($dur = $now - $time) < 3600) {
			$minutes = ceil($dur / 60);
			if ($minutes<=0){
				$minutes = 1;
			}
			$time = sprintf(TIME_FORMAT_MINITE, $minutes);
		}else
		if(date("Ymd", $now) == date("Ymd", $time)) {
			$time = sprintf(TIME_FORMAT_TODAY, date("H:i", $time));
		}else{
			$time = sprintf(TIME_FORMAT_HISTORY, date("Y",$time),date("n",$time),date("j",$time)) . " " . date("H:i",$time);
		}
		return $time;
	}
	
	public static function timeFormatVisitor($time) {
		$now = time();
		if(($dur = $now - $time) < 3600) {
			$minutes = ceil($dur / 60);
			if ($minutes<=0){
				$minutes = 1;
			}
			$time = sprintf(TIME_FORMAT_MINITE, $minutes);
		}else
		if(date("Ymd", $now) == date("Ymd", $time)) {
			$time = sprintf(TIME_FORMAT_TODAY, date("H:i", $time));
		}else{
			$time = sprintf(TIME_FORMAT_HISTORY_VISITOR, date("n",$time),date("j",$time));
		}
		return $time;
	}

	public static function timeFormatArr($time) {
        $retime = array();
		$now = time();
		if (strpos($time,'-')!==false) {
			$time = strtotime($time);
		}
		if(($dur = $now - $time) < 3600) {
			$minutes = ceil($dur / 60);
			if ($minutes<=0){
				$minutes = 1;
			}
            $retime['date'] = TIME_FORMAT_CAPTION_TODAY;
			$retime['time'] = sprintf(TIME_FORMAT_MINITE, $minutes);
		}else
		if(date("Ymd", $now) == date("Ymd", $time)) {
            $retime['date'] = TIME_FORMAT_CAPTION_TODAY;
			$retime['time'] = date("H:i", $time);
		}else{
            $retime['date'] = date("n", $time).TIME_FORMAT_CAPTION_MONTH.date("j", $time).TIME_FORMAT_CAPTION_DAY;
			$retime['time'] = date("H:i", $time);
		}
		return $retime;
	}
}


class IP
{
	static function get_client_ip()
	{
		return $_SERVER['REMOTE_ADDR'];
	}
	static function get_server_ip()
	{
		return $_SERVER['SINASRV_DPMAIL_HOST'];   
	}
	
	static function get_client_ip_long()
	{
		// 解决32位机器负数问题 2010.04.28 caijian
		return sprintf("%u", ip2long(IP::get_client_ip()));
		//return ip2long(IP::get_client_ip());
	}
}

class php_to_perl
{
	//php数组转perl hash,生成字符串，需要eval
	//调用方法，直接调用php_array_to_perl_hash($array)
	 static function php_array_to_perl_hash($php_array,$in_array=0)
	 {
	 
		$return_val = "";
		$return_arr = "";
		if(!is_array($php_array)) return false;
		$return_val =  "{";
		foreach($php_array as $key=> $value)
		{
			$key = str_replace("@","\\@",$key);
			
			if(is_array($value))
			{
				
				$return_arr[] .= "'{$key}',". php_to_perl::php_array_to_perl_hash($value,1);
			}
			else
			{
				$value = str_replace("@","\\@",$value);
				$value = str_replace("'","",$value);
				$value = str_replace("\"","",$value);
				$return_arr[] .= "'{$key}','{$value}'";
				
			}
		}
		
		$return_val .= implode(" , ",$return_arr);
		$return_val .=  "}";

		return $return_val;
	}
	
}


//来源判断
class security_check
{
	
	static function check_refer($refer_array=array())
	{
		return true;
		global $config;
		
		if(isset($_GET["monitor_debug"]))
		{
			return true;
		}
		
		$url_array = parse_url($_SERVER['HTTP_REFERER']); 
		$host = $url_array["host"];
		//$all_array = array("henan.sina.com.cn","fj.sina.com.cn","sc.sina.com.cn","gd.sina.com.cn","city.sina.com.cn","zj.sina.com.cn");
		if(!$refer_array)
		{
			$refer_array = array("tv.com","yxxiu.com");
		}
		
		$is_checked = false;
		
		foreach($refer_array as $key => $value)
		{
			if($host == $value)
			{
				$is_checked = true;
				break;
			}
		}
		return $is_checked;
	} 
	
	
}


//规范化输出
class output
{
	static function json($t,$data,$call_back="")
	{
		if (function_exists("json_encode") === false)
		{
			echo "ERROR: NO JSON SUPPORT \n";
			exit;
		}
		
		$return_val = "";
		switch ($t){
			case "json":
				header('Content-type: application/json');
				$return_val =  json_encode($data);
			break;
			case "jsonp":
				header('Content-type: application/json');
				$return_val =  $call_back ."(".json_encode($data).")";
			break;
			default :
				$return_val =  json_encode($data);	
		}
		
			
		return 	$return_val;
	}
	

	
}

//php补丁类
class php_patch
{
	
	//php_crc32
	static function php_crc32($value)
	{
		
		return sprintf("%u", crc32($value));
		
	}
			
	
}

/**
 * 过滤标签
 * @author yangchaohi
 *
 */
class filtrate
{
	 static function filtrate_html($content)
	{
		$res = preg_replace("/<(\/?)(script|object|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isU","",$content);
		
		return $res;
	}
	
}
/**
 * 提交数据样式检查
 * @author yangchaohi
 *
 */
class html_style_limit
{
	/**
	 * 图片宽度限制
	 * @param $max_width 宽度最大值
	 * @param $max_width_persent 图片最大比例
	 * @param $height_check 是否高度需要缩放
	 */
	static function  image_width_limit($content,$max_width=700,$max_width_persent=100,$height_check = true)
	{
		$max_width = 700;
		//如果是百分比，最大百分比
		$max_width_persent = 100;
		preg_match_all("/(<img.*?width)([\D]*)([\d]*)(.*?>)/",$content,$match);
		//如果出现width
		if($match[3])
		{
			foreach($match[3] as $key => $value)
			{	//如果宽度使用百分比
				if(substr($match[4][$key],0,1) == "%")
				{
					if($value > $max_width_persent)
					{
						$max_width = $max_width_persent;
					}
				}
					
				if($value > $max_width )
				{
					//如果超过限制，替换图片内容
					$old_content = $match[1][$key].$match[2][$key].$match[3][$key].$match[4][$key];
					$new_content = $match[1][$key].$match[2][$key].$max_width.$match[4][$key];
					$content = str_replace($old_content,$new_content,$content);
					//如果有高度，高度需要等比缩放
					preg_match_all("/(<img.*?height)([\D]*)([\d]*)(.*?>)/",$new_content,$match1);
					if($match1[3])
					{
						foreach($match1[3] as $key1 => $value1)
						{
							$old_content = $match1[1][$key].$match1[2][$key].$match1[3][$key].$match1[4][$key];
							$height = $value1;
							$to_height = intval($height*$max_width/$match[3][$key]);
							$new_content = $match1[1][$key].$match1[2][$key].$to_height.$match1[4][$key];
							$content = str_replace($old_content,$new_content,$content);
					
						}
					}
					
				}
			}
			
		}
		else
		{
			$content = preg_replace("/<img(.*?)>/","<img style=\"max-width: {$max_width}px;\" \${1} >",$content);
			
		}
		return $content;
	}
	
	/**
	 * 内容字体大小控制
	 * @param $content
	 * @param $size
	 */
	static function word_font_limit($content,$size)
	{	
		//内容字体大小控制
		preg_match_all("/font([^<>]*?)([0-9]+?)px/",$content,$match);
		foreach($match[2] as $key => $value)
		{
			if($value > $size)
			{
				$content = str_replace($match[0][$key],"font".$match[1][$key].$size."px",$content);
			}
			
		}
		return $content;
	}
	
}




abstract class main
{
	public $g_show=array();
	public $g_cgival=array();
	
 	// 强制要求子类定义这些方法
    abstract protected function check_cgi_pro();
    abstract protected function get_data();
    
    
    public function show_pro($file_type="page",$tpl=""){
    	
    	$g_cgival = $this->g_cgival;
    	$g_show = $this->g_show;
    		
    	if($file_type =="interface")
    	{
    		
		    if ($g_cgival['t'] == "serialize")
			{
				echo serialize($g_show);
			}
			elseif ($g_cgival['t'] == "json")
			{
				echo output::json("json", $g_show, $g_cgival['callback']);
			}
			elseif($g_cgival['t'] == "jsonp")
			{
				echo output::json("jsonp", $g_show, $g_cgival['callback']);
			}
			elseif($g_cgival['t'] == "perl")
			{
				$string = php_to_perl::php_array_to_perl_hash($g_show);
				$string = mb_convert_encoding($string, "GBK", "UTF-8");
				echo $string;
			}
			elseif($g_cgival['t'] == "iframe")
			{
				header("location:{$g_cgival['link']}");
			}
			else
			{
				echo output::json("jsonp", $g_show, $g_cgival['callback']);
			}
    	}
    	elseif($file_type == "page")
    	{
    		
    		$smarty = p_get_smarty();	
			$smarty->assign("g_show", $g_show);
			if($tpl)
			{
				$smarty->display($tpl);
			}
			else
			{
	
				$tpl = substr($_SERVER["PHP_SELF"],1,strrpos($_SERVER["PHP_SELF"],"."))."html";
				
				if(stripos($_SERVER['PHP_SELF'],"/admin/") !== false)
				{
					$tpl = substr($tpl,6);
				}
				$smarty->display($tpl);
			}
			
    		
    	}
    	
		if (isset($_GET["debug"]))
		{
			echo "<pre>";
			print_r($g_show);
		}
    }

  
    public function main_do()
    {
	    try
		{
			$this->check_cgi_pro();
	    	$this->get_data();
	    	$this->g_show["error"] = 0;
		}
		catch(Exception $e)
		{
			$this->g_show["error"] = 1;
			$this->g_show["errmsg"] = $e->getMessage();
		}
		
	    $this->show_pro();	
    	
    }
    
    public function admin_check($check="")
    {
    	include_once($_SERVER['DOCUMENT_ROOT'] ."/core/admin.inc.php");
    	admin_check_login();
		if($check)
		{
			admin_check_user_priv($check);
		}
    	
    }
    
    
	
}


class size_format
{
	
	function normal_format($app_size)
	{
		if($app_size > 1000000)
		{
			$app_size = sprintf('%.1f',$app_size/1000000)    ."M";
		}
		elseif($app_size > 1000)
		{
			$app_size = sprintf('%.1f',$app_size/1000)    ."K";
		}
		else
		{
			$app_size = $app_size ."B";
		}
		
		return $app_size;
	}
	
}

?>
