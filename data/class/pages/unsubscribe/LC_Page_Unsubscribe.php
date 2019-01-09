<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2014 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

require_once CLASS_EX_REALDIR . 'page_extends/LC_Page_Ex.php';

/**
 * サポート外端末用 のページクラス.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id$
 */
class LC_Page_Unsubscribe extends LC_Page_Ex
{
    /**
     * Page を初期化する.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->tpl_title = '退会申請(確認ページ)';
        $this->tpl_mainpage = 'unsubscribe/index.tpl';

        $this->httpCacheControl('nocache');

        $masterData = new SC_DB_MasterData_Ex();
        $this->arrPref = $masterData->getMasterData('mtb_pref');

        if (SC_Display_Ex::detectDevice() == DEVICE_TYPE_MOBILE) {
            // @deprecated EC-CUBE 2.11 テンプレート互換用
            $this->CONF = SC_Helper_DB_Ex::sfGetBasisData();
        }
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    public function process()
    {
        parent::process();
        $this->action();
        $this->sendResponse();
    }

    public function action()
    {
        $this->arrData = isset($_SESSION['customer']) ? $_SESSION['customer'] : '';

        if ($this->getMode() == 'complete') {
            $objQuery =& SC_Query_Ex::getSingletonInstance();

            $objQuery->update('dtb_order', array('del_flg' => 1), 'order_id = ?', $this->membershipOrderIds);

            $this->lfSendMail($this);

            // 完了ページへ移動する
            SC_Response_Ex::sendRedirect('complete.php');
            SC_Response_Ex::actionExit();
        }
    }

    /**
     * メールの送信を行う。
     *
     * @param LC_Page_Contact $objPage
     * @return void
     */
    public function lfSendMail(&$objPage)
    {
        $this->arrData = isset($_SESSION['customer']) ? $_SESSION['customer'] : '';
        $helperMail = new SC_Helper_Mail_Ex();
        $helperMail->setPage($this);
        $helperMail->sfSendUnsubscribeEmail(
            $this->arrData['email'],            // email
            $this->arrData['name01'] . ' ' . $this->arrData['name02'] . ' 様',
            $this->arrData['customer_id']
        );
    }
}
