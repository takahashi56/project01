/* USER��`�֐� */
$(document).ready(function(){

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

	/* ���X�g�X���C�_�[ */
	$('.line-slider').bxSlider({
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
		autoHover: true, 	/* �}�E�X�z�o�[�Œ�~ */
		slideWidth:472,
		touchEnabled:true,
		minSlides: 5,
		maxSlides: 5,
		moveSlides: 1,
		slideMargin: 5
	});
});

//]]>