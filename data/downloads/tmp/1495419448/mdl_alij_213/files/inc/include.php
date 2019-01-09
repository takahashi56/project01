<?php

/**
 *
 * @copyright	2000-2007 LOCKON CO.,LTD. All Rights Reserved.
 * @version	CVS: $Id: include.php 1254 2008-04-02 10:45:16Z adachi $
 * @link		http://www.lockon.co.jp/
 *
 */
/* * ** ▼定数宣言 ******************************************************************************************** */

define('MDL_ALIJ', true);
define('MDL_ALIJ_TITLE', 'アナザーレーン決済モジュールfor2.13');

define("MDL_ALIJ_ID", 8);
define("ALIJ_CREDIT_ID", 1);

define('MDL_ALIJ_PATH', MODULE_REALDIR . 'mdl_alij_213/');
define('MDL_ALIJ_CLASS_PATH', MDL_ALIJ_PATH . 'class/');
define('MDL_ALIJ_TEMPLATE_PATH', MDL_ALIJ_PATH . 'templates/');

define("ALIJ_LOG_PATH", DATA_REALDIR . "logs/alij.log");


define("SEND_PARAM_PC_URL", "https://credit.alij.ne.jp/service/credit/input.html");
define("SEND_PARAM_MOBILE_URL", "https://credit.alij.ne.jp/service/credit/input.html");

/* * ** ▲変数宣言 ******************************************************************************************** */
?>