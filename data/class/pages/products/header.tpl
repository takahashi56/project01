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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 	 See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA		02111-1307, USA.
 *}-->

<!--▼HEADER-->
<!--{strip}-->
<div id="header_wrap" class="navbar navbar-default navbar-static-top" role="navigation">
  <!-- トップリンクメニュー -->
	<div id="group_link">
		<ul>
			<li><a title="/">サンプル</a></li>
			<li><a title="/">サンプル</a></li>
			<li><a title="/" class="now">サンプル</a></li>
			<li><a title="/">サンプル</a></li>
			<li><a title="/">サンプル</a></li>
			<li><a title="" href="#">サンプル</a></li>
			<li><a title="" href="#">サンプル</a></li>
			<li><a title="" href="#">サンプル</a></li>
			<li><a title="" href="#">サンプル</a></li>
		</ul>
	</div>
	<!-- トップリンクメニュー -->
	<!-- メインヘッダ -->
	<div id="header" class="container">
		<h1><a href="<!--{$smarty.const.TOP_URL}-->"></a></h1>
		<div class="navbar-header">
			<a class="navbar-brand" href="<!--{$smarty.const.TOP_URL}-->"><!--{$arrSiteInfo.shop_name|h}--></a>
		</div>
		<div class="navbar-table">
			<div class="navbar-search">
				<form role="search" name="search_form" id="header_search_form" method="get" action="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php">
					<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
					<input type="hidden" name="mode" value="search" />
					<div class="input-group">
						<input type="text" id="header-search" class="form-control" name="name" maxlength="50" value="<!--{$smarty.get.name|h}-->" placeholder="タイトル名・モデル名">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-default hidden-xs hidden-sm">　<span class="icon_search"></span></button>
						</span>
					</div>
				</form>
			</div>
			<div class="navbar-span"><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/search">総合検索ページへ</a></div>
		</div>

		<div class="navbar-right">
			<ul>
				<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/info" class="header-under-menu">初めての方へ</a></li>
				<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/faq" class="header-under-menu">よくある質問</a></li>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->contact/<!--{$smarty.const.DIR_INDEX_PATH}-->" class="header-under-menu">お問合せ</a></li>
			</ul>
			<div class="navbar-middle">
				<ul>
					<li><a href="<!--{$smarty.const.CART_URL}-->" class="header-under-menu">買い物かご</a></li>
					<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/news" class="header-under-menu">お知らせ</a></li>
					<li><a href="<!--{$smarty.const.HTTPS_URL}-->mypage/login.php" class="header-under-menu btn-red">ログイン</a></li>
					<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->entry/kiyaku.php" class="header-under-menu btn-brown">新規会員登録</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="header2">
		<div class="navbar-main">
			<ul>
				<li class="dropdown"><a href="<!--{$smarty.const.ROOT_URLPATH}-->">サンプル</a></li>
				<li class="dropdown">
				  <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=48" class="header-under-menu">サンプル</a>
				</li>
				<li class="dropdown">
				  <a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/ranking" class="header-under-menu">サンプル</a>
				</li>
				<li class="dropdown">
				  <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=102" class="header-under-menu">サンプル</a>
				</li>
				<li class="dropdown">
				  <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=169" class="header-under-menu">サンプル</a>
				</li>
				<li class="dropdown">
				  <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=170">サンプル</a>
				</li>
				<li class="dropdown">
				  <a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/label" class="header-under-menu">サンプル</a>
				</li>
				<li class="dropdown">
				  <a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/model" class="header-under-menu">サンプル</a>
				</il>
				<li class="dropdown">
				  <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=168" class="header-under-menu">サンプル</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="header3">
		<div class="navbar-sub">
			<ul>
				<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=2"><span class="manicon icon_point"></span><span class="manlink">ポイント購入する</span></li>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->mypage/login.php" class="header-under-menu"><span class="manicon icon_tool"></span><span class="manlink">マイページ</span></li>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->mypage/favorite.php" class="header-under-menu"><span class="manicon icon_star"></span><span class="manlink">お気に入り</span></li>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->mypage/videos.php" class="header-under-menu"><span class="manicon icon_play"></span><span class="manlink">プレイリスト</span></li>
				<li><a href="<!--{$smarty.const.CART_URL}-->" class="header-under-menu"><span class="manicon icon_cart"></span><span class="manlink">カート</span></li>
			</ul>
		</div>
	</div>

		<!-- for small mobile -->
		<section id="mobile-nav" class="hidden-lg">
				<div class="container margin-bottom-lg">
						<form name="search_form" method="get" action="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php">
								<div class="input-group">
										<span class="input-group-addon">
												<span class="glyphicon glyphicon-search"></span>
										</span>
										<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
										<input type="hidden" name="mode" value="search" />
										<input type="text" class="form-control input-clear" name="name" value="<!--{$smarty.get.name|h}-->" placeholder="キーワードを入力" />
								</div>
						</form>
				</div>
				<nav class="navbar navbar-default hidden-sm hidden-md" role="navigation">
					<div class="container text-center">
						<ul class="nav navbar-nav">
								<li class="col-xs-3">
										<a href="#" class="btn btn-link toggle-offcanvas">
												<span class="glyphicon glyphicon-list-alt fa-2x"></span><br />
												<small>カテゴリ</small>
										</a>
								</li>
								<li class="col-xs-3">
										<a href="<!--{$smarty.const.HTTPS_URL}-->mypage/login.php" class="btn btn-link">
												<span class="glyphicon glyphicon-user fa-2x"></span><br />
												<small>MYページ</small>
										</a>
								</li>
								<li class="col-xs-3">
										<a href="<!--{$smarty.const.HTTPS_URL}-->mypage/favorite.php" class="btn btn-link">
												<span class="glyphicon glyphicon-star-empty fa-2x"></span><br />
												<small>お気に入り</small>
										</a>
								</li>
								<li class="col-xs-3">
										<a href="<!--{$smarty.const.CART_URL}-->" class="btn btn-link">
												<span class="glyphicon glyphicon-shopping-cart fa-flip-horizontal fa-2x"></span><br />
												<small>カート</small>
												<span class="cart-total-quantity badge bg-red" data-role="cart-total-quantity"></span>
										</a>
								</li>
						</ul>
					</div>
				</nav>
		</section>
		<!-- for small mobile -->
<!--{/strip}-->
<!--▲HEADER-->