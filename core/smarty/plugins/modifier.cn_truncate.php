<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty cn_truncate modifier plugin
 *
 * Type:     modifier<br>
 * Name:     cn_truncate<br>
 * Purpose:  Truncate a string to a certain length if necessary,
 *           optionally splitting in the middle of a word, and
 *           appending the $etc string or inserting $etc into the middle.
 * @link http://smarty.php.net/manual/en/language.modifier.truncate.php
 *          truncate (Smarty online manual)
 * @param string
 * @param integer
 * @param string
 * @param boolean
 * @param boolean
 * @return string
 */
function smarty_modifier_cn_truncate($string, $length = 80, $etc = '...',
                                  $break_words = false, $middle = false)
{
    if ($length == 0)
        return '';
	return chinaSubstr($string,$length,$etc);
}
function chinaSubstr($str,$len='',$replace='...')
{	
		$str = str_replace("&nbsp;",' ',$str);
		$len = floor($len/2);
		return iconv_strlen($str,'utf-8') > $len ? iconv_substr($str,0,$len,'utf-8').$replace : $str;
		/*
		$oldLen = $len;
		if ( empty($len) || !is_int($len) ) return $str;
		if(strlen($str)<=$len) return $str;
		$temp = substr($str,0,$len);
		for ($i=0;$i<strlen($temp);$i++)
		{
			$chr = ord(substr($temp,$i,1));
			if($chr>=161 && $chr<=255)
			{}else {
				$j++;
			}	
		}
		if($len%2==0)
		{
			$len=$len - $j%2;
		}else {
			$len = $len - $j%2+$len%2;
		}
		$temp = substr($str,0,$len);
		return $len<strlen($str) ? $temp.$replace : $temp;
		*/
		/*
		$oldLen = $len;
		if ($len>strlen($str)) $len=strlen($str);
		if($len > strlen($str)) return $str;
		$j=0;
		for($i=0;$i<$len;$i++)
		{
			if(ord(substr($str,$i,1))>0xa0)
			{
				$j++;
				if ($i<($len-1))
				{
					$i++;
					$j++;
				}
			}
		}
		if($j%2!=0) $len++;
		$str=substr($str,0,$len);
		return $oldLen > $len ? $str:$str.$replace;
		*/
}
/* vim: set expandtab: */

?>









