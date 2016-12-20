一，注册说明：

初始化访问：
http://tv.com/app/initialization.php?mac=test4
mac为机器唯一标识。得到
{

    "password": "86985e105f79b95d6bc918fb45ec7727",
    "error": 0

}

这个密码需要保存在设备
使用设备的mac码和密码登录：
http://tv.com/app/login.php?mac=test4&password=86985e105f79b95d6bc918fb45ec7727
登录成功后会自动跳转到首页：
http://tv.com/app/index.php


二：页面调用数据接口
http://tv.com/interface/app/json_get_list_by_type.php
参数说明：
p表示分页数 pcount=9 表示一页显示几条，默认为9
type表示数据规则：type=new 按照添加时间倒序排	type=top 按照下载次数倒序排	type=hot 按照热度倒序排 默认为new
app_type表示app的分类，1 资讯阅读  2时尚休闲 等等，后台控制，默认为所有




三，目录权限
/cache/ 需要可读写权限 (缓存文件，smarty编译的中间文件等)
/data/ 需要可读写权限 保存图片和文件等（以后如果单独切分服务存储可以移走）
 

四,配置
数据库配置：/core/config/db_config.php 有主辅库两个配置，都需要填写






五，最新app_store说明：
app详细信息接口：
http://tv.com/interface/webstore/app_detail.php?id=pplleijocclbdbhmopmafjmhnpnhbkia
返回app详细信息:
app_update更新 接口：
方法1 直接跳转到下载地址
http://tv.com/webstore/update/crx/?x=id%3Dpplleijocclbdbhmopmafjmhnpnhbkia%26lan%3Dutf8%26uc%26v%3D1.1&response=redirect

方法2 输出rss
http://tv.com/webstore/update/crx/?x=id%3Dpplleijocclbdbhmopmafjmhnpnhbkia%26lan%3Dutf8%26uc%26v%3D1.1&response=rss
无uc接口
http://tv.com/webstore/update/crx/?x=id%3Dpplleijocclbdbhmopmafjmhnpnhbkia%26lan%3Dutf8%26v%3D1.1&response=rss

在线安装接口：
http://tv.com/interface/webstore/app_inlineinstall_detail.php?id=pplleijocclbdbhmopmafjmhnpnhbkia

六：广播接口 (显示所有的需要广播的app列表)
http://tv.com/interface/webstore/app_broadcast.php


七：下载接口
http://tv.com/interface/webstore/app_download.php?app_link=/data/file/0a/97/19/0a971950df6fb0fc6566c2e3efb27b33/0a971950df6fb0fc6566c2e3efb27b33.zip.crx
或者
http://tv.com/interface/webstore/app_download.php?id=ldofogjbihngiaohdoadlfkohdbdjhmk
这样的方法下载能把接口带上 Content-type: application-webos-extension

八 超级管理密码
admin sdpandsdp (超管功能比较粗)




新的需求
1，增加theme分类，它会有一个theme的obj，如果一个应用有这个theme，则允许它的分类是主题，否则不允许并提示。这个分类要在前端显示。theme的manifest如下：
{ "version": "2.6", 

  "name": "camo theme", 

  "theme": { 
          "images" : { "theme_frame" : "images/theme_frame_camo.png", "theme_frame_overlay" : "images/theme_frame_stripe.png",         "theme_toolbar" : "images/theme_toolbar_camo.png", "theme_ntp_background" : "images/theme_ntp_background_norepeat.png", "theme_ntp_attribution" : "images/attribution.png" }, 

          "colors" : { "frame" : [71, 105, 91], "toolbar" : [207, 221, 192], "ntp_text" : [20, 40, 0], "ntp_link" : [36, 70, 0],          "ntp_section" : [207, 221, 192], "button_background" : [255, 255, 255] }, 

          "tints" : { "buttons" : [0.33, 0.5, 0.47] }, 

          "properties" : { "ntp_background_alignment" : "bottom" } 
          }
}
2，上传的应用，如果是更新的，它的版本应该比数据库的上一个版本高，否则不让上传，并提示。

3，后台应该还有一个广播的分类，在选择某个应用广播后，它会出现在分类中，可以在这个地方删除和停止，删除后，它就不在这个分类中了，停止后不再广播了，但是还在这个分类中，以后点广播，还可以继续广播。这个选项在前端不显示。另外：广播是否改成推送比较好听点。
