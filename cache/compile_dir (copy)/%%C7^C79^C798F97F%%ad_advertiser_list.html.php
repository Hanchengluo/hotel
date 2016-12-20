<?php /* Smarty version 2.6.19, created on 2014-07-02 15:20:21
         compiled from ad/ad_advertiser_list.html */ ?>
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
		<h2>广告商管理</h2>
		<span class="l"></span>
		<span class="r"></span>
	</div>
	<div class="table-box">
		<div class="table-top">
			<table width="100%">
				<tr>
					<td align="left">
						<a href="ad_advertiser_edit.php" class="button">添加广告商</a>
					</td>
					<td align="right">
						<form class="search-form">
							广告商名称：
							<input type="text" class="key" name="ad_advertiser_name" />
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
条广告商</td>
					<?php echo $this->_tpl_vars['g_show']['page_bar']; ?>

				</tr>
			</table>
			
			<table class="table-data">
				<tr>
					<th>ID</th>
					<th>名称</th>
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
				<tr >
					<td>
						<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['id']; ?>

					</td>
					<td>
						<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['name']; ?>

					</td>
					<td>
						<a href="ad_advertiser_edit.php?id=<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['id']; ?>
">编辑</a>
						<a href="javascript:void(0);" onclick=del_one(<?php echo $this->_tpl_vars['g_show']['list'][$this->_sections['count']['index']]['id']; ?>
);>删除</a>
					</td>

				</tr>

				<?php endfor; else: ?>
				<tr><td colspan="8">
					目前列表中没有内容
				</td></tr>
				<?php endif; ?>

			</table>
           
		</div>
    
		<span class="l"></span>
		<span class="r"></span>
	</div>
</div>
<script>


function del_one(id)
{
	if(!id)
	{
		alert("没选择？！");
		return false;
	}
	$.post('ad_advertiser_edit_post.php?type=del&id='+id, '', function(data){
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


