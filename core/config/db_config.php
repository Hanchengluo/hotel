<?php
//数据库配置


$config['db'] = array(
	"master"	=>	array(			//主库配置
						"type"		=>	"mysql",
						"host"		=>	"localhost",
						"port"		=>	3306,
						"user"		=>	"root",
						"passwd"	=>	"root",
						"dbname"	=>	"hotel_vvb",
						"charset"	=>	"utf8",
					),
	"slaver"	=>	array(			//从库配置，如果没有从库，可以删除不配置
						0	=>	array(			//主库配置
						"type"		=>	"mysql",
						"host"		=>	"localhost",
						"port"		=>	3306,
						"user"		=>	"root",
						"passwd"	=>	"root",
						"dbname"	=>	"hotel_vvb",
						"charset"	=>	"utf8",
						),
					)
);

$db_config_master = $config['db']['master'];
$db_config_slave  = $config['db']['slaver'][0];

//===========================================================================================
// 全局常量定义
//===========================================================================================

// memcache缓存时间
define("CACHE_EXPIRE_SEC_5",	5);						// 5秒
define("CACHE_EXPIRE_SEC_10",	10);					// 5秒
define("CACHE_EXPIRE_MIN_1",	60);					// 1分钟
define("CACHE_EXPIRE_MIN_5",	60*5);					// 5分钟
define("CACHE_EXPIRE_MIN_10",	60*10);					// 10分钟
define("CACHE_EXPIRE_MIN_30",	60*30);					// 半小时
define("CACHE_EXPIRE_HOUR",		60*60);					// 1小时
define("CACHE_EXPIRE_DAY",		60*60*24);				// 1天 
define("CACHE_EXPIRE_WEEK",		60*60*24*7);			// 1周 
define("CACHE_EXPIRE_MONTH",	60*60*24*30);			// 1月
define("CACHE_EXPIRE_YEAR",		60*60*24*365);			// 1年




?>
