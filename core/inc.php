<?php 
// core 配置文件
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/config/global_config.php");	
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/config/db_config.php");			// DB配置

include_once($_SERVER['DOCUMENT_ROOT'] ."/core/global_config/user_global_config.class.php");
// core 头文件
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/base/base.class.php");
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/base/page_bar.class.php");
include_once($_SERVER["DOCUMENT_ROOT"] ."/core/base/ajax_food_page.class.php");
include_once($_SERVER["DOCUMENT_ROOT"] ."/core/base/pic_upload.class.php");
include_once($_SERVER["DOCUMENT_ROOT"] ."/core/base/file_upload.class.php");
// core db and mc
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/base_dbmc/db.class.php");
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/base_dbmc/mem_cache.class.php");

// performance 
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/perf/db_performance.class.php");
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/perf/performance.php");

// smarty
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/smarty/Smarty.class.php");
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/smarty/smarty.inc.php");


// crotab控制
include_once($_SERVER['DOCUMENT_ROOT'] ."/core/crontab/inc.php");

?>