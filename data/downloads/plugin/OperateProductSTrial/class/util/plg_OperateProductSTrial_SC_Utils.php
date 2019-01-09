<?php
class plg_OperateProductSTrial_SC_Utils {
    
    /**
     * ディレクトリとその内容を、再帰的にコピーする。
     * 
     * @param string $src コピー元パス
     * @param string $dst コピー先パス
     * @param boolean $delete_first trueの場合、$dstを削除してからコピーする。
     */
    static function copy_recursive($src, $dst, $delete_first = false) {

        if ($delete_first && file_exists($dst)) {
            
            rmdir_recursive($dst);
        }

        if (is_dir($src)) {
            
            if(!file_exists($dst) || !is_dir($dst)){
                
                mkdir($dst);
            }

            $files = scandir($src);
            foreach ($files as $file) {
                if (($file != ".") && ($file != "..")) {
                    self::copy_recursive("$src/$file", "$dst/$file");
                }
            }
        }
        else if (file_exists($src)) {
            
            copy($src, $dst);
        }
    }
}
