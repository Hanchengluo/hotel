<?php
function smarty_modifier_getdatebyts($string, $format="r", $default_date=null) {
		return date($format,$string);
}
?>