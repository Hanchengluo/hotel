<?php /* Smarty version 2.6.19, created on 2016-11-30 09:23:21
         compiled from menu.html */ ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/css/admin/style.css" rel="stylesheet" type="text/css" />
</head>

<div class="menu" style="margin:0;">
	<div class="menu-top"></div>
    <div class="menu-mid">
    	<ul>
        	
			<?php $_from = $this->_tpl_vars['g_show']['priv_ary']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['vo']):
?>
				
						<?php $_from = $this->_tpl_vars['vo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
						<li><a target="main-frame" href="<?php if ($this->_tpl_vars['v']['sidebar']): ?><?php echo $this->_tpl_vars['v']['sidebar']; ?>
<?php else: ?><?php echo $this->_tpl_vars['v']['priv_link']; ?>
<?php endif; ?>" title="<?php echo $this->_tpl_vars['v']['priv_name']; ?>
"><?php echo $this->_tpl_vars['v']['priv_name']; ?>
</a></li>
						<?php endforeach; endif; unset($_from); ?>
					
				<?php endforeach; endif; unset($_from); ?>
        </ul>
    </div>
    <div class="menu-bot"></div>
</div>

</html>

			