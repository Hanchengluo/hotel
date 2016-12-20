<?php /* Smarty version 2.6.19, created on 2014-07-02 16:20:59
         compiled from admin_login.html */ ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台登录中心</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/css/admin/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="login-box">
	<div class="login-form">
   
    	<form name="" method="post" action="" id="form_login">
        	<ul>
        	<li><span>用户名</span><input type="text" id="username" name="username" class="login-txt" /></li>
        	<li><span>密码</span><input type="password" name="passwd"  id="passwd" class="login-txt login-psw" /></li>
            <li class="login-bnt"><input type="submit"  name="btn-login" id="form_login_submit" value="登录" /> <input type="reset" value="取消" /></li>
            </ul>
        </form>
    
    </div>
</div>
</body>
</html>

<link href="/admin/style/jqueryui/redmond/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#username").bind('focus', function() {
		if($("#username").val() == '请输入您的登录名称') {
			$("#username").val('');
		}
	});


	//表单提交事件
	$("#form_login").bind('submit', function() {
		$.post('login_submit.php', $("#form_login").serialize(), function(data) {
			if (data.status == 1) {
				alert(data.error)
			} else {
				//成功
				window.location.href="index.php";
			}
		}, 'json'); 
		return false;
	
	});
});

</script>