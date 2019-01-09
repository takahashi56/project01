<div id="header_wrap" class="navbar navbar-default navbar-static-top" role="navigation">
	<!-- トップリンクメニュー -->
	<div id="group_link">
		<ul>
			<li><a title="" href="<!--{$smarty.const.ROOT_URLPATH}-->" target="_blank">トップ</a></li>
			<li><a title="" href="#" target="_blank">リンク1</a></li>
			<li><a title="" href="#" target="_blank">リンク2</a></li>
			<li><a title="" href="#" target="_blank">リンク3</a></li>
			<li><a title="" href="#" target="_blank">リンク4</a></li>
			<li><a title="" href="#" target="_blank">リンク5</a></li>
			<li><a title="" href="#" target="_blank">リンク6</a></li>
			<li><a title="" href="#" target="_blank">リンク7</a></li>
			<li><a title="" href="#" target="_blank">お問い合わせ</a></li>
		</ul>
	</div>
	<!-- トップリンクメニュー -->
	<!-- メインヘッダ -->
	<div id="header" class="container">
		<h1><a href="<!--{$smarty.const.TOP_URL}-->">EC動画配信サイト構築CMS</a></h1>
		<div class="navbar-header">
			<a class="navbar-brand" href="<!--{$smarty.const.TOP_URL}-->"><!--{$arrSiteInfo.shop_name|h}--></a>
		</div>

		<div class="mobile-menu">
			<ul>
				<li>
					<a href="<!--{$smarty.const.CART_URL}-->" class="header-under-menu"><img src="<!--{$TPL_URLPATH}-->img/mobile/cart.png"><br /><span>カート</span></a>
				</li>
				<li>
					<!--{if $tpl_login !== false}-->
						<a href="<!--{$smarty.const.HTTPS_URL}-->mypage/?mode=logout" class="header-under-menu btn-red"><img src="<!--{$TPL_URLPATH}-->img/mobile/logout.png"><br /><span>ログアウト</span></a>
					<!--{else}-->
						<a href="<!--{$smarty.const.HTTPS_URL}-->mypage/login.php" class="header-under-menu btn-red"><img src="<!--{$TPL_URLPATH}-->img/mobile/login.png"><br /><span>ログイン</span></a>
					<!--{/if}-->
				</li>
			</ul>
		</div>

		<div class="navbar-table">
			<div class="navbar-search">
				<form role="search" name="search_form" id="header_search_form" method="get" action="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php">
					<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
					<input type="hidden" name="mode" value="search" />
					<div class="input-group">
						<input type="text" id="header-search" class="form-control" name="name" maxlength="50" value="<!--{$smarty.get.name|h}-->" placeholder="タイトル名・出演者名">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-default hidden-xs hidden-sm">　<span class="icon_search"></span></button>
						</span>
					</div>
				</form>
			</div>
			<div class="navbar-span"><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/search.php">総合検索ページへ</a></div>
		</div>

		<div class="navbar-right">
			<ul>
				<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/info.php" class="header-under-menu">初めての方へ</a></li>
				<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/faq.php" class="header-under-menu">よくある質問</a></li>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->contact/<!--{$smarty.const.DIR_INDEX_PATH}-->" class="header-under-menu">お問合せ</a></li>
			</ul>
			<div class="navbar-middle">
				<ul>
					<li class="cart"><a href="<!--{$smarty.const.CART_URL}-->" class="header-under-menu btn-elm">買い物かご</a></li>
					<li>
						<!--{if $tpl_login !== false}-->
							<a href="<!--{$smarty.const.HTTPS_URL}-->mypage/?mode=logout" class="header-under-menu btn-red btn-elm">ログアウト</a>
						<!--{else}-->
							<a href="<!--{$smarty.const.HTTPS_URL}-->mypage/login.php" class="header-under-menu btn-red btn-elm">ログイン</a>
						<!--{/if}-->
					</li>
					<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->entry/kiyaku.php" class="header-under-menu btn-brown btn-elm">新規会員登録</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="header2">
		<div class="navbar-main">
			<ul>
				<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->">トップ</li>
				<li class="bottom-drop">
					<a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=48" class="header-under-menu">最新作</a>
					<ul class="sub-menu" style="display:none">
						<!--{foreach from=$arrSaisin item= arrChild}-->
						<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=<!--{$arrChild.category_id}-->"><!--{$arrChild.category_name}--></a></li>
						<!--{/foreach}-->
					</ul>
				</li>
				<li class="bottom-drop">
					<a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/ranking.php" class="header-under-menu">ランキング</a>
					<ul class="sub-menu" style="display:none">
						<!--{foreach from=$arrBestProducts item=arrProduct name="bestseller" }-->
						<li>
						<a href="<!--{$smarty.const.ROOT_URLPATH}-->products/detail.php?product_id=<!--{$arrProduct.product_id|u}-->">ランキング<!--{$smarty.foreach.bestseller.iteration}-->位</a>
						<div class="outbox" style="display:none"><!--{$arrProduct.name|h}--></div>
						</li>
						<!--{/foreach}-->
					</ul>
				</li>
				<li class="bottom-drop">
					<a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=102" class="header-under-menu">プレミアム</a>
					<ul class="sub-menu" style="display:none">
						<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=172">プレミアム動画</a></li>
						<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=173">所属モデルグッズ</a></li>
						<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=186">VIP会員専用</a></li>
					</ul>
				</li>
				<li class="bottom-drop"><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=169" class="header-under-menu">見放題コース</a>
					<ul class="sub-menu" style="display:none">
						<li><a href="#">見放題 A コース（月額1,260円）</a></li>
						<li><a href="#">見放題 B コース（月額2,980円）</a></li>
						<li><a href="#">見放題 C コース（月額5,980円）</a></li>
					</ul>
				
				</li>
				<li class="bottom-drop">
					<a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/label.php" class="header-under-menu">シリーズ一覧</a>
				</li>
				<li class="bottom-drop"><a href="#" class="header-under-menu">ゼミ講座</a>
					<ul class="sub-menu" style="display:none">
						<li><a href="#">○○先生（数学）</a></li>
						<li><a href="#">○○先生（地歴公民）</a></li>
						<li><a href="#">○○先生（数学）見逃し配信</a></li>
					</ul>
				</li>
				<li>
					<a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/model.php" class="header-under-menu">配信者一覧</a>
				</li>
				<li class="bottom-drop">
					<a href="#" class="header-under-menu">テキストリンク</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="header3">
		<div class="navbar-sub">
			<ul>
				<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=2"><span class="manicon icon_point"></span><span class="manlink">ポイント購入する</span></a></li>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->mypage/login.php" class="header-under-menu"><span class="manicon icon_tool"></span><span class="manlink">マイページ</span></a></li>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->mypage/favorite.php" class="header-under-menu"><span class="manicon icon_star"></span><span class="manlink">お気に入り</span></a></li>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->mypage/videos.php" class="header-under-menu"><span class="manicon icon_play"></span><span class="manlink">プレイリスト</span></a></li>
				<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=<!--{$memberShipCategory}-->"><span class="manicon icon_point"></span><span class="manlink">会員費購入する</span></li>
				<li><a href="<!--{$smarty.const.CART_URL}-->" class="header-under-menu"><span class="manicon icon_cart"></span><span class="manlink">カート</span></a></li>
			</ul>
		</div>
	</div>
	<div class="header4">
		<form role="search" name="search_form" id="header_search_form" method="get" action="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php">
			<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
			<input type="hidden" name="mode" value="search" />
			<div id="mobile-menu-button"></div>
			<input type="text" id="mobile-search" name="name" maxlength="50" value="<!--{$smarty.get.name|h}-->" placeholder="タイトル名・出演者名">
			<button type="submit" id="mobile-search-button"></button>
		</form>
	</div>
	<div class="header4-tool">
			<ul>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->mypage/login.php" class="header-under-menu icon_tool">マイページ</a></li>
				<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->/cart/" class="icon_point">カートを見る</a></li>
				<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=2" class="icon_point">ポイント購入</a></li>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->mypage/favorite.php" class="header-under-menu icon_star">お気に入り</a></li>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->user_data/label.php" class="header-under-menu icon_tool">シリーズ一覧</a></li>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->user_data/model.php" class="header-under-menu icon_tool">配信者一覧</a></li>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->user_data/ranking.php" class="header-under-menu icon_tool">ランキング</a></li>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->user_data/search.php" class="header-under-menu icon_star">検索する</a></li>
				<li><a href="<!--{$smarty.const.HTTPS_URL}-->mypage/videos.php" class="header-under-menu icon_play">ご購入済みのビデオ</a></li>
			</ul>
	</div>
</div>