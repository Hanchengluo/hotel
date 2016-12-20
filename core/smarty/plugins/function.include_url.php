<?php
/**
 * Smarty plugin
 * 用于包含远程url地址
 * 
 * @author zijian
 * 2010/11/16
 */
function smarty_function_include_url($params, &$smarty)
{
     global $config;
     extract($params);
	
	 if (empty($url)) 
	 {
		 $smarty->trigger_error("special: missing 'url' parameter");
		 return;
	 }
	 
	 $key = sprintf(CACHE_PREFIX_SMARTY_PLUGIN_INCLUDE_URL , md5($url));
	 $mc = mem_cache::get_instance();
	 $cache = $mc->get($key);

	 if ($cache === false)
	 {
	 	 $content=network::file_get_contents($url);
	     $mc->set($key, serialize($content), 0, CACHE_TIME_SMARTY_PLUGIN_INCLUDE_URL);
	 }
	 else
	 {
	     $content = unserialize($cache);
	 }
	 
	 return $content;
}
?>