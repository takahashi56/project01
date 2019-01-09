<?php /* Smarty version 2.6.27, created on 2018-09-21 10:37:39
         compiled from /home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/header_block.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/header_block.tpl', 5, false),array('modifier', 'h', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/header_block.tpl', 21, false),array('modifier', 'u', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/header_block.tpl', 93, false),)), $this); ?>
<div id="header_wrap" class="navbar navbar-default navbar-static-top" role="navigation">
	<!-- トップリンクメニュー -->
	<div id="group_link">
		<ul>
			<li><a title="" href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" target="_blank">トップ</a></li>
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
		<h1><a href="<?php echo ((is_array($_tmp=@TOP_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
">EC動画配信サイト構築CMS</a></h1>
		<div class="navbar-header">
			<a class="navbar-brand" href="<?php echo ((is_array($_tmp=@TOP_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrSiteInfo']['shop_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
</a>
		</div>

		<div class="mobile-menu">
			<ul>
				<li>
					<a href="<?php echo ((is_array($_tmp=@CART_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" class="header-under-menu"><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
img/mobile/cart.png"><br /><span>カート</span></a>
				</li>
				<li>
					<?php if (((is_array($_tmp=$this->_tpl_vars['tpl_login'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) !== false): ?>
						<a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
mypage/?mode=logout" class="header-under-menu btn-red"><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
img/mobile/logout.png"><br /><span>ログアウト</span></a>
					<?php else: ?>
						<a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
mypage/login.php" class="header-under-menu btn-red"><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
img/mobile/login.png"><br /><span>ログイン</span></a>
					<?php endif; ?>
				</li>
			</ul>
		</div>

		<div class="navbar-table">
			<div class="navbar-search">
				<form role="search" name="search_form" id="header_search_form" method="get" action="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php">
					<input type="hidden" name="<?php echo ((is_array($_tmp=@TRANSACTION_ID_NAME)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['transactionid'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
					<input type="hidden" name="mode" value="search" />
					<div class="input-group">
						<input type="text" id="header-search" class="form-control" name="name" maxlength="50" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$_GET['name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
" placeholder="タイトル名・出演者名">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-default hidden-xs hidden-sm">　<span class="icon_search"></span></button>
						</span>
					</div>
				</form>
			</div>
			<div class="navbar-span"><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/search.php">総合検索ページへ</a></div>
		</div>

		<div class="navbar-right">
			<ul>
				<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/info.php" class="header-under-menu">初めての方へ</a></li>
				<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/faq.php" class="header-under-menu">よくある質問</a></li>
				<li><a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
contact/<?php echo ((is_array($_tmp=@DIR_INDEX_PATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" class="header-under-menu">お問合せ</a></li>
			</ul>
			<div class="navbar-middle">
				<ul>
					<li class="cart"><a href="<?php echo ((is_array($_tmp=@CART_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" class="header-under-menu btn-elm">買い物かご</a></li>
					<li>
						<?php if (((is_array($_tmp=$this->_tpl_vars['tpl_login'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) !== false): ?>
							<a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
mypage/?mode=logout" class="header-under-menu btn-red btn-elm">ログアウト</a>
						<?php else: ?>
							<a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
mypage/login.php" class="header-under-menu btn-red btn-elm">ログイン</a>
						<?php endif; ?>
					</li>
					<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
entry/kiyaku.php" class="header-under-menu btn-brown btn-elm">新規会員登録</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="header2">
		<div class="navbar-main">
			<ul>
				<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
">トップ</li>
				<li class="bottom-drop">
					<a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=48" class="header-under-menu">最新作</a>
					<ul class="sub-menu" style="display:none">
						<?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrSaisin'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrChild']):
?>
						<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=<?php echo ((is_array($_tmp=$this->_tpl_vars['arrChild']['category_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrChild']['category_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</a></li>
						<?php endforeach; endif; unset($_from); ?>
					</ul>
				</li>
				<li class="bottom-drop">
					<a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/ranking.php" class="header-under-menu">ランキング</a>
					<ul class="sub-menu" style="display:none">
						<?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrBestProducts'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['bestseller'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['bestseller']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['arrProduct']):
        $this->_foreach['bestseller']['iteration']++;
?>
						<li>
						<a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/detail.php?product_id=<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrProduct']['product_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('u', true, $_tmp) : smarty_modifier_u($_tmp)); ?>
">ランキング<?php echo ((is_array($_tmp=$this->_foreach['bestseller']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
位</a>
						<div class="outbox" style="display:none"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrProduct']['name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
</div>
						</li>
						<?php endforeach; endif; unset($_from); ?>
					</ul>
				</li>
				<li class="bottom-drop">
					<a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=102" class="header-under-menu">プレミアム</a>
					<ul class="sub-menu" style="display:none">
						<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=172">プレミアム動画</a></li>
						<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=173">所属モデルグッズ</a></li>
						<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=186">VIP会員専用</a></li>
					</ul>
				</li>
				<li class="bottom-drop"><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=169" class="header-under-menu">見放題コース</a>
					<ul class="sub-menu" style="display:none">
						<li><a href="#">見放題 A コース（月額1,260円）</a></li>
						<li><a href="#">見放題 B コース（月額2,980円）</a></li>
						<li><a href="#">見放題 C コース（月額5,980円）</a></li>
					</ul>
				
				</li>
				<li class="bottom-drop">
					<a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/label.php" class="header-under-menu">シリーズ一覧</a>
				</li>
				<li class="bottom-drop"><a href="#" class="header-under-menu">ゼミ講座</a>
					<ul class="sub-menu" style="display:none">
						<li><a href="#">○○先生（数学）</a></li>
						<li><a href="#">○○先生（地歴公民）</a></li>
						<li><a href="#">○○先生（数学）見逃し配信</a></li>
					</ul>
				</li>
				<li>
					<a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/model.php" class="header-under-menu">配信者一覧</a>
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
				<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=2"><span class="manicon icon_point"></span><span class="manlink">ポイント購入する</span></a></li>
				<li><a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
mypage/login.php" class="header-under-menu"><span class="manicon icon_tool"></span><span class="manlink">マイページ</span></a></li>
				<li><a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
mypage/favorite.php" class="header-under-menu"><span class="manicon icon_star"></span><span class="manlink">お気に入り</span></a></li>
				<li><a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
mypage/videos.php" class="header-under-menu"><span class="manicon icon_play"></span><span class="manlink">プレイリスト</span></a></li>
				<li><a href="<?php echo ((is_array($_tmp=@CART_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" class="header-under-menu"><span class="manicon icon_cart"></span><span class="manlink">カート</span></a></li>
			</ul>
		</div>
	</div>
	<div class="header4">
		<form role="search" name="search_form" id="header_search_form" method="get" action="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php">
			<input type="hidden" name="<?php echo ((is_array($_tmp=@TRANSACTION_ID_NAME)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['transactionid'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
			<input type="hidden" name="mode" value="search" />
			<div id="mobile-menu-button"></div>
			<input type="text" id="mobile-search" name="name" maxlength="50" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$_GET['name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
" placeholder="タイトル名・出演者名">
			<button type="submit" id="mobile-search-button"></button>
		</form>
	</div>
	<div class="header4-tool">
			<ul>
				<li><a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
mypage/login.php" class="header-under-menu icon_tool">マイページ</a></li>
				<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
/cart/" class="icon_point">カートを見る</a></li>
				<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=2" class="icon_point">ポイント購入</a></li>
				<li><a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
mypage/favorite.php" class="header-under-menu icon_star">お気に入り</a></li>
				<li><a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/label.php" class="header-under-menu icon_tool">シリーズ一覧</a></li>
				<li><a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/model.php" class="header-under-menu icon_tool">配信者一覧</a></li>
				<li><a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/ranking.php" class="header-under-menu icon_tool">ランキング</a></li>
				<li><a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/search.php" class="header-under-menu icon_star">検索する</a></li>
				<li><a href="<?php echo ((is_array($_tmp=@HTTPS_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
mypage/videos.php" class="header-under-menu icon_play">ご購入済みのビデオ</a></li>
			</ul>
	</div>
</div>