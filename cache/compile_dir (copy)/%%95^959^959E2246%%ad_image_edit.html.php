<?php /* Smarty version 2.6.19, created on 2015-12-11 16:54:00
         compiled from ad/ad_image_edit.html */ ?>
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

<div class="main">
	<div class="title-sp">
		<h2>添加图片</h2>
		<span class="l"></span>
		<span class="r"></span>
    </div>
    <div class="table-box">
    	<div class="table-top">
				<a href="ad_image_list.php" class="button button_a">返回图片</a>
      </div>
    	<div class="table-data-box">
				<form id="my_form" method="post" enctype="multipart/form-data" action="ad_image_edit_post.php">
        	<table class="table-add-modify">
						<tr>
							<td class="label">广告商<span class="require">*</span></td>
							<td>
								<select name="advertiser" id="advertiser">
									<option>请选择</option>
									<?php unset($this->_sections['count']);
$this->_sections['count']['name'] = 'count';
$this->_sections['count']['loop'] = is_array($_loop=$this->_tpl_vars['g_show']['type_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['count']['show'] = true;
$this->_sections['count']['max'] = $this->_sections['count']['loop'];
$this->_sections['count']['step'] = 1;
$this->_sections['count']['start'] = $this->_sections['count']['step'] > 0 ? 0 : $this->_sections['count']['loop']-1;
if ($this->_sections['count']['show']) {
    $this->_sections['count']['total'] = $this->_sections['count']['loop'];
    if ($this->_sections['count']['total'] == 0)
        $this->_sections['count']['show'] = false;
} else
    $this->_sections['count']['total'] = 0;
if ($this->_sections['count']['show']):

            for ($this->_sections['count']['index'] = $this->_sections['count']['start'], $this->_sections['count']['iteration'] = 1;
                 $this->_sections['count']['iteration'] <= $this->_sections['count']['total'];
                 $this->_sections['count']['index'] += $this->_sections['count']['step'], $this->_sections['count']['iteration']++):
$this->_sections['count']['rownum'] = $this->_sections['count']['iteration'];
$this->_sections['count']['index_prev'] = $this->_sections['count']['index'] - $this->_sections['count']['step'];
$this->_sections['count']['index_next'] = $this->_sections['count']['index'] + $this->_sections['count']['step'];
$this->_sections['count']['first']      = ($this->_sections['count']['iteration'] == 1);
$this->_sections['count']['last']       = ($this->_sections['count']['iteration'] == $this->_sections['count']['total']);
?>
										<option value="<?php echo $this->_tpl_vars['g_show']['type_list'][$this->_sections['count']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['g_show']['type_list'][$this->_sections['count']['index']]['name']; ?>
</option>
									<?php endfor; endif; ?>
								</select>
							</td>
						</tr>
						
						<tr>
							<td>缩略图<span class="require">*</span></td>
							<td><input type="text" class="text" readonly="readonly" name="address" id="address" value="<?php echo $this->_tpl_vars['g_show']['item']['address']; ?>
" /><span class="uploadfile app_pic_class"><input type="button" value="浏览" /> </span> &nbsp; (上传125*125像素图片)
								<div class="f_c">最大允许100k，允许上传图片的类型：gif jpg jpeg png</div>
								<br>
								<div id="pic_view">
									<?php if ($this->_tpl_vars['g_show']['item']['address']): ?>
										<img  src="<?php echo $this->_tpl_vars['g_show']['item']['address']; ?>
">
									<?php endif; ?>
								</div>
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
		container:'.app_pic_class',
		script:'/interface/common/json_pic_upload.php',
		size:"188|188",
		thumb:1,
		onComplete:function(res){
				if(res.error ==0)
				{
					if(res.pic)
					{
						$("#address").val(res.pic);
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
	if(!$("#address").val())
	{
		alert("图片不能为空！");
		return false;
	}
	
	$("#my_form").submit();

} );

</script>




</html>