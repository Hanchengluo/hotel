<?php /* Smarty version 2.6.19, created on 2015-12-14 17:23:08
         compiled from admin_admin_user_edit.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户帐号管理</title>
<link rel="stylesheet" type="text/css" href="style/main.css" />
<script language="javascript" type="text/javascript" src="js/base.js"></script>
</head>
<body>

<script  type="text/JavaScript">
function on_submit(uid)
{
	var uid = $("uid").value;
	var user_name = $('user_name').value;
	var user_passwd = $('user_passwd').value;
	var site_id = $('site_id').value;
	
    var postData = [];
    postData.push("uid=" + uid); 
    postData.push("user_name=" + user_name);
    postData.push("user_passwd=" + user_passwd);
    postData.push("site_id=" + site_id);
    
    SetAjax("admin_user_edit_post.php", "post:" + postData.join("&"), function(data){
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
	<a href="admin_user_list.php">所有用户</a>
	<a href="admin_user_edit.php">添加用户</a>
</div>
<div class="pages"><?php echo $this->_tpl_vars['g_show']['page_bar']; ?>
</div>

<table style='width:100%'>
  <tr align="center">
    <td width="20%"><b>项目</b></td>
    <td><b>值</b></td>
  </tr>
<?php echo $this->_tpl_vars['g_show']['list']; ?>
	
</table>
<div class="pages"><?php echo $this->_tpl_vars['g_show']['page_bar']; ?>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

</body>
</html>