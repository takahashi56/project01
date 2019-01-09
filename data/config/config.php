<?php
//環境切替
define('MUTOTEST', false);

//試験環境
if(MUTOTEST) {
define('ECCUBE_INSTALL', 'ON');
define('HTTP_URL', 'http://');
define('HTTPS_URL', 'https://');
define('ROOT_URLPATH', '/');
define('DOMAIN_NAME', '');
define('DB_TYPE', 'mysql');
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_SERVER', '');
define('DB_NAME', '');
define('DB_PORT', '');
define('ADMIN_DIR', 'admin/');
define('ADMIN_FORCE_SSL', FALSE);
define('ADMIN_ALLOW_HOSTS', 'a:0:{}');
define('AUTH_MAGIC', 'stiphithoutujaewrokoutrisleclaivairaeuuh');
define('PASSWORD_HASH_ALGOS', 'sha256');
define('MAIL_BACKEND', 'mail');
define('SMTP_HOST', '');
define('SMTP_PORT', '');
define('SMTP_USER', '');
define('SMTP_PASSWORD', '');
define('VIDEO_TANK', '/home/joycurrent');
} else {
//本番環境
define('ECCUBE_INSTALL', 'ON');
define('HTTP_URL', 'http://joycurrent.xsrv.jp/');
define('HTTPS_URL', 'http://joycurrent.xsrv.jp/');
define('ROOT_URLPATH', '/');
define('DOMAIN_NAME', '');
define('DB_TYPE', 'mysql');
define('DB_USER', 'joycurrent_stm');
define('DB_PASSWORD', 'hEk7AqL2');
define('DB_SERVER', 'mysql5017.xserver.jp');
define('DB_NAME', 'joycurrent_stmingo');
define('DB_PORT', '');
define('ADMIN_DIR', 'admin/');
define('ADMIN_FORCE_SSL', FALSE);
define('ADMIN_ALLOW_HOSTS', 'a:0:{}');
define('AUTH_MAGIC', 'stiphithoutujaewrokoutrisleclaivairaeuuh');
define('PASSWORD_HASH_ALGOS', 'sha256');
define('MAIL_BACKEND', 'mail');
define('SMTP_HOST', '');
define('SMTP_PORT', '');
define('SMTP_USER', '');
define('SMTP_PASSWORD', '');
define('VIDEO_TANK', '/home/joycurrent/joycurrent.xsrv.jp/public_html/xv');
define('VIDEO_TANK_URL', 'http://joycurrent.xsrv.jp/xv/save/');
}
