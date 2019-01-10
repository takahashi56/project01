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

require_once CLASS_EX_REALDIR . 'page_extends/admin/LC_Page_Admin_Ex.php';

/**
 * サポート外端末用 のページクラス.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id$
 */
class LC_Page_Admin_Customer_Subscribe extends LC_Page_Admin_Ex
{
    /**
     * Page を初期化する.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->tpl_mainpage = 'customer/subscribe.tpl';
        $this->tpl_mainno = 'customer';
        $this->tpl_subno = 'index';
        $this->tpl_pager = 'pager.tpl';
        $this->tpl_maintitle = '会員管理';
        $this->tpl_subtitle = '会員費管理';

        $helperCategory = new SC_Helper_Category_Ex();
        $this->membershipCategoryID = $helperCategory->getMembershipCategoryID();
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
        $objQuery =& SC_Query_Ex::getSingletonInstance();

        if ($this->getMode() == 'update') {
            $objQuery->update('dtb_order', array('update_date' => date('Y-m-d H:i:s')), 'order_id = ?', array($_REQUEST['order']));

            SC_Response_Ex::sendRedirect('subscribe.php');
        } else {
            $orders = $objQuery->getAll('select o.order_id, o.create_date, o.update_date, o.customer_id, o.order_name01, o.order_name02, p.name, o.del_flg from (dtb_order as o left join dtb_order_detail as od on o.order_id = od.order_id) left join dtb_product_categories as pc on od.product_id = pc.product_id left join dtb_products as p on pc.product_id = p.product_id where pc.category_id = ?', array($this->membershipCategoryID));

            $this->orders = array();

            $now = time();
            foreach ($orders as $order) {
                $your_date = strtotime($order['update_date']);
                $datediff = $now - $your_date;
                $order['expire'] = (int) $order['name'] - round($datediff / (60 * 60 * 24));
                $order['create_date'] = date('Y/m/d', strtotime($order['create_date']));
                $order['update_date'] = date('Y/m/d', strtotime($order['update_date']));
                $this->orders[] = $order;
            }
        }
    }
}
