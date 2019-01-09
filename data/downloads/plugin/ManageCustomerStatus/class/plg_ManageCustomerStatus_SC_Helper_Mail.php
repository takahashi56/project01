<?php
/*
 * ManageCustomerStatus
 * Copyright (C) 2012 Bratech CO.,LTD. All Rights Reserved.
 * http://wwww.bratech.co.jp/
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
 

require_once PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/plg_ManageCustomerStatus_Utils.php";

class plg_ManageCustomerStatus_SC_Helper_Mail extends SC_Helper_Mail{
    /**
     * 指定したIDのメルマガ配送を行う
     *
     * @param integer $send_id dtb_send_history の情報
     * @return　void
     */
    function sfSendMailmagazine($send_id) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objDb = new SC_Helper_DB_Ex();
        $objSite = $objDb->sfGetBasisData();
        $objMail = new SC_SendMail_Ex();

        $where = 'del_flg = 0 AND send_id = ?';
        $arrMail = $objQuery->getRow('*', 'dtb_send_history', $where, array($send_id));

        // 対象となる$send_idが見つからない
        if (SC_Utils_Ex::isBlank($arrMail)) return;

        // 送信先リストの取得
        $arrDestinationList = $objQuery->select(
            '*',
            'dtb_send_customer',
            'send_id = ? AND (send_flag = 2 OR send_flag IS NULL)',
            array($send_id)
        );

        // 現在の配信数
        $complete_count = $arrMail['complete_count'];
        if (SC_Utils_Ex::isBlank($arrMail)) {
            $complete_count = 0;
        }
		
		$period = plg_ManageCustomerStatus_Utils::getConfig("point_term");

        foreach ($arrDestinationList as $arrDestination) {

			$subjectBody = $arrMail['subject'];
			$mailBody = $arrMail['body'];
            // お名前の変換
            $customerName = trim($arrDestination['name']);
            $subjectBody = preg_replace('/{name}/', $customerName, $subjectBody);
            $mailBody = preg_replace('/{name}/', $customerName, $mailBody);
			
			$ret = $objQuery->select("customer.point,customer.last_buy_date,crank.name","dtb_customer customer LEFT JOIN plg_managecustomerstatus_dtb_customer_status crank ON customer.plg_managecustomerstatus_status = crank.status_id","customer.customer_id = ?",array($arrDestination['customer_id']));
			$arrCustomer = $ret[0];
			
			// ポイントの変換
            $subjectBody = preg_replace('/{point}/', $arrCustomer['point'], $subjectBody);
            $mailBody = preg_replace('/{point}/', $arrCustomer['point'], $mailBody);
			
			// 会員ランク名の変換
            $subjectBody = preg_replace('/{rank}/', $arrCustomer['name'], $subjectBody);
            $mailBody = preg_replace('/{rank}/', $arrCustomer['name'], $mailBody);
			
			// ポイント有効期限の変換
			if($period > 0 && strlen($arrCustomer['last_buy_date']) > 0){
				$expired_date = date("Y/m/d",strtotime($arrCustomer['last_buy_date'] . "+".intval($period)." day"));
			}else{
				$expired_date = "";
			}
	        $subjectBody = preg_replace('/{expired}/', $expired_date, $subjectBody);
    	    $mailBody = preg_replace('/{expired}/', $expired_date, $mailBody);
			

            $objMail->setItem(
                $arrDestination['email'],
                $subjectBody,
                $mailBody,
                $objSite['email03'],      // 送信元メールアドレス
                $objSite['shop_name'],    // 送信元名
                $objSite['email03'],      // reply_to
                $objSite['email04'],      // return_path
                $objSite['email04']       // errors_to
            );

            // テキストメール配信の場合
            if ($arrMail['mail_method'] == 2) {
                $sendResut = $objMail->sendMail();
            // HTMLメール配信の場合
            } else {
                $sendResut = $objMail->sendHtmlMail();
            }

            // 送信完了なら1、失敗なら2をメール送信結果フラグとしてDBに挿入
            if (!$sendResut) {
                $sendFlag = '2';
            } else {
                // 完了を 1 増やす
                $sendFlag = '1';
                $complete_count++;
            }

            // 送信結果情報を更新
            $objQuery->update('dtb_send_customer',
                              array('send_flag'=>$sendFlag),
                              'send_id = ? AND customer_id = ?',
                              array($send_id,$arrDestination['customer_id']));
        }

        // メール全件送信完了後の処理
        $objQuery->update('dtb_send_history',
                          array('end_date'=>'CURRENT_TIMESTAMP', 'complete_count'=>$complete_count),
                          'send_id = ?',
                          array($send_id));

        // 送信完了　報告メール
        $compSubject = date('Y年m月d日H時i分') . '  下記メールの配信が完了しました。';
        // 管理者宛に変更
        $objMail->setTo($objSite['email03']);
        $objMail->setSubject($compSubject);

        // テキストメール配信の場合
        if ($arrMail['mail_method'] == 2) {
            $sendResut = $objMail->sendMail();
        // HTMLメール配信の場合
        } else {
            $sendResut = $objMail->sendHtmlMail();
        }
        return;
    }
}