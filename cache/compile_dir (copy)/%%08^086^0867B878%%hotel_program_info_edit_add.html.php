<?php /* Smarty version 2.6.19, created on 2016-08-23 10:09:55
         compiled from hotel/hotel_program_info_edit_add.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/css/admin/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery/jquery.js" charset="utf-8"></script>
<script language="javascript" type="text/javascript" src="/js/hotel/uploader.js"></script>
<script language="javascript" type="text/javascript" src="/js/hotel/tips.js"></script>
<script type="text/javascript" src="/admin/js/jquery.form.js" charset="utf-8"></script>

</head>
<body>
<div class="main">
	<div class="title-sp">
		<h2>添加列表</h2>
		<span class="l"></span>
		<span class="r"></span>
	</div>
	<div class="table-box">
		<div class="table-top">
			<a href="hotel_program_info_list.php" class="button button_a">返回列表</a>
		</div>
		<div class="table-data-box">
			<form id="form1" method="post" enctype="multipart/form-data" action="hotel_program_info_edit_post_add.php">
				<input type="hidden" value="<?php echo $this->_tpl_vars['g_show']['item']['id']; ?>
" name="id" id="id" />
				<table class="table-add-modify">
					
					<!-- <tr>
						<td class="label">节目列表<span class="require">*</span></td>
						<td><input type="text" class="text" readonly="readonly" name="program_file_address" id="program_file_address" value="<?php echo $this->_tpl_vars['g_show']['item']['program_file_address']; ?>
" /><span class="uploadfile app_link_class"><input type="button" value="浏览" /> </span> &nbsp;
							<div class="f_c">请上传文件</div>
						</td>
					</tr> -->
					
					<tr>
						<td class="label">节目名<span class="require">*</span></td>
						<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['program_name']; ?>
" name="program_name" id="program_name" /></td>
					</tr>
              		
              		<tr>
						<td class="label">节目号<span class="require">*</span></td>
						<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['program_num']; ?>
" name="program_num" id="program_num" />
							<div class="f_c">节目号不能冲突！</div>
						</td>
					</tr>
					
					<tr>
						<td class="label">节目url<span class="require">*</span></td>
						<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['program_url']; ?>
" name="program_url" id="program_url" /></td>
					</tr>
					
					<tr>
						<td class="label">版本号<span class="require">*</span></td>
						<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['version']; ?>
" name="version" id="version" /></td>
					</tr>
					
					<tr>
						<td></td>
						<td><input type="submit" value="提交" class="button form_submit" /> &nbsp; &nbsp; <input type="reset" value="重置" onclick="reset()" class="button" /></td>
					</tr>
					
					<tr>
						<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['hotel_program_manager_id']; ?>
" name="hotel_program_manager_id" id="hotel_program_manager_id" hidden="true" /></td>
					</tr>
					
					<tr>
						<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['program_num']; ?>
" name="program_num_old" id="program_num_old" hidden="true" /></td>
					</tr>
            </table>
			</form>
		</div>
    
		<span class="l"></span>
		<span class="r"></span>
	</div>
</div>
</body>

<!-- 
<script type="text/javascript">

$(function(){
	
	options={
		callback:'/js/uploader_callback.html',
		container:'.app_link_class',
		script:'/interface/common/json_file_upload.php',
		onComplete:function(res){
			if(res.error ==0)
			{
			
				if(res.link)
				{
					$("#program_file_address").val(res.link);

					return ;
				}
				
			}
			else
			{
				alert(res.errormsg);
			}
				
		},
		errorId:'#errormsg'
	};

	TV.ImgUploader.init(options);

});


</script>
 -->
<script>

$(".form_submit").bind("click", function () {
	if(!$("#program_name").val())
	{
		alert("节目名不能为空！");
		return false;
	}
	
	if(!$("#program_num").val())
	{
		alert("节目号不能为空！");
		return false;
	}
	
	if(!$("#program_url").val())
	{
		alert("节目url不能为空！");
		return false;
	}
	
	if(!$("#version").val())
	{
		alert("版本号不能为空！");
		return false;
	}
	
	$("#my_form").submit();

} );

</script>

</html>