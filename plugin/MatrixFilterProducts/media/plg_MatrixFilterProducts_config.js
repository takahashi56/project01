$(document).ready(function(){
	window.resizeTo(950, 850);
	
	/**
	 * フィルター入力フォームを表示
	 */
	function updateFilterValueForms() {
		
		var val = $('#mfp_filter_value').val();
		var target = $('#mfp_filter_target').val();
		var valuetype = $('#mfp_filter_valuetype').val();
		
		//入力欄を一時的に隠す
		$('#mfp_filter_value_text').hide().attr('disabled', true);
		$('#mfp_filter_value_select').hide().attr('disabled', true);
		
		/**
		 * 条件設定
		 */
		//ターゲットがID系の場合は条件を等しいに固定
		if (target == 1 || target == 3) {
			$('#mfp_filter_condition').val(1);
			$('#mfp_filter_condition').children('option').hide().attr('disabled', true);
			$('#mfp_filter_condition').children('option[value=1]').show().attr('disabled', false);
		//ターゲットがメーカーURLの場合は条件を正規表現以外に固定
		} else {
			$('#mfp_filter_condition').children('option').show().attr('disabled', false);
		}
		
		/**
		 * 値タイプ設定
		 */
		//ターゲットが名前系（カテゴリー名、商品コード）の場合はカスタム値入力のみ
		if (target == 2 || target == 4) {
			$('#mfp_filter_valuetype').val(2);
			valuetype = 2;
			$('#mfp_filter_valuetype').children().each(function(){
				if ($(this).val()!=2) $(this).hide().attr('disabled', true);													
			});
		//ターゲットがメーカーURLか備考(SHOP用)の場合はURLパラメーター、カスタム値、データベース
		} else if (target == 5 || target == 6) {
			if ($('#mfp_filter_valuetype').val()==1) {
				$('#mfp_filter_valuetype').val(2);
				valuetype = 2;
			}
			$('#mfp_filter_valuetype').children().show().attr('disabled', false);
			$('#mfp_filter_valuetype').children('option[value=1]').hide().attr('disabled', true);
		//その他
		} else {
			$('#mfp_filter_valuetype').children().show().attr('disabled', false);
			//データベースは基本的に不可
			$('#mfp_filter_valuetype').children('option[value=4]').hide().attr('disabled', true);
		}
		
		/**
		 * 値設定
		 */
		//規定値
		if (valuetype == 1) {
			//カテゴリーID,または商品ステータスID
			if (target == 1 || target == 3) {
				if (target == 1) {
					var arr = $.arrCATTREE;
				} else {
					var arr = $.arrSTATUS;
				}
				$('#mfp_filter_value_select').html('');
				var elems = '';
				jQuery.each(arr, function(i,v){
					elems += '<option value="'+v[0]+'">'+v[1]+'</option>';
				});
				$('#mfp_filter_value_select').html(elems);
				$('#mfp_filter_value_select').show().attr('disabled', false).val(val);
				
			} else {
				$('#mfp_filter_value_text').show().attr('disabled', false).val(val);
			}
		//カスタム値
		} else if (valuetype == 2) {
			$('#mfp_filter_value_text').show().attr('disabled', false).val(val);
		//URLパラメーター
		} else if (valuetype == 3) {
			$('#mfp_filter_value_select').html('');
			var elems = '';
			jQuery.each($.arrURLPARAM, function(i,v){
				elems += '<option value="'+i+'"';
				//ターゲット：カテゴリーID
				if (target == 1) {
					if (v=='商品ステータスID') elems += ' disabled="disabled"';
				//ターゲット：商品ステータス
				} else if (target == 3) {
					if (v!='商品ID') elems += ' disabled="disabled"';
				}
				elems += '>'+v+'</option>';
			});
			$('#mfp_filter_value_select').html(elems);
			$('#mfp_filter_value_select').show().attr('disabled', false).val(val);
		//データベース
		} else if (valuetype == 4) {
			$('#mfp_filter_value_select').html('');
			var elems = '';
			jQuery.each($.arrDbFields, function(i,v){
				elems += '<option value="'+v+'"';
				elems += '>'+v+'</option>';
			});
			$('#mfp_filter_value_select').html(elems);
			$('#mfp_filter_value_select').show().attr('disabled', false).val(val);
		}
		
		//値が「商品ID」の場合は「ページの商品を除外」を表示
		if (val == 'product_id' && valuetype == 3) {
			$('#mfp_filter_except_self_label').show();
		} else {
			$('#mfp_filter_except_self_label').hide();
		}
	};
	
	//初期画面に戻る
	$('#to-default').click(function(){
		location.href = location.href.replace(/(.+plugin_id=\d+).*$/, "$1");
	});
	
	//ブロック編集アクション設定
	$('.list-edit-action').click(function(){
		var mfp_id = $(this).attr('title');
		location.href = location.href + '&' + 'mfp_id=' + mfp_id;
	});
	
	//削除
    $('.list-delete-action').click(function(){
		if (confirm("すでにページに配置されているブロックや\n作成したフィルターも削除されます。\n削除してもよろしいですか？")) {
			var id = $(this).attr('title');
			$('#mode').val('delete');
			$('#mfp_id').val(id);
			$('#form1').submit();
		} else {
			return false;
		}
	});
	
	//初期画面に戻る
	$('#to-filter-default').click(function(){
		location.href = location.href.replace(/(.+plugin_id=\d+\&mfp_id=\d+\&filters).*$/, "$1");
	});
	
	//フィルター画面遷移アクション設定
	$('.list-filter-action').click(function(){
		var mfp_id = $(this).attr('title');
		location.href = location.href + '&' + 'mfp_id=' + mfp_id + '&filters';
	});
	
	//フィルター編集アクション設定
	$('.list-filter-edit-action').click(function(){
		var mfp_filter_id = $(this).attr('title');
		var href = location.href.replace(/(.+plugin_id=\d+\&mfp_id=\d+\&filters).*$/, "$1");
		location.href = href + '&' + 'mfp_filter_id=' + mfp_filter_id;
	});
	
	//フィルター削除アクション設定
	$('.list-filter-delete-action').click(function(){
		if (confirm("このフィルターを削除してもよろしいですか？")) {
			var id = $(this).attr('title');
			$('#mode').val('delete');
			$('#mfp_filter_id').val(id);
			$('#form1').submit();
		} else {
			return false;
		}
	});
	
	$('#mfp_filter_target').change(function(){
		updateFilterValueForms();								   
	});
	
	$('#mfp_filter_valuetype').change(function(){
		updateFilterValueForms();								   
	});
	
	$('#mfp_filter_value_select').change(function(){
		$('#mfp_filter_value').val($(this).val());
		updateFilterValueForms();
	});
	
	$('#submit').click(function(){
		if ($('#mfp_filter_value_text').is(':disabled') == false) {
			var val = $('#mfp_filter_value_text').val();
		} else {
			var val = $('#mfp_filter_value_select').val();
		}
		$('#mfp_filter_value').val(val);
		document.form1.submit();
		return false;
	});
	
	//値の入力欄をアップデート
	updateFilterValueForms();
})
