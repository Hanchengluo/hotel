<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty unhtmlentities modifier plugin
 *
 * Type:     modifier<br>
 * Name:     unhtmlentities<br>
 * Purpose:  Truncate a string to a certain length if necessary,
 *           optionally splitting in the middle of a word, and
 *           appending the $etc string or inserting $etc into the middle.
 * @link http://smarty.php.net/manual/en/language.modifier.truncate.php
 *          unhtmlentities (Smarty online manual)
 * @param string
 * @return string
 * 去掉转义后的html符号
 */
 function smarty_modifier_unhtmlentities($string)
 {
	 //if(phpversion()>4.3.0)
	 //{
		 return html_entity_decode($string);
		 /*
	 }else{
		$trans_tbl = get_html_translation_table(HTML_ENTITIES);
		$trans_tbl = array_flip($trans_tbl);
		return strtr($string, $trans_tbl);
	 }
	 */
 }

/* vim: set expandtab: */

?>









