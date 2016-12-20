<?php /* Smarty version 2.6.19, created on 2015-12-09 11:33:02
         compiled from ad/ad_ploy_list.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/css/admin/style.css" rel="stylesheet" type="text/css" />
<script src ="/js/jquery/jquery.js"></script>
</head>
<body>
<div class="main">
	<div class="title-sp">
		<h2>策略管理</h2>
		<span class="l"></span>
		<span class="r"></span>
	</div>
	<div class="table-box">
		<div class="table-top">
			<table width="100%">
				<tr>
					<td align="left">
						<a href="ad_ploy_edit.php" class="button">添加策略</a>
					</td>
					<td align="right">
						<form class="search-form">
							项目：
							<select method="get" name="ad_project" action="?">
								<option value=0>所有</option>
								<?php unset($this->_sections['count']);
$this->_sections['count']['name'] = 'count';
$this->_sections['count']['loop'] = is_array($_loop=$this->_tpl_vars['g_show']['ad_project_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
								<option value="<?php echo $this->_tpl_vars['g_show']['ad_project_list'][$this->_sections['count']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['g_show']['ad_project_list'][$this->_sections['count']['index']]['name']; ?>
</option>
							<?php endfor; endif; ?>
							</select>
			        &nbsp; &nbsp;类别：
							<select method="get" name="ad_category_type" action="?" onchange="onTypeSelected(options[selectedIndex].value)">
								<option value=0>所有</option>
								<?php unset($this->_sections['count']);
$this->_sections['count']['name'] = 'count';
$this->_sections['count']['loop'] = is_array($_loop=$this->_tpl_vars['g_show']['ad_category_type_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
								<option value="<?php echo $this->_tpl_vars['g_show']['ad_category_type_list'][$this->_sections['count']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['g_show']['ad_category_type_list'][$this->_sections['count']['index']]['name']; ?>
</option>
							<?php endfor; endif; ?>
							</select>
							&nbsp; &nbsp;类别值：
							<select method="get" name="ad_category" id="ad_category" action="?">
								<option value=0>所有</option>
							</select>
							&nbsp; &nbsp;广告位：
							<select method="get" name="ad_area" action="?">
								<option value=0>所有</option>
								<?php unset($this->_sections['count']);
$this->_sections['count']['name'] = 'count';
$this->_sections['count']['loop'] = is_array($_loop=$this->_tpl_vars['g_show']['ad_area_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
								<option value="<?php echo $this->_tpl_vars['g_show']['ad_area_list'][$this->_sections['count']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['g_show']['ad_area_list'][$this->_sections['count']['index']]['name']; ?>
</option>
							<?php endfor; endif; ?>
							</select>
							&nbsp; &nbsp;广告商：
							<select method="get" name="ad_advertiser" action="?">
								<option value=0>所有</option>
								<?php unset($this->_sections['count']);
$this->_sections['count']['name'] = 'count';
$this->_sections['count']['loop'] = is_array($_loop=$this->_tpl_vars['g_show']['ad_advertiser_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
								<option value="<?php echo $this->_tpl_vars['g_show']['ad_advertiser_list'][$this->_sections['count']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['g_show']['ad_advertiser_list'][$this->_sections['count']['index']]['name']; ?>
</option>
							<?php endfor; endif; ?>
							</select>
							&nbsp; &nbsp; &nbsp; &nbsp;
							<input type="image" src="/images/admin/search-bnt.png" alt="搜索" />
						</form>
					</td>
				</tr>
			</table>
		</div>
		<div class="table-data-box">
			<table class="page-inf">
				<tr>
					<td class="search-result">一共找到<?php echo $this->_tpl_vars['g_show']['count']; ?>
条策略</td>
					<?php echo $this->_tpl_vars['g_show']['page_bar']; ?>

				</tr>
			</table>
			
			<table class="table-data">
				<tr>
					<th>ID</th>
					<th>项目</th>
					<th>类别</th>
					<th>类别值</th>
					<th>广告位</th>
					<th>广告商</th>
					<th>缩略图</th>
					<th>起始时间</th>
					<th>结束时间</th>
					<th>操作</th>
				</tr>
	
				<?php unset($this->_sections['count']);
$this->_sections['count']['name'] = 'count';
$this->_sections['count']['loop'] = is_array($_loop=$this->_tpl_vars['g_show']['list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
				<tr>
					<td>
						<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['id']; ?>

					</td>
					<td>
						<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['project_name']; ?>

					</td>
					<td>
						<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['category_type_name']; ?>

					</td>
					<td>
						<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['category_value']; ?>

					</td>
					<td>
						<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['area_name']; ?>

					</td>
					<td>
						<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['advertiser_name']; ?>

					</td>
					<td>
						<img src="<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['image_address']; ?>
" width=87 height=87>
					</td>
					<td>
						<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['start_time']; ?>

					</td>
					<td>
						<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['end_time']; ?>

					</td>
					<td>
						<a href="ad_ploy_edit.php?id=<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['id']; ?>
">编辑</a>
						<a href="javascript:void(0);" onclick=del_one(<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['id']; ?>
);>删除</a>
					</td>
	
				</tr>

				<?php endfor; else: ?>
				<tr>
					<td colspan="10">
						目前列表中没有内容
					</td>
				</tr>
				<?php endif; ?>

		</table>
	            
		</div>
		<span class="l"></span>
		<span class="r"></span>
	</div>
</div>
<script>

function onTypeSelected(category_type_id) {
	
	$.post('ad_category_edit_post.php?type=fetch&category_type_id=' + category_type_id, '', function(data) {
		if (data.error == 1) {
			alert(data.errmsg);
		} else {
			$("#ad_category").empty();
			var data =  eval('(' + data + ')');
			if (data.length > 0) {
				$("#ad_category").show();
				// $("#category").append("<option>" + "请选择" + "</option>");
				for (var i = 0; i < data.length; i++) {
					$("#ad_category").append("<option value='" + data[i].id + "'>" + data[i].value + "</option>"); 
				}
			} else {
				$("#ad_category").hide();
			}
		}
	});
}

function del_one(id)
{
	if(!id)
	{
		alert("没选择？！");
		return false;
	}
	$.post('ad_ploy_edit_post.php?type=del&id='+id, '', function(data){
		if (data.error == 1)
		{
			alert(data.errmsg);
		}
		else
		{
			
			alert("操作成功。");
			window.location.reload();
		}
	}, 'json');
}

</script>
</body>
</html>


