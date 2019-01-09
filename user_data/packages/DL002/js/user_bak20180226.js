/* USER定義関数 */
$(document).ready(function(){
	/* 画面幅 */
	var ww = $(window).width();
	
	/* SP対応 */
	if(ww < 768) {
		adjust();
		
		/* サイズ調整 */
		var resizeTimer = false;
		$(window).resize(function() {
			if (resizeTimer !== false) {
				clearTimeout(resizeTimer);
			}
			resizeTimer = setTimeout(function() {
				adjust();
			}, 200);
		});

		function adjust() {
				ww = $(window).width();
				$('#mobile-search').css('width', (ww - 114) + 'px');
				$('#copyright').css('min-width', ww + 'px');
				$('#copyright').css('width', ww + 'px');
				$('.header4-tool').hide();
				$('.breadcrumb-lite').css('width', ww + 'px');
				$('.breadcrumb-lite').css('min-width', ww + 'px');
				$('.breadcrumb-lite').css('width', ww + 'px');
				$('.breadcrumb-lite').css('margin-left', '-15px');
				$('.breadcrumb').css('width', ww + 'px');
				$('.breadcrumb').css('min-width', ww + 'px');
				$('.breadcrumb').css('width', ww + 'px');
				$('.order-block').css('width', ww + 'px');
				$('.order-block').css('min-width', ww + 'px');
				$('.order-block').css('width', ww + 'px');
				$('.order-block').css('margin-left', '-15px');
				$('.contents').css('width', ww + 'px');
				$('.contents').css('min-width', ww + 'px');
				$('.contents').css('width', ww + 'px');
		}

		$(window).scroll(function() {
			$('.header4-tool').hide();
		});

		/* トップスライダー */
		$(document).ready(function(){
			$('.bxslider').bxSlider({
				auto: true, /* 自動再生 */
				autoControls: false,  /* スタート、ストップボタン */
				pager: false, /* ページャー */
				mode: 'horizontal', /* horizontal,fade,vertical など */
				speed: 1000, /* エフェクトのスピード */
				controls: false, /* 前へ、次へボタンの表示 */
				prevText: '<', /* 前へボタンのテキスト */
				nextText: '>', /* 次へボタンのテキスト */
				pause: 4000, /* 間隔の時間 */
				slideMargin: 10,
				slideWidth: ww,
				easing: 'swing', /* Easing */
				autoHover: true /* マウスホバーで停止 */,
				onSliderLoad: function() {
					$('ul.bxslider').css("margin-left", "0px");
					$('.catch-banner').css("visibility", "show");
				}
			});
		});

		/* ドロップメニュー */
		$('#mobile-menu-button').click(function() {
			if($('.header4-tool').is(':hidden')){
				$('.header4-tool').fadeIn(200);
			}else{
				$('.header4-tool').fadeOut(200);
			}
		});



	} else {
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

		/* トップスライダー */
		$(document).ready(function(){
			$('.bxslider').bxSlider({
				auto: true, /* 自動再生 */
				autoControls: false,  /* スタート、ストップボタン */
				pager: true, /* ページャー */
				mode: 'horizontal', /* horizontal,fade,vertical など */
				speed: 1000, /* エフェクトのスピード */
				controls: true, /* 前へ、次へボタンの表示 */
				prevText: '<', /* 前へボタンのテキスト */
				nextText: '>', /* 次へボタンのテキスト */
				pause: 4000, /* 間隔の時間 */
				slideMargin: 10,
				slideWidth: 700,
				easing: 'swing', /* Easing */
				autoHover: true /* マウスホバーで停止 */,
				onSliderLoad: function() {
					$('ul.bxslider').css("margin-left", "0px");
					$('.catch-banner').css("visibility", "show");
				}
			});
		});

		/* リストスライダー */
		//商品が5以上の場合のみ処理する 20170926 kikuzawa
		$('.line-slider').each(function(){
			var child = $(this).find('li').length;
			if(child > 4){
				$(this).bxSlider({
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
					autoHover: false, 	/* マウスホバーで停止 */
					slideWidth:472,
					touchEnabled:true,
					minSlides: 5,
					maxSlides: 5,
					moveSlides: 3,
					slideMargin: 5
				});
			}
		});
	}

	//商品一覧でサブ画像をスライド 20170823 kikuzawa
	$('.product-list-item .sub-image').slick({
		dots: false,
		arrows: false,
		fade: true,
		infinite: true,
		speed: 10,
		autoplay: true,
		autoplaySpeed: 1000,
		pauseOnHover: false,
	});
	$('.product-list-item').on('mouseover',function(){
		$('.sub-image',this).show();
	});
	$('.product-list-item').on('mouseout',function(){
		$('.sub-image',this).hide();

	});



});

//]]>