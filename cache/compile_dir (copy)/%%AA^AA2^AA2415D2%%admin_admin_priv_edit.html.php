<?php /* Smarty version 2.6.19, created on 2015-12-11 17:51:47
         compiled from admin_admin_priv_edit.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>编辑权限</title>
<link rel="stylesheet" type="text/css" href="style/main.css" />
<script language="javascript" type="text/javascript" src="js/base.js"></script>
</head>
<body>

<script  type="text/JavaScript">
function on_submit()
{

	var pid = $("pid").value;
	var priv_name = $("priv_name").value;
	var priv_link = $("priv_link").value;
	var priv_order = $("priv_order").value;
	var is_show = $("is_show").value;
	var parent_name = $("parent_name").value;
	var status = $("status").value;
	
    var postData = [];
    postData.push("pid=" + pid);
    postData.push("priv_name=" + priv_name); 
    postData.push("priv_link=" + priv_link); 
    postData.push("priv_order=" + priv_order); 
    postData.push("is_show=" + is_show); 
    postData.push("parent_name=" + parent_name); 
    postData.push("status=" + status); 
    
    SetAjax("admin_priv_edit_post.php", "post:" + postData.join("&"), function(data){
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
</div>
<div class="pages"><?php echo $this->_tpl_vars['g_show']['page_bar']; ?>
</div>

<table style='width:100%'>
  <tr align="center">
    <td><b>项目</b></td><td><b>值</b></td>
<?php echo $this->_tpl_vars['g_show']['list']; ?>
	
  </tr>

</table>

<div class="pages"><?php echo $this->_tpl_vars['g_show']['page_bar']; ?>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

</body>
</html>