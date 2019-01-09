<?php /* Smarty version 2.6.27, created on 2018-09-21 10:37:38
         compiled from site_frame.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'printXMLDeclaration', 'site_frame.tpl', 1, false),array('modifier', 'script_escape', 'site_frame.tpl', 26, false),array('modifier', 'h', 'site_frame.tpl', 31, false),array('modifier', 'strlen', 'site_frame.tpl', 31, false),array('modifier', 'count', 'site_frame.tpl', 165, false),)), $this); ?>
<?php echo GC_Utils_Ex::printXMLDeclaration(array(), $this);?>
<!DOCTYPE html>

<html lang="ja">
<head>
    <meta charset="<?php echo ((is_array($_tmp=@CHAR_CODE)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

<meta http-equiv="Content-Type" content="text/html; charset=<?php echo ((is_array($_tmp=@CHAR_CODE)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
<title><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrSiteInfo']['shop_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
<?php if (((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tpl_subtitle'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('strlen', true, $_tmp) : strlen($_tmp)) >= 1): ?> / <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tpl_subtitle'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
<?php elseif (((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tpl_title'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('strlen', true, $_tmp) : strlen($_tmp)) >= 1): ?> / <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tpl_title'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
<?php endif; ?></title>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<?php if (((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrPageLayout']['author'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('strlen', true, $_tmp) : strlen($_tmp)) >= 1): ?>
    <meta name="author" content="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrPageLayout']['author'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
" />
<?php endif; ?>
<?php if (((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrPageLayout']['description'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('strlen', true, $_tmp) : strlen($_tmp)) >= 1): ?>
    <meta name="description" content="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrPageLayout']['description'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
" />
<?php endif; ?>
<?php if (((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrPageLayout']['keyword'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('strlen', true, $_tmp) : strlen($_tmp)) >= 1): ?>
    <meta name="keywords" content="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrPageLayout']['keyword'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
" />
<?php endif; ?>
<?php if (((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrPageLayout']['meta_robots'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('strlen', true, $_tmp) : strlen($_tmp)) >= 1): ?>
    <meta name="robots" content="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrPageLayout']['meta_robots'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
" />
<?php endif; ?>
<link rel="shortcut icon" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
img/common/favicon.ico" />
<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
img/common/favicon.ico" />
<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php echo ((is_array($_tmp=@HTTP_URL)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
rss/<?php echo ((is_array($_tmp=@DIR_INDEX_PATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
<script type="text/javascript" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
js/eccube.js"></script>
<!-- #2342 次期メジャーバージョン(2.14)にてeccube.legacy.jsは削除予定.モジュール、プラグインの互換性を考慮して2.13では残します. -->
<script type="text/javascript" src="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
js/eccube.legacy.js"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
js/jquery.colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
js/bxslider/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
js/jquery.matchHeight-min.js"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
js/slick.js"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
js/jquery.ellipsis.min.js"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
js/init.js"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
js/user.js"></script>
<?php if (((is_array($_tmp=$this->_tpl_vars['tpl_page_class_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) === 'LC_Page_Abouts'): ?>
    <?php if (( ((is_array($_tmp=$_SERVER['HTTPS'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) != "" ) && ( ((is_array($_tmp=$_SERVER['HTTPS'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) != 'off' )): ?>
        <script type="text/javascript" src="https://maps-api-ssl.google.com/maps/api/js?sensor=false"></script>
    <?php else: ?>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <?php endif; ?>
<?php endif; ?>

<!-- Latest compiled and minified CSS -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
bootstrap/3.3.4/css/bootstrap.css" />
<link rel="stylesheet" href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
js/jquery.colorbox/colorbox.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
css/import.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
js/bxslider/jquery.bxslider.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
css/style.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
css/video.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
css/slicknav.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
css/slick.css" type="text/css" media="all" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<script src="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
js/jquery.plugin.js"></script>
<script src="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
js/jquery.slicknav.js"></script>

<script type="text/javascript">//<![CDATA[
    <?php echo ((is_array($_tmp=$this->_tpl_vars['tpl_javascript'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

    $(function(){
        <?php echo ((is_array($_tmp=$this->_tpl_vars['tpl_onload'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

        // off canvas button
        $(document).on('click', '.toggle-offcanvas', function(){
            $('.row-offcanvas').toggleClass('active');
            return false;
        });

        // swipe event
        $("#main_column, #rightcolumn").on("touchstart", TouchStart);
        $("#main_column, #rightcolumn").on("touchmove" , TouchMove);

        function Position(e){
            var x = e.originalEvent.touches[0].pageX;
            var y = e.originalEvent.touches[0].pageY;
            x = Math.floor(x);
            y = Math.floor(y);
            var pos = {'x':x , 'y':y};
            return pos;
        }
        function TouchStart( event ) {
            var pos = Position(event);
            $("#main_column").data("memory",pos.x);
        }
        function TouchMove( event ) {
            var pos = Position(event); //X,Yを得る
            var start = $("#main_column").data("memory");
            var range = start - pos.x;
            if( range > 50){
                // 左に移動
                $('.row-offcanvas').removeClass('active');
            } else if (start < 30 && range < -10){
                // 右に移動
                $('.row-offcanvas').addClass('active');
            }
        }

        // input clear
        $(".input-clear").inputClear();
        // tooltip
        $('[data-toggle=tooltip]').tooltip();
        // pagetop
        var pageTop = function(){
            $((navigator.userAgent.indexOf("Opera") != -1) ? document.compatMode == 'BackCompat' ? 'body' : 'html' :'html,body').animate({scrollTop:0}, 'slow');
            return false;
        };
        var pageBottom = function(){
            $((navigator.userAgent.indexOf("Opera") != -1) ? document.compatMode == 'BackCompat' ? 'body' : 'html' :'html,body').animate({scrollTop: $(document).height()-$(window).height()}, 'slow');
            return false;
        };
        $("a[href^=#top]").click(pageTop);

        // vimize
        $().vimize({
            homePagePath: '/',
            searchBoxSelector: 'input#header-search',
            selectors: {
                0: '#category_area a',
                1: '#product-list-wrap a, .navi a, #main_column a',
            },
            defaultSelectors: 1,
            command: {
                CAT: function(){
                    window.location.href = 'https://www.google.co.jp/search?tbm=isch&q=cat';
                }
            },
            commandError: function(e){
                alert(e);
            }
        });
    });
//]]></script>

<?php echo ''; ?><?php echo ''; ?><?php if (count(((is_array($_tmp=$this->_tpl_vars['arrPageLayout']['HeadNavi'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))) > 0): ?><?php echo ''; ?><?php echo ''; ?><?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrPageLayout']['HeadNavi'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['HeadNaviKey'] => $this->_tpl_vars['HeadNaviItem']):
?><?php echo ''; ?><?php echo ''; ?><?php if (((is_array($_tmp=$this->_tpl_vars['HeadNaviItem']['php_path'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) != ""): ?><?php echo ''; ?><?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => ((is_array($_tmp=$this->_tpl_vars['HeadNaviItem']['php_path'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)), 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?><?php echo ''; ?><?php else: ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=$this->_tpl_vars['HeadNaviItem']['tpl_path'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo ''; ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php echo ''; ?>

</head>

<!-- ▼BODY部 スタート -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => './site_main.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- ▲BODY部 エンド -->

</html>