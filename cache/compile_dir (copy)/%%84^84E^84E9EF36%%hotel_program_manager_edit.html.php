<?php /* Smarty version 2.6.19, created on 2016-08-23 10:10:10
         compiled from hotel/hotel_program_manager_edit.html */ ?>
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

<div class="main">
	<div class="title-sp">
		<h2>添加文件</h2>
		<span class="l"></span>
		<span class="r"></span>
    </div>
    <div class="table-box">
    	<div class="table-top">
				<a href="hotel_program_manager_list.php" class="button button_a">返回节目列表</a>
      </div>
    	<div class="table-data-box">
				<form id="my_form" method="post" enctype="multipart/form-data" action="hotel_program_manager_edit_post.php">
        	<table class="table-add-modify">

						<tr>
							<td>节目列表<span class="require">*</span></td>
							<td><input type="text" class="text" readonly="readonly" name="program_json_address" id="program_json_address" value="<?php echo $this->_tpl_vars['g_show']['item']['program_json_address']; ?>
" /><span class="uploadfile app_link_class"><input type="button" value="浏览" /> </span> &nbsp;
								<div class="f_c">请上传json文件</div>
							</td>
						</tr>

						<input type="hidden" name="id" value=<?php echo $this->_tpl_vars['g_show']['item']['id']; ?>
>
							<tr>
								<td></td>
								<td><input type="button" value="提交" class="button form_submit" /> &nbsp; &nbsp; <input type="reset" value="重置" onclick="reset()" class="button" /></td>
							</tr>
            </table>
				</form>
			</div>
    
			<span class="l"></span>
			<span class="r"></span>
		</div>
</div>




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
					$("#program_json_address").val(res.link);

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

<script>

$(".form_submit").bind("click", function () {
	if(!$("#program_json_address").val())
	{
		alert("节目列表不能为空！");
		return false;
	}
	
	$("#my_form").submit();

} );

</script>




</html>