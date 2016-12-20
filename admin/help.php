<?php
//error_reporting(0);
include_once($_SERVER["DOCUMENT_ROOT"] . "/core/inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/core/admin.inc.php");

admin_check_login();
$username = admin::admin_get_login_user_name();

$smarty = p_get_smarty();

$smarty->display("admin_admin_help.html");

?>