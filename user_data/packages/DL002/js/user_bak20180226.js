/* USER��`�֐� */
$(document).ready(function(){
	/* ��ʕ� */
	var ww = $(window).width();
	
	/* SP�Ή� */
	if(ww < 768) {
		adjust();
		
		/* �T�C�Y���� */
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

		/* �g�b�v�X���C�_�[ */
		$(document).ready(function(){
			$('.bxslider').bxSlider({
				auto: true, /* �����Đ� */
				autoControls: false,  /* �X�^�[�g�A�X�g�b�v�{�^�� */
				pager: false, /* �y�[�W���[ */
				mode: 'horizontal', /* horizontal,fade,vertical �Ȃ� */
				speed: 1000, /* �G�t�F�N�g�̃X�s�[�h */
				controls: false, /* �O�ցA���փ{�^���̕\�� */
				prevText: '<', /* �O�փ{�^���̃e�L�X�g */
				nextText: '>', /* ���փ{�^���̃e�L�X�g */
				pause: 4000, /* �Ԋu�̎��� */
				slideMargin: 10,
				slideWidth: ww,
				easing: 'swing', /* Easing */
				autoHover: true /* �}�E�X�z�o�[�Œ�~ */,
				onSliderLoad: function() {
					$('ul.bxslider').css("margin-left", "0px");
					$('.catch-banner').css("visibility", "show");
				}
			});
		});

		/* �h���b�v���j���[ */
		$('#mobile-menu-button').click(function() {
			if($('.header4-tool').is(':hidden')){
				$('.header4-tool').fadeIn(200);
			}else{
				$('.header4-tool').fadeOut(200);
			}
		});



	} else {
		/* ���h���b�v���j���[ */
		$("li.right-drop").hover(function(){
			$("ul.sub-menu", this).fadeIn(200);
		}, function(){
			$("ul.sub-menu",this).hide();
		});

		/* ���h���b�v���j���[ */
		$("li.bottom-drop").hover(function(){
			$("ul.sub-menu", this).fadeIn(200);
		}, function(){
			$("ul.sub-menu",this).hide();
		});

		/* �g�b�v�X���C�_�[ */
		$(document).ready(function(){
			$('.bxslider').bxSlider({
				auto: true, /* �����Đ� */
				autoControls: false,  /* �X�^�[�g�A�X�g�b�v�{�^�� */
				pager: true, /* �y�[�W���[ */
				mode: 'horizontal', /* horizontal,fade,vertical �Ȃ� */
				speed: 1000, /* �G�t�F�N�g�̃X�s�[�h */
				controls: true, /* �O�ցA���փ{�^���̕\�� */
				prevText: '<', /* �O�փ{�^���̃e�L�X�g */
				nextText: '>', /* ���փ{�^���̃e�L�X�g */
				pause: 4000, /* �Ԋu�̎��� */
				slideMargin: 10,
				slideWidth: 700,
				easing: 'swing', /* Easing */
				autoHover: true /* �}�E�X�z�o�[�Œ�~ */,
				onSliderLoad: function() {
					$('ul.bxslider').css("margin-left", "0px");
					$('.catch-banner').css("visibility", "show");
				}
			});
		});

		/* ���X�g�X���C�_�[ */
		//���i��5�ȏ�̏ꍇ�̂ݏ������� 20170926 kikuzawa
		$('.line-slider').each(function(){
			var child = $(this).find('li').length;
			if(child > 4){
				$(this).bxSlider({
					auto: true, 		/* �����Đ� */
					autoControls: false,		/* �X�^�[�g�A�X�g�b�v�{�^�� */
					pager: true, 		/* �y�[�W���[ */
					mode: 'horizontal', 	/* horizontal,fade,vertical �Ȃ� */
					speed: 1000, 		/* �G�t�F�N�g�̃X�s�[�h */
					controls: true, 	/* �O�ցA���փ{�^���̕\�� */
					prevText: '<', 		/* �O�փ{�^���̃e�L�X�g */
					nextText: '>', 		/* ���փ{�^���̃e�L�X�g */
					pause: 4000, 		/* �Ԋu�̎��� */
					easing: 'swing', 	/* Easing */
					autoHover: false, 	/* �}�E�X�z�o�[�Œ�~ */
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

	//���i�ꗗ�ŃT�u�摜���X���C�h 20170823 kikuzawa
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