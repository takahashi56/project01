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
define('VIDEO_TANK', '/home/mallento/medicalschool-movie.com');
} else {
//本番環境
define('ECCUBE_INSTALL', 'ON');
define('HTTP_URL', 'http://medicalschool-movie.com/');
define('HTTPS_URL', 'http://medicalschool-movie.com/');
define('ROOT_URLPATH', '/');
define('DOMAIN_NAME', '');
define('DB_TYPE', 'mysql');
define('DB_USER', 'mallento_fill');
define('DB_PASSWORD', 's2Ew7seW');
define('DB_SERVER', 'mysql7015.xserver.jp');
define('DB_NAME', 'mallento_medicalschool');
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
define('VIDEO_TANK', '/home/mallento/medicalschool-movie.com/public_html/xv');
define('VIDEO_TANK_URL', 'http://medicalschool-movie.com/xv/save/');
}
