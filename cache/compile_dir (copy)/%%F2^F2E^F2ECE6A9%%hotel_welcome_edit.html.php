<?php /* Smarty version 2.6.19, created on 2016-08-23 10:02:16
         compiled from hotel/hotel_welcome_edit.html */ ?>
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
		<h2>添加图片</h2>
		<span class="l"></span>
		<span class="r"></span>
    </div>
    <div class="table-box">
    	<div class="table-top">
				<a href="hotel_welcome_list.php" class="button button_a">返回图片</a>
      </div>
    	<div class="table-data-box">
				<form id="my_form" method="post" enctype="multipart/form-data" action="hotel_welcome_edit_post.php">
        	<table class="table-add-modify">

						<tr>
							<td>缩略图<span class="require">*</span></td>
							<td><input type="text" class="text" readonly="readonly" name="image_address" id="image_address" value="<?php echo $this->_tpl_vars['g_show']['item']['image_address']; ?>
" /><span class="uploadfile app_pic_class"><input type="button" value="浏览" /> </span> &nbsp; <!-- (上传125*125像素图片) -->
								<div class="f_c">最大允许3M，允许上传图片的类型：gif jpg jpeg png</div>
								<br>
								<div id="pic_view">
									<?php if ($this->_tpl_vars['g_show']['item']['image_address']): ?>
										<img  src="<?php echo $this->_tpl_vars['g_show']['item']['image_address']; ?>
">
									<?php endif; ?>
								</div>
							</td>
						</tr>
						
						<tr>
							<td>欢迎词<span class="require">*</span></td>
							<td><textarea rows="10" cols="30" value="<?php echo $this->_tpl_vars['g_show']['item']['welcome_info']; ?>
" name="welcome_info" id="welcome_info"></textarea></td>
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

$("#welcome_info").html('<?php echo $this->_tpl_vars['g_show']['item']['welcome_info']; ?>
');

$(function(){
	options={
		callback:'/js/uploader_callback.html',
		container:'.app_pic_class',
		script:'/interface/common/json_pic_upload.php',
		size:"188|188",
		thumb:1,
		onComplete:function(res){
				if(res.error ==0)
				{
					if(res.pic)
					{
						$("#image_address").val(res.pic);
						$("#pic_view").html("<img src='"+res.pic+"'>")
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

$("#advertiser").find("option[value='<?php echo $this->_tpl_vars['g_show']['item']['advertiser_id']; ?>
']").attr("selected",true);

$(".form_submit").bind("click", function () {
	if(!$("#image_address").val())
	{
		alert("图片不能为空！");
		return false;
	}
	
	if(!$("#welcome_info").val())
	{
		alert("欢迎词不能为空！");
		return false;
	}
	
	$("#my_form").submit();

} );

</script>




</html>