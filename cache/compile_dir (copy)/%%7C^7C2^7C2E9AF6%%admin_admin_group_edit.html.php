<?php /* Smarty version 2.6.19, created on 2016-03-29 11:06:35
         compiled from admin_admin_group_edit.html */ ?>
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
	<a href="admin_group_edit.php">添加用户组</a>
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
</body>
</html>