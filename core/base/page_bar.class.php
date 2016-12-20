<?php
/**
 * 分页栏处理类
 * @package baseLib
 * @author 刘程辉 <shijun@staff.sina.com.cn>
 * @version 1.0
 * @copyright (c) 2005, 新浪网研发中心 All rights reserved.
 * @example ./page_bar.class.php 查看源代码
 * @example ./page_bar.example.php 如何使用请点这里
 */
class page_bar
{

	/**
	 * 分页时取得最大页
	 * @param $num			总计条数
	 * @param $perpage		单页条数
	 * @param $curpage		当前页
	 * @param $maxpages		允许的最大页
	 * @param $page
	 * @return unknown_type
	 */
	static function get_page_max($num, $perpage)
	{
		return ceil($num/$perpage);
	}
		
	
	/**
	 * 生成上一页，下一页的分页栏
	 * @return string;
	 * @param   array  $style 固定的数组格式，格式参考
     * 
     * $style = array(
     * 	'curt'		=> $_GET['p'],							// 当前页号
     * 	'max'		=> 20,									// 最大页号
     * 	'key'		=> 'p',									// 页号CGI的参数KEY
     * 	'up'		=> '上一页',							// 向上翻页的文字样式
     * 	'down'		=> '下一页',							// 向下翻页的文字样式
     * 	'tmpl'		=> '<a href="%s">%s</a>',				// 翻页链接的样式
     * 	'format'	=> '<<&nbsp;%s&nbsp;&nbsp;%s&nbsp;>>' 	// 最后输出的样式
     * );
     * 本函数必须传递的几个键值 curt, max。其余参数不填设置为默认项
	 */
	
	static function bar1($style)
	{
		if(! isset($style['curt']) && ! is_numeric($style['curt']) && 
		   ! isset($style['max']) && ! is_numeric($style['max']) && 
		   ($style['curt'] > $style['max']))
		{
			return false;
		}

		$style['key'] 		= isset($style['key']) ? $style['key'] : 'p';
		$style['up'] 		= isset($style['up']) ? $style['up'] : '上一页';
		$style['down'] 		= isset($style['down']) ? $style['down'] : '下一页';
		$style['tmpl'] 		= isset($style['tmpl']) ? $style['tmpl'] : '<a href="%s">%s</a>';
		$style['format'] 	= isset($style['format']) ? $style['format'] : '<<&nbsp;%s&nbsp;&nbsp;%s&nbsp;>>';

		if( ! isset($style['curt']) && !is_numeric($style['curt']) && $style['curt'] < 1)
		{
			$style['curt'] = 1;
		}
	    $pre_url = page_bar::_repl_cgi($style['key'], ($style['curt'] - 1));

	    $nex_url = page_bar::_repl_cgi($style['key'], ($style['curt'] + 1));

		$pre_txt = ($style['curt'] > 1) ? sprintf($style['tmpl'], $pre_url, $style['up']) : $style['up'];

		$nex_txt = ($style['curt'] < $style['max']) ? sprintf($style['tmpl'], $nex_url, $style['down']) : $style['down'];

	    if ($style['curt'] >= 1)
	    {
	        return sprintf($style['format'], $pre_txt, $nex_txt); 
	    }
	}

	/** 
	 * 生成分页导航栏：导航栏样式 "第8页 共60页 &laquo;第一个 < 4 5 6 7 8 9 10 11 12 > 最后的&raquo; "
	 * @return 	string
	 * @param	integer	$curt_page	当前页
	 * 			integer	$max_page	最大页
	 *			integer	$step_len	当前页的前后显示页的数量，缺省值为4
	 */
	static function bar2($style)
	{
		if(! isset($style['curt']) && ! is_numeric($style['curt']) && 
		   ! isset($style['max']) && ! is_numeric($style['max']) && 
		   ($style['curt'] > $style['max']))
		{
			return false;
		}

		$style['key'] 		= isset($style['key']) ? $style['key'] : 'p';
		$style['len'] 		= isset($style['len']) ? $style['len'] : 4;
		$style['up'] 		= isset($style['up']) ? $style['up'] : '1...';
		$style['down'] 		= isset($style['down']) ? $style['down'] : '...' . $style['max'];

		$pre_bar = "";
		$end_bar = "";
		$bar = "";
		if ($style['max'] > 1)
		{
			$this_begin = page_bar::_bar2_pre_step($style['curt'], $style['len']);
			$this_end 	= page_bar::_bar2_next_step($style['curt'], $style['len'], $style['max']);
			for ($i = $this_begin; $i <= $this_end; $i++)
			{
				if ($i == $style['curt'])
				{
					$bar .= page_bar::_bar2_curt_page_style($i);
				}
				else
				{
					$bar .= page_bar::_bar2_page_style($style['key'], $i);
				}
			}

			if($style['curt'] > 1)
			{
				$pre_bar = page_bar::_bar2_page_style($style['key'], $style['curt'] - 1 , "上一页");
				if ($this_begin > 1)
				{
					$pre_bar = $pre_bar . page_bar::_bar2_page_style($style['key'], 1, $style['up']) ;

				}
			}
			if($style['curt'] < $style['max'])
			{
				$end_bar =  page_bar::_bar2_page_style($style['key'], $style['curt'] + 1 , "下一页");

				if ($this_end < $style['max'])
				{
					$end_bar = page_bar::_bar2_page_style($style['key'], $style['max'],  $style['down']) . $end_bar;
				}
				
			}
		}
		elseif ($style['max'] == 1)
		{
			$bar  = page_bar::_bar2_curt_page_style("1");
		}
		
		return $pre_bar . $bar . $end_bar;
	}

	/**
	 * BAR2 生成当除当前页外的其他页面的链接
	 * @param integer	$num	页号
	 * 		  string	$txt	页号需要显示的内容,缺省值为页号
	 */
	static function _bar2_page_style($key, $num, $txt = "")
	{
		if ($txt == "")
		{
			return "<a href=\"" . page_bar::_repl_cgi($key, $num) . "\">{$num}</a>&nbsp;";
		}
		else
		{
			return "<a href=\"" . page_bar::_repl_cgi($key, $num) . "\">{$txt}</a>&nbsp;";
		}
	}

	/**
	 * BAR2 生成当前页的链接
	 * @param integer	$num	页号
	 */
	static function _bar2_curt_page_style($num)
	{
		return "<a class=\"cur\" href=\"javascript:void(0);\">{$num}</a>";
	}

	/**
	 * 取向前$len页的页号
	 * @param integer	$curt	当前页号
	 * 		  integer	$len	向前的长度
	 */
	static function _bar2_pre_step($curt, $len)
	{
		return ($curt - $len < 1) ? 1 : ($curt - $len);
	}

	/**
	 * 取向后$len页的页号
	 * @param integer	$curt	当前页号
	 * 		  integer	$len	向前的长度
	 *		  integer	$end	最大页号
	 */
	static function _bar2_next_step($curt, $len, $end)
	{
		return ($curt + $len > $end) ? $end : ($curt + $len);
	}


	/** 
	 * 生成分页导航栏：导航栏样式 "上十页 1 2 3 4 5 6 7 8 9 下十页"
	 * @return 	string
	 * @param	integer	$curt_page	当前页
	 * 			integer	$max_page	最大页
	 *			integer	$step_len	当前页的前后显示页的数量，缺省值为4
	 */
	static function bar3($style,$bdate="",$edate="")
	{
		if(! isset($style['curt']) && ! is_numeric($style['curt']) && 
		   ! isset($style['max']) && ! is_numeric($style['max']) && 
		   ($style['curt'] > $style['max']))
		{
			return false;
		}
		
		$style['key'] 		= isset($style['key']) ? $style['key'] : 'p';
		$style['len'] 		= isset($style['len']) ? $style['len'] : 10;
		$style['up'] 		= isset($style['up']) ? $style['up'] : '&laquo;';
		$style['down'] 		= isset($style['down']) ? $style['down'] : '&raquo;';
		
		if ($style['max'] > 1)
		{
			$this_begin = page_bar::_bar3_pre_step($style['curt'], $style['len']);
			$this_end 	= page_bar::_bar3_next_step($this_begin, $style['len'], $style['max']);
			for ($i = $this_begin; $i <= $this_end; $i++)
			{
				if ($i == $style['curt'])
				{
					$bar .= page_bar::_bar3_curt_page_style($i);
				}
				else
				{
					$bar .= page_bar::_bar3_page_style($style['key'], $i, "", $bdate, $edate);
				}
			}
			if($this_begin > $style['len'])
			{
				$pre_bar = page_bar::_bar3_page_style($style['key'], $this_begin - $style['len'], $style['up']);
			}
			if($this_end < $style['max'])
			{
				$end_bar = page_bar::_bar3_page_style($style['key'], $this_begin + $style['len'], $style['down']);
			}
		}
		else if ($max_page = 1)
		{
			$bar  = page_bar::_bar3_curt_page_style("1");
		}
		return $pre_bar . $bar . $end_bar;
	}

	static function bar4($style)
	{
		if(! isset($style['curt']) && ! is_numeric($style['curt']) && 
		   ! isset($style['max']) && ! is_numeric($style['max']) && 
		   ($style['curt'] > $style['max']))
		{
			return false;
		}

		$style['key'] 		= isset($style['key']) ? $style['key'] : 'p';
		$style['up'] 		= isset($style['up']) ? $style['up'] : '上一页';
		$style['down'] 		= isset($style['down']) ? $style['down'] : '下一页';
		$style['tmpl'] 		= isset($style['tmpl']) ? $style['tmpl'] : '<a href="%s">%s</a>';
		$style['format'] 	= isset($style['format']) ? $style['format'] : '<<&nbsp;%s&nbsp;&nbsp;%s&nbsp;>>';

		if( ! isset($style['curt']) && !is_numeric($style['curt']) && $style['curt'] < 1)
		{
			$style['curt'] = 1;
		}
	    $pre_url = page_bar::_repl_cgi($style['key'], ($style['curt'] - 1));

	    $nex_url = page_bar::_repl_cgi($style['key'], ($style['curt'] + 1));

		$pre_txt = ($style['curt'] > 1) ? sprintf($style['tmpl'], $pre_url, $style['up']) : $style['up'];

		$nex_txt = ($style['curt'] < $style['max']) ? sprintf($style['tmpl'], $nex_url, $style['down']) : $style['down'];

	    if ($style['curt'] >= 1)
	    {
	        return sprintf($style['format'], $pre_txt, $style['curt'], $style['max'], $nex_txt); 
	    }
	}

	/**
	 * 生成当除当前页外的其他页面的链接
	 * @param string	$key	页号的CGI KEY值
	 *		  integer	$num	页号
	 * 		  string	$txt	页号需要显示的内容,缺省值为页号
	 */
	static function _bar3_page_style($key, $num, $txt = "", $bdate="", $edate="")
	{
		if ($txt == "")
		{
			if(!empty($bdate) && !empty($edate))
			{
				$data_str = "&bdate={$bdate}&edate={$edate}";
			}
			return "<a href=\"" . page_bar::_repl_cgi($key, $num) . "{$data_str}\">{$num}</a>&nbsp;";
		}
		else
		{
			if(!empty($bdate) && !empty($edate))
			{
				$data_str = "&bdate={$bdate}&edate={$edate}";
			}
			return "<a href=\"" . page_bar::_repl_cgi($key, $num) . "{$data_str}\">{$txt}</a>&nbsp;";
		}
	}

	/**
	 * 生成当前页的链接
	 * @param integer	$num	页号
	 */
	static function _bar3_curt_page_style($num)
	{
		return "<span style=\"color:red;font-weight:bold;\">{$num}</span>&nbsp;";
	}

	/**
	 * 取向前$len页的页号
	 * @param integer	$curt	当前页号
	 * 		  integer	$len	向前的长度
	 */
	static function _bar3_pre_step($curt, $len)
	{
		if ($curt % $len)
		{
			$pre = floor($curt / $len) * $len;
		}
		else
		{
			$pre = (floor($curt / $len) - 1) * $len;
		}
		return (int)$pre + 1;
	}

	/**
	 * 取向后$len页的页号
	 * @param integer	$curt	当前页号
	 * 		  integer	$len	向前的长度
	 *		  integer	$end	最大页号
	 */
	static function _bar3_next_step($curt, $len, $end)
	{
		return ($curt + $len > $end) ? $end : ($curt + $len - 1);
	}

	/**
	 * 替换CGI参数，如果CGI中参数存在则替换该值，如果不存在则在CGI末尾添加
	 * @return string;
	 * @param   string  key cgi参数key
	 *          string  val cgi参数key的对应值
	 */
	static function _repl_cgi($key, $val)
	{
        global $host_string, $query_string;
        
        $sname  = $_SERVER['SCRIPT_NAME'];
        $qstr   = $_SERVER['QUERY_STRING'];
        $qarry  = array();
        
        if($qstr == "")
        {
            return $sname . "?{$key}={$val}";
        }

        parse_str($qstr, $qarry);

        if (array_key_exists($key, $qarry))
        {
            $qarry[$key] = "{$val}";
            $new_qstr = "?";
            foreach ($qarry as $k => $v)
            {
            	$k = htmlentities($k);
            	$v = htmlentities(urlencode($v));
				$new_qstr .= $k . "=" . $v . "&";
            }
            $new_qstr = rtrim( $new_qstr, "&");
            return $sname . $new_qstr;
        }
        return $sname . "?" . $qstr . "&{$key}={$val}";
	}
}

class static_page_bar
{
	private $record_count; //总记录数
	public $page_size; //每页记录数
	private $curren_page; //当前页
	private $page_count; //总页数
	private $page_url; //页面url
	public $page_limit; //显示页码数
	public $ext=null;

	function __construct($arg)//构造函数
	{
		$this->record_count = $arg['count'] ? $arg['count'] : 0;
		$this->page_size = $arg['size'] ? $arg['size'] : 10;
		$this->curren_page = $arg['cur'] ? $arg['cur'] : 1;
		$this->page_limit = $arg['len'] ? $arg['len'] : 4;
		$this->page_url = $arg['url'];

		if($this->curren_page<1) $this->curren_page = 1; //当前页小于1的时候，，值赋值为1
		$this->page_count = ceil($this->record_count / $this->page_size);//总页数
		if($this->page_count<1) $this->page_count=1;
		if($this->curren_page > $this->page_count) $this->curren_page = $this->page_count;
	}

	public function urlReplace($page) //地址替换
	{
		$page = $page ? $page : 1;
		return str_replace("{p}", $page, $this->page_url);
	}

	public function setExtend($ext)
	{
		if($this->page_count > 1)
		{
			$this->ext = $ext;
		}
	}

	private function singlePage($page,$text=null) //生成单个页码
	{
		$text = $text ? $text : $page;
		if($this->curren_page != $page){
			return "<a href=\"".$this->urlReplace($page) ."\">{$text}</a>";
		}else{
			return '<span class="cur">'.$text.'</span>';
		}
	}

	private function prevStep($cur, $len) //取起始页码
	{
		return ($cur - $len < 1) ? 1 : ($cur - $len);
	}

	private function nextStep($cur, $len, $end)  //取结束页码
	{
		return ($cur + $len > $end) ? $end : ($cur + $len);
	}
	
	function output() //输出
	{
		$list = $prev = $next = '';

		if($this->page_count > 1)
		{
			$begin = $this->prevStep($this->curren_page, $this->page_limit);
			$end = $this->nextStep($this->curren_page, $this->page_limit, $this->page_count);

			for($i=$begin; $i <= $end; $i++){							//页码显示
				$list .=$this->singlePage($i);
			}

			if($this->curren_page > 1)										//前翻
			{
				$prev .= $this->singlePage($this->curren_page - 1 , '上一页');
				if($begin > 1)
				{
					$prev .= $this->singlePage(1 , '1');
					if($begin != 2)									// 如果跨度超过1，则增加省略号
					{
						$prev .= '<span>...</span>';
					}
				}
			}

			if($this->curren_page < $this->page_count)									//后翻
			{
				if($end < $this->page_count)
				{
					if($end + 1 != $this->page_count)				// 如果跨度超过1，则增加省略号
					{
						$next .= '<span>...</span>';
					}
					$next .= $this->singlePage($this->page_count , $this->page_count);
				}
				 $next .= $this->singlePage($this->curren_page + 1 , '下一页');
			}
		}
		else
		{
			$this->singlePage(1);
		}

		$res = $prev . $list . $next;

		if($this->ext) $res .= $this->ext;

		return $res;

	}
}
/*-------------------------实例--------------------------------*
$arg = array('count'=>200,'size'=>10,'cur'=>$_GET['p'],'url'=>'list-{p}.html');
$page = new static_page_bar($arg);//用于静态或者伪静态
$ext = '<em>到第<input type="text" id="pturn" name="p" onmouseover="javascript:this.focus();" value="" />页<a id="turn" href="javascript:void(0)" onclick="location=\'' . $page->urlReplace("'+document.getElementById('pturn').value+'").'\';return false;">跳转</a></em>';
$page->setExtend($ext);
echo $page->output();//显示
*/
/**
 * 用于静态化页面的分页
 * @author dongping
 *
 */
class page_static_bar
{
	/**
	 * 生成用于静态化后页面的分页，如：
	 * <a href='/index_7.html'>上一页</a>&nbsp;
	 * <a href='/index_3.html'>3</a>&nbsp;
	 * <a href='/index_4.html'>4</a>&nbsp;
	 * <a href='/index_5.html'>5</a>&nbsp;
	 * <a href='/index_6.html'>6</a>&nbsp;
	 * <a href='/index_7.html'>7</a>&nbsp;
	 * <a href='/index_8.html'>[8]</a>&nbsp;
	 * <a href='/index_9.html'>9</a>&nbsp;
	 * <a href='/index_10.html'>10</a>&nbsp;
	 * <a href='/index_11.html'>11</a>&nbsp;
	 * <a href='/index_12.html'>12</a>&nbsp;
	 * <a href='/index_13.html'>13</a>&nbsp;
	 * <a href='/index_9.html'>下一页</a>&nbsp;
	 * 
	 * @param $news_count		新闻总条数		500
	 * @param $p				当前页			8
	 * @param $pcount			每页新闻个数		40
	 * @param $url				页面URL			index.html
	 * @param $page_area_count	在页面中显示几个页码	10
	 */
	function bar_static_page($news_count, $p, $pcount, $url, $page_area_count=10)
	{
		$ary = array();
		
		$page_count = intval($news_count / $pcount);
		if ($page_count == 0)
		{
			$page_count = 1;
		}
		$ary["news_count"] = $news_count;
		$ary["p"] = $p;
		$ary["page_count"] = $page_count;
		if ($p > 1)
		{
			if ($p == 2)
			{
				$ary["pp"][] = array("title"=>"上一页", "url"=> "/" . $url);
			}
			else
			{
				$ary["pp"][] = array("title"=>"上一页", "url"=> "/" . str_replace(".html", "_" . ($p-1) . ".html", $url));
			}
		}
	
		$page_area_count_half = intval($page_area_count / 2);
		$page_start = $p - $page_area_count_half > 0 ? $p - $page_area_count_half : 1;
		$page_end = ($p + $page_area_count_half) > $page_count ? $page_count: ($p + $page_area_count_half);
	//	echo "<!-- {$page_area_count} - {$page_area_count_half} -->\n";
	//	echo "<!-- {$page_start} - {$page_end} -->\n";
		if ($page_end - $page_start < $page_area_count)
		{
			if ($page_end + $page_area_count_half > $page_count)
			{
				$page_end = $page_count;
			}
			else
			{
				$page_end = $page_start + $page_area_count;
			}
		}
	//	echo "<!-- {$page_start} - {$page_end} -->\n";
		for($i = $page_start; $i <= $page_end; $i ++)
		{
			$x["p"] = $i;
			$x["title"] = $i;
			if ($i != 1)
			{
				$x["url"] = "/" . str_replace(".html", "_" . $i . ".html", $url);
			}
			else
			{
				$x["url"] = "/" . $url;
			}
			$ary["pp"][] = $x;
		}
		if ($p < $page_count)
		{
			$ary["pp"][] = array("title"=>"下一页", "url"=> "/" . str_replace(".html", "_" . ($p+1) . ".html", $url));
		}
		
		return $ary;
	}	
}
?>