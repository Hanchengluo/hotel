<?php

/**
 * ajax分页处理类. 
 * @package base
 * @author 杨超
 * @version 1.0
 */


class Pages {
	private $sumRows = 0;		// 总行数
	private $sumpages = 0;		// 总页数
	private $page = 1;			// 当前要显示的页
	private $pageRows = 8;		// 每页显示的行数

	
	/**
	 * 构造函数
	 *
	 * @param int $sumRows
	 * @param int $page
	 * @param int $pageRows
	 * @return Pages
	 */
	function Pages($sumRows, $page, $pageRows = 20) {
		$this->sumRows = $sumRows;
		$this->page = $page;
		$this->pageRows = $pageRows;
		
		$this->getSumPages();
		
	}
	
	/**
	 * 获取总页数
	*/
	function getSumPages() {
		$this->sumPages = ceil($this->sumRows / $this->pageRows);
	}
	
	
	/**
	 * 返回$links个页码链接的首尾页码数
	*/
	function links($links = 8) {
		if ($this->sumRows < 1) {
			return false;
		}
		if ($this->sumPages <= $links) {
			$link['start']=1;
			$link['last']=$this->sumPages;
			return $link;
		}
		$link['start'] = ($this->page > 3) ? $this->page - 2 : 1;
		if ($this->page >= $this->sumPages) {
			$link['start'] = $this->sumPages - $links + 1;
			if ($link['start'] < 1) {
				$link['start'] = 1;
			}
			$link['last'] = $this->sumPages;
			return $link;
		}
		$link['last'] = $link['start'] + $links - 1;
		if ($link['last'] > $this->sumPages) {
			$link['last'] = $this->sumPages;
		}
		/*if ($link['last'] - $link['start'] < $links && ($link['last'] - $links + 1) > 0) {
			$link['start'] = $link['last'] - $links + 1;
		}*/
		return $link;
	}
	
	/**
	 * 获得链接页码数组
	 * links() 函数返回的首尾页码
	 * @return array
	*/
	function getLinkArray($link) {
		$links = array();
		if (is_array($link)) {
			$j = 0;
			for ($i = $link['start']; $i <= $link['last']; $i++) {
				$links[$j] = $i;
				$j++;
			}
		}
		return $links;
	}
		
	/**
	 * 效果：首页  <<上一页  1  [2]  [3]  下一页>> 末页
	 * 返回处理好的HTML 链接
	 * $url string
	 * $links int 最多显示页码链接数
	 * return string
	*/
	function getLinks($url, $links = 8) {
		if ($this->sumPages <= 1) return false;
		$link = $this->links($links);
		$links='';
		if($this->page > 1)
		{
			//$links = '<a href="' . $url . '1" class="first-page">首页</a>';
			$links .= '<a  class="prev"  href="' . $url . (($this->page - 1) ? ($this->page - 1) : '1') . '"  >上一页</a>';
			
		}
		
		for ($i = $link['start']; $i <= $link['last']; $i++) {
			if ($i == $this->page) {
				$links .= '<a class="cur" href="#">' . $i . '</a>';
			} else {
				$links .= '<a href="' . $url . $i . '" class="num-page">' . $i . '</a>';
			}
		}
		$links .= '<a href="' . $url . ((($this->page + 1) > $this->sumPages) ? $this->sumPages : ($this->page + 1)) . ' " class="next">下一页</a>';
		//$links .= '<a href="' . $url . $this->sumPages . '" class="last-page">末页</a>';
		//$links .= '<span class="total-page">共<span class="num-total">'.$this->sumPages .'</span>页</span>';
		     

		/*if($this->page < $this->sumPages )		
		{						
			$links .= '<span class="goto">转到第<input type="text" class="input-text-goto" style="height:17px;" />页</span>';
			$links .= '<a class="submit ajax_page_submit" href="'.$url.'">提交</a>';
		}*/

		return $links;
	}
	
                    
                    
	function getLinks_admin($url, $links = 8) {
		if ($this->sumPages <= 1) return false;
		$link = $this->links($links);
		$links='<td class="page tc">';
		if($this->page > 1)
		{
			//$links = '<a href="' . $url . '1" class="first-page">首页</a>';
			$links .= '<a  class="prev"  href="' . $url . (($this->page - 1) ? ($this->page - 1) : '1') . '"  >上一页</a>';
			
		}
		
		for ($i = $link['start']; $i <= $link['last']; $i++) {
			if ($i == $this->page) {
				$links .= '<a class="cur" href="#">' . $i . '</a>';
			} else {
				$links .= '<a href="' . $url . $i . '" class="num-page">' . $i . '</a>';
			}
		}
		$links .= '<a href="' . $url . ((($this->page + 1) > $this->sumPages) ? $this->sumPages : ($this->page + 1)) . ' " class="next">下一页</a>';
		

		$links .='
		</td><td width="50%" style="padding-left:20px;">
                    	<form method="post" action="'.$url.'"><input type="text" name="p" class="txt vm" size="2" />页<input type="submit"  value="go" class="vm" /></form>
                    </td>
		';
		return $links;
	}

}
?>