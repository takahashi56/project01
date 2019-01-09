<!--{*
 * EC-CUBE on Bootstrap3. This file is part of EC-CUBE
 *
 * Copyright(c) 2014 clicktx. All Rights Reserved.
 *
 * http://perl.no-tubo.net/
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
 *}-->

<!--
  <div class="tokki-body">
    <div class="tokki-tr">
      <div class="tokki-th">
        
      </div>
      <div class="tokki-td">
        
      </div>
    </div>
  </div>
-->

<h2 class="title"><!--{$tpl_title|h}--></h2>

<div class="tokki">
  <div class="tokki-body">
    <div class="tokki-tr">
      <div class="tokki-th">
        販売業者
      </div>
      <div class="tokki-td">
        <!--{$arrOrder.law_company|h}-->
      </div>
    </div>
    <div class="tokki-tr">
      <div class="tokki-th">
        住所
      </div>
      <div class="tokki-td">
        〒<!--{$arrOrder.law_zip01|h}-->-<!--{$arrOrder.law_zip02|h}--><br /><!--{$arrPref[$arrOrder.law_pref]|h}--><!--{$arrOrder.law_addr01|h}--><!--{$arrOrder.law_addr02|h}-->
      </div>
    </div>
    <div class="tokki-tr">
      <div class="tokki-th">
        メールアドレス
      </div>
      <div class="tokki-td">
        <a href="mailto:<!--{$arrOrder.law_email|escape:'hex'}-->"><!--{$arrOrder.law_email|escape:'hexentity'}--></a>
      </div>
    </div>
    <div class="tokki-tr">
      <div class="tokki-th">
        URL
      </div>
      <div class="tokki-td">
        http://stmingo-demo.mallento.com
      </div>
    </div>
    <div class="tokki-tr">
      <div class="tokki-th">
        商品代金以外の必要金額
      </div>
      <div class="tokki-td">
        <!--{$arrOrder.law_term01|h|nl2br}-->
      </div>
    </div>
    <div class="tokki-tr">
      <div class="tokki-th">
        注文方法
      </div>
      <div class="tokki-td">
        <!--{$arrOrder.law_term02|h|nl2br}-->
      </div>
    </div>
    <div class="tokki-tr">
      <div class="tokki-th">
        支払方法
      </div>
      <div class="tokki-td">
        <!--{$arrOrder.law_term03|h|nl2br}-->
      </div>
    </div>
    <div class="tokki-tr">
      <div class="tokki-th">
        支払期限
      </div>
      <div class="tokki-td">
        <!--{$arrOrder.law_term04|h|nl2br}-->
      </div>
    </div>
    <div class="tokki-tr">
      <div class="tokki-th">
        引渡し時期
      </div>
      <div class="tokki-td">
        <!--{$arrOrder.law_term05|h|nl2br}-->
      </div>
    </div>
    <div class="tokki-tr">
      <div class="tokki-th">
        返品・交換について
      </div>
      <div class="tokki-td">
        <!--{$arrOrder.law_term06|h|nl2br}-->
      </div>
    </div>

</div>
</div>