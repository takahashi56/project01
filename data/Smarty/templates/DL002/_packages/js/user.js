/* USER定義関数 */
$(document).ready(function(){

	/* 左ドロップメニュー */
	$("li.right-drop").hover(function(){
		$("ul.sub-menu", this).fadeIn(200);
	}, function(){
		$("ul.sub-menu",this).hide();
	});

	/* 下ドロップメニュー */
	$("li.bottom-drop").hover(function(){
		$("ul.sub-menu", this).fadeIn(200);
	}, function(){
		$("ul.sub-menu",this).hide();
	});

	/* リストスライダー */
	$('.line-slider').bxSlider({
		auto: true, 		/* 自動再生 */
		autoControls: false,		/* スタート、ストップボタン */
		pager: true, 		/* ページャー */
		mode: 'horizontal', 	/* horizontal,fade,vertical など */
		speed: 1000, 		/* エフェクトのスピード */
		controls: true, 	/* 前へ、次へボタンの表示 */
		prevText: '<', 		/* 前へボタンのテキスト */
		nextText: '>', 		/* 次へボタンのテキスト */
		pause: 4000, 		/* 間隔の時間 */
		easing: 'swing', 	/* Easing */
		autoHover: true, 	/* マウスホバーで停止 */
		slideWidth:472,
		touchEnabled:true,
		minSlides: 5,
		maxSlides: 5,
		moveSlides: 1,
		slideMargin: 5
	});
});

//]]>