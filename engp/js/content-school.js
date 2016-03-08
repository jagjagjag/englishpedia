// ================= 表示処理 =======================
$(function(){
	var undefined;
	var history = $.cookie("ep-history");
	var postid = $('#hiddenID').val();
	var location = window.location.href;

	if(history == '' || history == undefined){
		history = postid;
	}else{
		var splits = history.split('_');
		history = postid;

		for(var i=0; (i < splits.length && i < 5); i++){
			if(postid != splits[i] && splits[i] != '' && splits[i] != 'undefined'){
				history += '_' + splits[i];
			}
		}
	}

	$.cookie("ep-history", history, { path: '/', secure: false});

	costConv();

	loadData(0);

	if(location.indexOf('&') != 1){
		var param = location.slice(location.indexOf('&') + 1);
		if(param == 'review'){
			$('#details_tab').hide();
			$('#review_tab').show();

			var pointer = $("#tabs").offset().top;

			$('html, body').animate({ scrollTop: pointer }, 'slow');

			return false;
		}
	}
});

// ================= レビュー =======================
$(function(){
	$('#review_tab').on('click', '.paginate' ,function(){
		var page = $(this).data('page');
		loadData(page);
	});
});

//================= 評価を見る =======================
$(function(){
	$('#review_content').on('click', function(){
		ChangeTab('review_tab');
		location.hash = "#tabs";
	});
});

//================= 評価を見る =======================
$(function(){
	$('#review_sidebar').on('click', function(){
		ChangeTab('review_tab');
		location.hash = "#side_tabs";
	});
});

//================= 学費の詳細 =======================
$(function(){
	$('#fees_detail').on('click', function(){
		ChangeTab('details_tab');
		location.hash = "#feesbox";
	});
});

//================= スペシャルオファー詳細 =======================
$(function(){
	$('#spoffer_detail').on('click', function(){
		ChangeTab('details_tab');
		location.hash = "#spfeesbox";
	});
});


function loadData(page){
	var post_id = $('#hiddenID').val();
	var cols = 5;
	var data = {'action' : 'engp_school_review', 'post_id' : post_id, 'page' : page, 'cols' : cols };

	jQuery.ajax({
		type: 'post',
		url: ajaxurl,
		data: data,
		async: false,
		success: function(response) {
			jQuery("#review_tab").html(response);
		}
	});
}

function costConv(){
	var usd2jpy_rate = getRate();

	if($('#cost_2w_min_usd')[0]){
		$('#cost_2w_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_2w_min_usd').html()));
	}
	if($('#cost_4w_min_usd')[0]){
		$('#cost_4w_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_4w_min_usd').html()));
	}
	if($('#cost_8w_min_usd')[0]){
		$('#cost_8w_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_8w_min_usd').html()));
	}
	if($('#cost_12w_min_usd')[0]){
		$('#cost_12w_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_12w_min_usd').html()));
	}
	if($('#cost_16w_min_usd')[0]){
		$('#cost_16w_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_16w_min_usd').html()));
	}
	if($('#cost_24w_min_usd')[0]){
		$('#cost_24w_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_24w_min_usd').html()));
	}
	if($('#cost_36w_min_usd')[0]){
		$('#cost_36w_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_36w_min_usd').html()));
	}
	if($('#cost_48w_min_usd')[0]){
		$('#cost_48w_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_48w_min_usd').html()));
	}
	
	if($('#cost_2w_ft_min_usd')[0]){
		$('#cost_2w_ft_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_2w_ft_min_usd').html()));
	}
	if($('#cost_4w_ft_min_usd')[0]){
		$('#cost_4w_ft_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_4w_ft_min_usd').html()));
	}
	if($('#cost_8w_ft_min_usd')[0]){
		$('#cost_8w_ft_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_8w_ft_min_usd').html()));
	}
	if($('#cost_12w_ft_min_usd')[0]){
		$('#cost_12w_ft_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_12w_ft_min_usd').html()));
	}
	if($('#cost_16w_ft_min_usd')[0]){
		$('#cost_16w_ft_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_16w_ft_min_usd').html()));
	}
	if($('#cost_24w_ft_min_usd')[0]){
		$('#cost_24w_ft_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_24w_ft_min_usd').html()));
	}
	if($('#cost_36w_ft_min_usd')[0]){
		$('#cost_36w_ft_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_36w_ft_min_usd').html()));
	}
	if($('#cost_48w_ft_min_usd')[0]){
		$('#cost_48w_ft_min_jpy').html(usd2jpy(usd2jpy_rate, $('#cost_48w_ft_min_usd').html()));
	}
	
}
$(function(){
	slider = $('.bxslider02').bxSlider({
		pager:false,
		minSlides: 1,//１スライドに表示するサムネイルの数
		maxSlides: 10,//１スライドに表示するサムネイルの最大数
		slideWidth: 49,//サムネイルの横幅（単位はpx）
		slideMargin: 20,//サムネイル間の余白（単位はpx）
		nextSelector: '#NextIcon',//"次へ”矢印をカスタマイズするための記述
		prevSelector: '#PrevIcon'//"前へ”矢印をカスタマイズするための記述
	});
});
