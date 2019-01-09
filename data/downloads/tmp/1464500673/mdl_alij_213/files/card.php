<?php

/*
 * お支払でALIJ決済選択時に呼び出される
 */

require_once (MODULE_REALDIR . 'mdl_alij_213/inc/include.php');
require_once (MODULE_REALDIR . 'mdl_alij_213/mdl_alij_settlement.php');
require_once (CLASS_EX_REALDIR . 'helper_extends/SC_Helper_DB_Ex.php');


$objView = SC_MobileUserAgent :: isMobile() ? new SC_MobileView : new SC_SiteView;
$objSiteSess = new SC_SiteSession();
$objCartSess = new SC_CartSession();
$objCustomer = new SC_Customer();

//決済用class
$alij = new AlijSettlement();
$alij->init();
$alij->process();
?>
