<?php /* Smarty version 2.6.19, created on 2016-03-10 10:19:00
         compiled from hotel/hotel_video_detail_edit.html */ ?>
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
		<h2>添加视频</h2>
		<span class="l"></span>
		<span class="r"></span>
    </div>
    <div class="table-box">
    	<div class="table-top">
				<a href="hotel_video_detail_list.php" class="button button_a">返回视频</a>
      </div>
    	<div class="table-data-box">
				<form id="my_form" method="post" enctype="multipart/form-data" action="hotel_video_detail_edit_post.php">
        	<table class="table-add-modify">
						<tr>
							<td class="label">视频分类<span class="require">*</span></td>
							<td>
								<select name="video_category" id="video_category">
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
"><?php echo $this->_tpl_vars['g_show']['type_list'][$this->_sections['count']['index']]['video_category_name']; ?>
</option>
									<?php endfor; endif; ?>
								</select>
							</td>
						</tr>
						
						<tr>
							<td class="label">视频名称<span class="require">*</span></td>
							<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['video_name']; ?>
" name="video_name" id="video_name" /></td>
						</tr>
						
						<tr>
							<td>缩略图<span class="require">*</span></td>
							<td><input type="text" class="text" readonly="readonly" name="video_thumbnail_address" id="video_thumbnail_address" value="<?php echo $this->_tpl_vars['g_show']['item']['video_thumbnail_address']; ?>
" /><span class="uploadfile app_pic_class"><input type="button" value="浏览" /> </span> &nbsp; (上传125*125像素图片)
								<div class="f_c">最大允许100k，允许上传图片的类型：gif jpg jpeg png</div>
								<br>
								<div id="pic_view">
									<?php if ($this->_tpl_vars['g_show']['item']['video_thumbnail_address']): ?>
										<img  src="<?php echo $this->_tpl_vars['g_show']['item']['video_thumbnail_address']; ?>
">
									<?php endif; ?>
								</div>
							</td>
						</tr>
						
						<tr>
							<td>视频简介<span class="require">*</span></td>
							<td><textarea rows="10" cols="30" value="<?php echo $this->_tpl_vars['g_show']['item']['video_introduction']; ?>
" name="video_introduction" id="video_introduction"></textarea></td>
						</tr>

						<tr>
							<td class="label">视频url<span class="require">*</span></td>
							<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['video_url']; ?>
" name="video_url" id="video_url" /></td>
						</tr>
						
						<tr>
							<td class="label">单片点播价格<span class="require">*</span></td>
							<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['video_price_single']; ?>
" name="video_price_single" id="video_price_single" /></td>
						</tr>
						
						<tr>
							<td class="label">评分<span class="require">*</span></td>
							<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['video_rating']; ?>
" name="video_rating" id="video_rating" /></td>
						</tr>
						
						<tr>
							<td class="label">影片地区<span class="require">*</span></td>
							<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['video_area']; ?>
" name="video_area" id="video_area" /></td>
						</tr>
						
						<tr>
							<td class="label">上线时间<span class="require">*</span></td>
							<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['video_online_time']; ?>
" name="video_online_time" id="video_online_time" /></td>
						</tr>
						
						<tr>
							<td class="label">片长时间<span class="require">*</span></td>
							<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['video_duration']; ?>
" name="video_duration" id="video_duration" /></td>
						</tr>
						
						<tr>
							<td class="label">导演名<span class="require">*</span></td>
							<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['video_director']; ?>
" name="video_director" id="video_director" /></td>
						</tr>
						
						<tr>
							<td class="label">主演名<span class="require">*</span></td>
							<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['video_star']; ?>
" name="video_star" id="video_star" /></td>
						</tr>
						
						<tr>
							<td class="label">包天点播价格<span class="require">*</span></td>
							<td><input type=text value="<?php echo $this->_tpl_vars['g_show']['item']['video_price_one_day']; ?>
" name="video_price_one_day" id="video_price_one_day" /></td>
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

$("#video_introduction").html('<?php echo $this->_tpl_vars['g_show']['item']['video_introduction']; ?>
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
						$("#video_thumbnail_address").val(res.pic);
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

$("#video_category").find("option[value='<?php echo $this->_tpl_vars['g_show']['item']['video_category_id']; ?>
']").attr("selected",true);

$(".form_submit").bind("click", function () {
	if(!$("#video_thumbnail_address").val())
	{
		alert("图片不能为空！");
		return false;
	}
	
	$("#my_form").submit();

} );

</script>

</html>