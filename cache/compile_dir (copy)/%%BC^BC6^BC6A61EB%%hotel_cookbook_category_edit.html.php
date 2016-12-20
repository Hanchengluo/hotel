<?php /* Smarty version 2.6.19, created on 2016-08-23 10:08:56
         compiled from hotel/hotel_cookbook_category_edit.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/css/admin/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery/jquery.js" charset="utf-8"></script>
<script language="javascript" type="text/javascript" src="/js/ad/uploader.js"></script>
<script language="javascript" type="text/javascript" src="/js/ad/tips.js"></script>
<script type="text/javascript" src="/admin/js/jquery.form.js" charset="utf-8"></script>

</head>
<body>
<div class="main">
	<div class="title-sp">
		<h2>添加分类</h2>
		<span class="l"></span>
		<span class="r"></span>
	</div>
	<div class="table-box">
		<div class="table-top">
			<a href="hotel_cookbook_category_list.php" class="button button_a">返回分类</a>
		</div>
		<div class="table-data-box">
			<form id="form1" method="post" enctype="multipart/form-data" action="hotel_cookbook_category_edit_post.php">
				<input type="hidden" value="<?php echo $this->_tpl_vars['g_show']['item']['id']; ?>
" name="id" id="id" />

				<table class="table-add-modify">
					<tr>
						<td class="label">分类名称<span class="require">*</span></td>
						<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['cookbook_category_name']; ?>
" name="cookbook_category_name" id="cookbook_category_name" /></td>
					</tr>
             
					<tr>
						<td></td>
						<td><input type="submit" value="提交" class="button form_submit" /> &nbsp; &nbsp; <input type="reset" value="重置" onclick="reset()" class="button" /></td>
					</tr>
				</table>
			</form>
		</div>
    
		<span class="l"></span>
		<span class="r"></span>
	</div>
</div>
</body>

<script>

$(".form_submit").bind("click", function () {
	if(!$("#cookbook_category_name").val())
	{
		alert("分类名称不能为空！");
		return false;
	}
	
	$("#my_form").submit();

} );
</html>