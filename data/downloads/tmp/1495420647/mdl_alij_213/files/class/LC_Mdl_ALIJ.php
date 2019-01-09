<?php

/**
 * ALIJ決済モジュール
 *
 */
class LC_Mdl_ALIJ {

    /** サブデータを保持する変数 */
    var $subData = null;

    /** モジュール情報 */
    var $moduleInfo = array(
        'paymentName' => 'ALIJ決済',
        'moduleName' => 'ALIJ決済モジュール2.13',
        'moduleCode' => 'MDL_ALIJ_213',
        'moduleVersion' => '1.0.0',
    );

    /**
     * テーブル拡張設定.拡張したいテーブル情報を配列で記述する.
     * $updateTable = array(
     *     array(
     *       'name' => 'テーブル名',
     *       'cols' => array(
     *          array('name' => 'カラム名', 'type' => '型名'),
     *          array('name' => 'カラム名', 'type' => '型名'),
     *       ),
     *     ),
     *     array(
     *       ...
     *     ),
     *     array(
     *       ...
     *     ),
     * );
     */
    var $updateTable = array(
        // dtb_paymentの更新
        array(
            'name' => 'dtb_payment',
            'cols' => array(
                array('name' => 'module_code', 'type' => 'text'),
            ),
        ),
    );

    /**
     * Enter description here...
     *
     * @var unknown_type
     */
    var $updateFile = array();

    /**
     * LC_Mdl_ALIJ:install()を呼んだ際にdtb_moduleのsub_dataカラムへ登録される値
     * シリアライズされて保存される.
     *
     * master_settings => 初期データなど
     * user_settings => 設定情報など、ユーザの入力によるデータ
     */
    var $installSubData = array(
        // 初期データなどを保持する
        'master_settings' => array(
        ),
        // 設定情報など、ユーザの入力によるデータを保持する
        'user_settings' => array(
        ),
    );

    function LC_Mdl_ALIJ() {
        $this->updateFile = array(
            array(
                "src" => "alij_recv.php",
                "dst" => USER_REALDIR . 'alij_recv.php'
            )
        );
    }

    /**
     * LC_Mdl_ALIJのインスタンスを取得する
     *
     * @return LC_Mdl_ALIJ
     */
    function &getInstance() {
        static $_objLC_Mdl_ALIJ;
        if (empty($_objLC_Mdl_ALIJ)) {
            $_objLC_Mdl_ALIJ = new LC_Mdl_ALIJ();
        }
        $_objLC_Mdl_ALIJ->init();
        return $_objLC_Mdl_ALIJ;
    }

    /**
     * 初期化処理.
     */
    function init() {
        foreach ($this->moduleInfo as $k => $v) {
            $this->$k = $v;
        }
    }

    /**
     * モジュール表示用名称を取得する
     *
     * @return string
     */
    function getName() {
        return $this->moduleName;
    }

    /**
     * 支払い方法名(決済モジュールの場合のみ)
     *
     * @return string
     */
    function getPaymentName() {
        return $this->paymentName;
    }

    /**
     * モジュールコードを取得する
     *
     * @param boolean $toLower trueの場合は小文字へ変換する.デフォルトはfalse.
     * @return string
     */
    function getCode($toLower = false) {
        $moduleCode = $this->moduleCode;
        return $toLower ? strtolower($moduleCode) : $moduleCode;
    }

    /**
     * モジュールバージョンを取得する
     *
     * @return string
     */
    function getVersion() {
        return $this->moduleVersion;
    }

    /**
     * サブデータを取得する.
     *
     * @return mixed|null
     */
    function getSubData() {
        if (isset($this->subData))
            return $this->subData;

        $moduleCode = $this->getCode(true);
        $objQuery = new SC_Query;
        $ret = $objQuery->get(
                'sub_data', 'dtb_module', 'module_code = ?', array($moduleCode)
        );
        if (isset($ret)) {
            $this->subData = unserialize($ret);
            return $this->subData;
        }
        return null;
    }

    /**
     * サブデータをDBへ登録する
     * $keyがnullの時は全データを上書きする
     *
     * @param mixed $data
     * @param string $key
     */
    function registerSubData($data, $key = null) {
        $subData = $this->getSubData();
        if (is_null($key)) {
            $subData = $data;
        } else {
            $subData[$key] = $data;
        }

        $arrUpdate = array('sub_data' => serialize($subData));
        $objQuery = new SC_Query;
        $objQuery->update('dtb_module', $arrUpdate, 'module_code = ?', array($this->getCode(true)));

        $this->subData = $subData;
    }

    function getUserSettings($key = null) {
        $subData = $this->getSubData();
        $returnData = null;

        if (is_null($key)) {
            $returnData = isset($subData['user_settings']) ? $subData['user_settings'] : null;
        } else {
            $returnData = isset($subData['user_settings'][$key]) ? $subData['user_settings'][$key] : null;
        }

        return $returnData;
    }

    function registerUserSettings($data) {
        $this->registerSubData($data, 'user_settings');
    }

    /**
     * ログを出力.
     *
     * @param string $msg
     * @param mixed $data
     */
    function printLog($msg, $date = null) {
        $path = DATA_PATH . 'logs/' . $this->getCode(true) . '.log';
        GC_Utils::gfPrintLog($msg, $path);
    }

    /**
     * インストール処理
     *
     * @param boolean $force true時、上書き登録を行う
     */
    function install($force = false) {
        // カラムの更新
        $this->updateTable();

        $subData = $this->getSubData();
        if (is_null($subData) || $force) {
            $this->registerSubdata(
                    $this->installSubData['master_settings'], 'master_settings'
            );
        }
    }

    /**
     * カラムの更新を行う.
     *
     */
    function updateTable() {
        $objDB = new SC_Helper_DB_Ex();
        foreach ($this->updateTable as $table) {
            foreach ($table['cols'] as $col) {
                $objDB->sfColumnExists(
                        $table['name'], $col['name'], $col['type'], "", $add = true
                );
            }
        }
    }

    /**
     * ファイルをコピーする
     *
     * @return boolean
     */
    function updateFile() {
        foreach ($this->updateFile as $file) {
            $dst_file = $file['dst'];
            $src_file = MDL_ALIJ_PATH . 'copy/' . $file['src'];
            // ファイルがない、またはファイルはあるが異なる場合
            if (!file_exists($dst_file) || sha1_file($src_file) != sha1_file($dst_file)) {
                if (is_writable($dst_file) || is_writable(dirname($dst_file))) {
                    copy($src_file, $dst_file);
                } else {
                    $this->failedCopyFile[] = $dst_file;
                }
            }
        }
    }

    /**
     * コピーに失敗したファイルを取得する
     *
     * @return array
     */
    function getFailedCopyFile() {
        return $this->failedCopyFile;
    }

}

?>
