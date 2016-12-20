<?php /* Smarty version 2.6.19, created on 2015-12-14 17:23:22
         compiled from admin_admin_group_user_list.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户组管理</title>
<link rel="stylesheet" type="text/css" href="style/main.css" />
<script language="javascript" type="text/javascript" src="js/base.js"></script>
</head>
<body>

<script  type="text/JavaScript">
function on_submit(uid)
{
	var gid = $("gid").value;
	var group_title = $('group_title').value;
	
    var postData = [];
    postData.push("gid=" + gid); 
    postData.push("group_title=" + group_title);
    
    SetAjax("admin_group_edit_post.php", "post:" + postData.join("&"), function(data){
        eval("var res = " + data);
        if(res.status == 0)
        {
        	alert("更新成功！");
            location.reload();
        }       
        else    
        {       
            alert(res.error);
        }       
    }, true);   
}
</script>

<div width='100%' style='text-align:left'>
	<a href="admin_group_list.php?gid=<?php echo $this->_tpl_vars['g_show']['gid']; ?>
">返回用户组列表</a>
	<a href="admin_group_user_list.php?gid=<?php echo $this->_tpl_vars['g_show']['gid']; ?>
">用户组成员列表</a>
	<a href="admin_group_priv_list.php?gid=<?php echo $this->_tpl_vars['g_show']['gid']; ?>
">用户组权限列表</a>
</div>
<div class="pages"><?php echo $this->_tpl_vars['g_show']['page_bar']; ?>
</div>
<div style='font-size:14px;margin:3px;color:#f00'>当前组：<?php echo $this->_tpl_vars['g_show']['group_name']; ?>
</div>
<form action='admin_group_user_edit_post.php' method='post' target='iframe_data'>
<input type='hidden' id='gid' name='gid' value='<?php echo $this->_tpl_vars['g_show']['gid']; ?>
' />
<table style='width:100%'>
  <tr align="center">
    <td width="20%"><b>用户ID</b></td>
    <td><b>用户名</b></td>
    <td><b>状态</b></td>
  </tr>
<?php echo $this->_tpl_vars['g_show']['list']; ?>
	
</table>
<br/>
<input type='submit' value=' 提 交 ' /> <input type='button' onclick='history.back(-1)' value=' 返 回 ' />
</form>

<iframe style='display:none' id='iframe_data' name='iframe_data' src='' />
<div class="pages"><?php echo $this->_tpl_vars['g_show']['page_bar']; ?>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

</body>
</html>