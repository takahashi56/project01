<?php

require_once(MODULE_REALDIR . 'mdl_alij_213/inc/include.php');
require_once(MDL_ALIJ_CLASS_PATH . "pages/LC_Page_Mdl_ALIJ_Config.php");

$objPage = new LC_Page_Mdl_ALIJ_Config();
$objPage->init();
$objPage->process();
register_shutdown_function(array($objPage, "destroy"));
?>
