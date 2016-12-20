<?php
/**
 * Smarty plugin
 * 用于包含各占的特殊文件（spacial.xxx.html）
 * 
 * 产品模板统一放在tpl/产品名称 目录下
 * 各个地方站模板文件凡有需要区分的地方，统一将不同之处剪切出来另建新文件，
 * 放入tpl/产品目录/相应站点名称英文短名(在global_config文件内由$config['site_shortname'][$site_id]定义) 目录下，
 * 并按照special.xxx.html的格式命名
 * 在需要引入specail文件的地方统一调用此smarty插件函数，模板代码调用格式为{special file="xxx"}
 * 例如：
 * {special file="keywords"}
 * 在河南站下将自动引入并编译 hn/special.keywords.html文件，
 * 在广东站下将自动引入并编译 gd/special.keywords.html文件
 * 
 * @author zijian
 * 2010/11/16
 */
function smarty_function_include_special($params, &$smarty)
{
     global $config;
     extract($params);
	
	 if (empty($file)) 
	 {
		 $smarty->trigger_error("special: missing 'file' parameter");
		 return;
	 }
	
	 $file_name=$config['site_shortname'][$config['current_site_id']].'/special.'.$file.'.html';
	 $smarty->display($file_name);
}
?>