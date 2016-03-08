
//  ==================== オートコンプリート(学校名) ====================

$(function() {
  // 候補リストを配列で準備
  var data = [
'Converse International School of Language',
'EC English San Fransico',
'Embassy CES San Fransico',
'St.Giles San Francisco',
'ELS Language Center San Francisco（Downtown）',
'English Language Institute',
'Brandon College',
'EF International San Francisco',
'Intrax',
'American Academy of English',
'EF International New York',
'Language Studies International New York',
'Embassy English NewYork',
'EC English New York',
'Hello World Language Center',
'Kaplan International New York（Empire State）',
'Language Studies International',
'Manhattan Language',
'Rennert Bilingual New York',
'EC English Los Angeles',
'College of English Language Santa Monica',
'ELS Language Centers Santa Monica',
'University of California Los Angeles Extension',
'English Language Center Santa Monica',
'KAPLAN International Los Angeles（Westwood）',
'Mentor Language Institute（Beverly Hills）',
'POLY LA',
'Language Systems International',
'LASC American Language and Culture',
'Cal America',
'Kings Colleges Los Angeles',
'Embassy English Los Angeles',
'The Language Institute',
'FLS International',
'University of Hawaii at Manoa New Intensive Course...',
'EF International Honolulu',
'Zoni Language Center NY',
'The New England School of English',
'TALK School of languages',
'EC English Boston',
'ELS Language Centers Boston（Downtown）',
'KAPLAN  International Boston（Fenway）',
'Kings College Boston',
'KAPLAN International Seattle',
'Portland English Language Academy',
'KAPLAN International Santa barbara',
'EF  International Santa barbara',
'ELS Language Center  Santa barbara',
'KAPLAN International  Chicago',
'HAWAI‘I ENGLISH LANGUAGE PROGRAM（HELP）',
'Academia Langage School',
'Intercultural Communication College',
'ELS Language Centers Honolulu',
'Global Village Hawaii',
'American Language Communication Center',
'Bell Language School',
'ELS Language Centers NY（Manhattan）',
'EF International Boston',
'New York Language Center',
'Central Pacific College',
'Institute of Intensive English',
'EF International Los Angeles',
'Mentora College（Washington, D.C.）',
'EC English Washington DC',
'EC English San Diego',
'EC English Miami',
'KAPLAN International Los Angeles（Whittier College）',
'KAPLAN International Boston（Harvard Square）',
'KAPLAN International Boston（Northeastern Universit...',
'KAPLAN International New York（Midtown）',
'KAPLAN International New York（SOHO）',
'KAPLAN International Los Angeles（Irvine）',
'KAPLAN International San Francisco',
'KAPLAN International San Francisco（Berkeley）',
'KAPLAN International Philadelphia',
'KAPLAN International WashingtonDC',
'KAPLAN International Miami',
'KAPLAN International Chicago（IIT Campus）',
'KAPLAN International Seattle（Highline College）',
'KAPLAN International Portland',
'KAPLAN International San Diego',
'Embassy English Fort-lauderdale',
'Embassy English San Diego',
'ELS Language Centers Barkeley',
'ELS Language Centers Hollywood',
'ELS Language Centers La Verne',
'ELS Language Centers San Diego',
'ELS Language Centers San Francisco North-Bay',
'ELS Language Centers Silicon Valley',
'ELS Language Centers Thousand Oaks',
'ELS Language Centers Denver',
'ELS Language Centers New Haven',
'ELC Language Centers Washington D.C.',
'ELS Language Centers Melbourne',
'ELS Language Centers Miami',
'ELS Language Centers Orlando',
'ELS Language Centers　St.Petersburg',
'ESL Language Centers Tampa',
'ELS Language Centers Atlanta',
'ELS Language Centers Chicago',
'ELS Language Centers Chicago Romeoville',
'ELS Language Centers Dekalb',
'ELS Language Centers Indianapolis',
'ELS Language Centers Richmond-Kentucky',
'ELS Language Centers Ruston',
'ELS Language Centers Boston-Newton',
'ELS Language Centers Grand Rapids',
'ELS Language Centers  St. Paul',
'ELS Language Centers St.Louis',
'ELS Language Centers Charlote',
'ELS Language Centers Grand Forks',
'ELS Language Centers Atlantic City',
'ELS Language Centers Philadelphia Camden',
'ELS Language Centers Teaneck',
'ELS Language Centers N.Y. Gareden City',
'ELS Language Centers N.Y. Julliard School',
'ELS Language Centers N.Y.Riverdale',
'ELS Language Centers Bowling Green',
'ELS Language Centers Cincinnati',
'ELS Language Centers Cleveland',
'ELS Language Centers Columbus　',
'ELS Language Centers Oklahoma City',
'ELS Language Centers Portland',
'ELS Language Centers Pittsburgh',
'ELS Language Centers Bristol',
'ELS Language Centers Clemson-Greenville',
'ELS Language Centers  Myrtle Beach',
'ELS Language Centers Johnson City',
'ELS Language Centers  Nashville',
'ELS Language Centers Dallas',
'ELS Language Centers Houston',
'ELS Language Centers Houston（Clear Lake）',
'ELS Language Centers Lubbock',
'ELS Language Centers San Antonio',
'ELS Language Centers Fredericksburg',
'ELS Language Centers  Seattle',
'ELS Language Centers Tacoma',
'ELS Language Centers  Milwaukee',
'St.Giles New York',
'Mentor Language Institute（Hollywood）',
'Hawaii Palms English School',
'Universal English Academy',
'Embassy English Boston',
'EF International Washington DC',
'ELS Language Centers Fort Wayne',
'EF International Miami Beach',
'EF International San Diego',
'EF International Atlanta',
'EF International Seattle',
'Columbia West College',
'International House San Diego',
'コンバース・インターナショナル・スクール・オブ・ランゲージ',
'イーシー・イングリッシュ：・サンフランシスコ',
'エンバシー・シーイーエス・サンフランシスコ',
'セイント・ジャイルス・サンフランシスコ',
'イーエルエス・ランゲージ・センター ダウンタウン校',
'イングリッシュ・ランゲージ・インスティチュート',
'ブランドン・カレッジ',
'イーエフ・インターナショナル',
'イントラックス',
'アメリカン・アカデミー・オブ・イングリッシュ',
'イーエフ・インターナショナル・ランゲージ・スクール　ニューヨーク校',
'ランゲージ・スタディーズ・インターナショナル ニューヨーク',
'エンバシーイングリッシュ・ニューヨーク',
'イーシー・イングリッシュ・ランゲッジ・スクール',
'ハロー・ワールド・ランゲッジ・センター',
'カプラン インターナショナル',
'ランゲージ スタディス インターナショナル',
'マンハッタン ランゲージ',
'レナート バイリンガル ニューヨーク',
'イーシー・イングリッシュ',
'カレッジ・オブ・イングリッシュ・ランゲージ サンタモニカ',
'イーエルエス・ランゲージ・センターズ',
'カリフォルニア州立大学ロサンゼルス エクステンション',
'イングリッシュ・ランゲージ・センター サンタモニカ',
'カプラン・インターナショナル',
'メンター・ランゲージ・インスティチュート',
'ポリー ロサンゼルス',
'ランゲージ・システムズ・インターナショナル',
'エルエーエスシー・アメリカンランゲージ・アンド・カルチャー',
'カル・アメリカ',
'キングス・カレッジ',
'エンバシー・イングリッシュ',
'ザ・ランゲージ・インスティチュート',
'エフエルエス・インターナショナル',
'ユニバーシティ　オブ　ハワイ　アット　マノア　ニュー　インテンシブ　コース　イン　イングリッシュ',
'イーエフ　ランゲージスクール　ホノルル校',
'Zoni ランゲージセンター NY',
'ニューイングランド・スクール・オブ・イングリッシュ',
'TALKボストン校',
'ECボストン',
'ELSボストン・ダウンタウン校',
'カプラン・インターナショナル・イングリッシュ・ボストン校',
'キングスカレッジ・ボストン校',
'カプラン・インターナショナル・イングリッシュ・シアトル校',
'ポートランドイングリッシュランゲージアカデミー',
'カプランインターナショナル　サンタバーバラ校',
'イーエフインターナショナルランゲージスクール　サンタバーバラ校',
'イー・エス・エルランゲージセンター　サンタバーバラ校',
'カプランインターナショナル　シカゴ校',
'ハワイ　イングリッシュランゲージ　プログラム',
'アカデミアランゲージスクール',
'インターカルチュラル・コミュニケーション・カレッジ',
'イー・エル・エス・ランゲージ・センターズ',
'グローバルビレッジハワイ校',
'アメリカン・ランゲージ・コミュニケーション・センター',
'ベルランゲージスクール',
'イー・エル・エス・ランゲージ・センターズ ニューヨーク　マンハッタン',
'EF インターナショナル・ランゲージ・センター/ボストン校',
'ニューヨーク ランゲージ センター',
'セントラルパシフィックカレッジ',
'インスティテュートオブインテンシブイングリッシュ',
'イー・エフ　ロサンゼルス校',
'メントラカレッジ',
'イーシー・イングリッシュ',
'イーシー・イングリッシュ',
'イーシー・イングリッシュ',
'カプラン・インターナショナル・イングリッシュ・ロサンゼルス（ウィディアカレッジ）',
'カプラン・インターナショナル・イングリッシュ・ハーバード校',
'カプラン・インターナショナル',
'カプラン・インターナショナル',
'カプラン・インターナショナル',
'カプラン・インターナショナル',
'カプラン・インターナショナル',
'カプラン・インターナショナル',
'カプラン・インターナショナル',
'カプラン・インターナショナル',
'カプラン・インターナショナル',
'カプラン・インターナショナル',
'カプラン・インターナショナル',
'カプラン・インターナショナル',
'カプラン・インターナショナル',
'エンバシーイングリッシュ・フォートローダデール',
'エンバシーイングリッシュ・サンディエゴ',
'イー・エル・エス・ランゲージセンターズバークレー',
'イーエルエス・ランゲージセンターズ　ハリウッド',
'イーエルエス・ランゲージセンターズ　ラバーン',
'イーエルエス・ランゲージセンターズ　サンディエゴ',
'イーエルエス・ランゲージセンターズ　サンフランシスコノースベイ',
'イーエルエス・ランゲージセンターズ　シリコンバレー',
'イーエルエス・ランゲージセンターズ　サウザンドオークス',
'イーエルエス・ランゲージセンターズ',
'イーエルエス・ランゲージセンターズ',
'イーエルエス・ランゲージセンターズ  ワシントン',
'エーエルエス・ランゲージセンターズ　メルボルン',
'イーエルエス・ランゲージセンターズ　マイアミ',
'イーエルエス・ランゲージセンターズ　オーランド',
'イーエルエス・ランゲージセンターズ　セントピーターズバーグ',
'イーエスエル・ランゲージセンターズ　タンパ',
'イーエルエス・ランゲージセンターズ　アトランタ',
'イーエルエス・ランゲージセンターズ　シカゴ',
'イーエルエス・ランゲージセンターズ　シカゴ　ロメオビル',
'イーエルエス・ランゲージセンターズ　ディカルブ',
'イーエルエス・ランゲージセンターズ　インディアナポリス',
'イーエルエス・ランゲージセンターズ　リッチモンド‐ケンタッキー',
'イーエルエス・ランゲージセンターズ　ラストン',
'イーエルエス・ランゲージセンターズ　ボストン‐ニュートン',
'イーエルエス・ランゲージセンターズ　グランドラピッズ',
'イーエルエス・ランゲージセンターズ　セントポール',
'イーエルエス・ランゲージセンターズ　セントルイス',
'イーエルエス・ランゲージセンターズ　シャーロット',
'イーエルエス・ランゲージセンターズ　グランドフォークス',
'イーエルエス・ランゲージセンターズ　アトランティックシティ',
'イーエルエス・ランゲージセンターズ　フィラデルフィア',
'イーエルエス・ランゲージセンターズ　ティーネック',
'イーエルエス・ランゲージセンターズ　ニューヨークガーデンシティ',
'イーエルエス・ランゲージセンターズ　ニューヨークジュリアードセンター',
'イーエルエス・ランゲージセンターズ　ニューヨークリバーデール',
'イーエルエス・ランゲージセンターズ　ボーリンググリーン',
'イーエルエス・ランゲージセンターズ　シンシナティ',
'イーエルエス・ランゲージセンターズ　クリーブランド',
'イーエルエス・ランゲージセンターズ コロンバス',
'イーエルエス・ランゲージセンターズ　オクラホマシティ',
'イーエルエス・ランゲージセンターズ　ポートランド',
'イーエルエス・ランゲージセンターズ　ピッツバーグ',
'イーエルエス・ランゲージセンターズ　ブリストル',
'イーエルエス・ランゲージセンターズ　クレムソン‐グリーンヴィル',
'イーエルエス・ランゲージセンターズ　マートルビーチ',
'イーエルエス・ランゲージセンターズ　ジョンソンシティ',
'イーエルエス・ランゲージセンターズ　ナッシュビル',
'イーエルエス・ランゲージセンターズ　ダラス',
'イーエルエス・ランゲージセンターズ　ヒューストン',
'イーエルエス・ランゲージセンターズ　ヒューストン-クリアーレイク',
'イーエルエス・ランゲージセンターズ ラボック',
'イーエルエス・ランゲージセンターズ　サンアントニオ',
'イーエルエス・ランゲージセンターズ　フレデリックスバーグ',
'イーエルエス・ランゲージセンターズ　シアトル',
'イーエルエス・ランゲージセンターズ　タコマ',
'イーエルエス・ランゲージセンターズ　ミルウォーキー',
'セイント・ジャイルス・ニューヨーク',
'メンター・ランゲージ・インスティチュート',
'ハワイ・パームス・イングリッシュ・スクール',
'ユニバーサル・イングリッシュ・アカデミー LLC',
'エンバシーイングリッシュ・ボストン',
'イー・エフ　ワシントンDC校',
'イーエルエス・ランゲージセンターズ フォートウェイン',
'イー・エフ　マイアミ校',
'イー・エフ　サンディエゴ校',
'イー・エフ　アトランタ校',
'イー・エフ　シアトル校',
'コロンビア　ウウェスト　カレッジ',
'インターナショナルハウス　サンディエゴ'
  ];

  // オートコンプリートを設定
  $('#school_name').autocomplete({
    source: data,
    autoFocus: true,
    delay: 500,
    minLength: 2
  });
});

//  ==================== チェックボックス ====================
$(document).ready(function() {
    //セレクタを変数に格納
    var $tgt_parent = $("input.check-parent");
    var $tgt_child = $("input.check-child");

    //親チェックボックス関数
    $tgt_parent.click(function(){
        $(this).parents("div#search_right").find('div#check_box input.check-child').attr('checked', this.checked);
    });

    //子チェックボックス関数
    $tgt_child.click(function(){
        var checkNum = $(this).parents('div#check_box').find('input.check-child:checked').length;
        var listNum = $(this).parents('div#check_box').find('input').length;

        if(checkNum < listNum){
            $(this).parents("div#search_right").find("input.check-parent:checkbox").attr('checked','');
        }

        if(checkNum > listNum){
            $(this).parents("div#search_right").find("input.check-parent:checkbox").attr('checked','checked');
        }
    });
});


//  ==================== 最新情報　スライド ====================
$(function(){
	$('#slider7').bxSlider({
		auto:'true',
		speed:1000,
		infiniteLoop: 'true'
	});

	$("img.ChangePhoto").click(function(){
		var ImgSrc = $(this).data("src");
		var ImgAlt = $(this).attr("alt");
		$("img#MainPhoto").attr({src:ImgSrc,alt:ImgAlt});
		$("img#MainPhoto").hide();
		$("img#MainPhoto").fadeIn("slow");
		return false;
	});

	// タブの選択
	ChangeTab('details_tab');
});

//  ==================== クリックしたら下に出てくる ====================
$('#reserach').click(function () {
	$('#shcool_search').slideToggle();
});

//  ======= アコーディオン メニュー =============
$(function(){
	$("#acMenu dt").on("click", function() {
		$(this).next().slideToggle();
		$(this).toggleClass("active");//追加部分
	});
});

//======= チェックボックス一括処理（検索結果画面） =================
$(function(){
	$("input[name='all_post']").on("change", function() {
	    $("input[name='post_check[]']").prop("checked", this.checked);
	});
});

//  ==================== 閲覧履歴削除 ====================
$(function(){
	$("#history_del").on("click", function() {

		var history = $.cookie("ep-history");
		if(history == '' || history == undefined){
			return false;
		}

		var splits = history.split('_');

		$.removeCookie("ep-history", { path: '/', secure: false});

		$.each(splits, function() {
			$("#history" + this).html("");
		});
	});
});

//======= ログアウト =================
$(function(){
	$("#log_out").on("click", function() {
		$.removeCookie("gu_id", { path: "/", secure: false});
		$.removeCookie("se_id", { path: "/", secure: false});

		var url = location.hostname + "/login";

		location.replace(url);

		return false;

	});
});

//======= カレンダー =================
$(function(){
	$("#datepicker").datepicker({
		numberOfMonths: 1,
		showButtonPanel: false,
		dateFormat: 'yy/mm/dd',
		showOn: 'button'
	});
	$('.ui-datepicker-trigger').addClass('btn btn-default').html('<i class="glyphicon glyphicon-calendar"></i>').wrap('<span class="input-group-btn"></span>');
});

// ====== 電話をかける ==============
$(function() {
    var showFlag = false;
    var topBtn = $('#calltocampany');    
    topBtn.css('bottom', '-100px');
    var showFlag = false;
    //スクロールが100に達したらボタン表示
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            if (showFlag == false) {
                showFlag = true;
                topBtn.stop().animate({'bottom' : '20px'}, 200); 
            }
        } else {
            if (showFlag) {
                showFlag = false;
                topBtn.stop().animate({'bottom' : '-100px'}, 200); 
            }
        }
    });
});

// =================== 関数記述部 ==========================================
// ==================== OnOff 引数2つ ====================
function OnOff(id,id2) {
	if (id.style.display == "none") {
		id.style.display = "";
		id2.style.display = "none";

	}
	else {
		id.style.display = "none";
		id2.style.display = "";
	}
	window.event.cancelBubble = true;
}

//  ==================== OnOff 引数1つ ====================
function OnOff1(id) {
	if (id.style.display == "none") {
		id.style.display = "";
	}
	else {
		id.style.display = "none";
	}
	window.event.cancelBubble = true;
}

//  ==================== タブ ====================
function ChangeTab(tabname) {
	// 全部消す
	$("#details_tab_button").removeClass("active");
	$("#review_tab_button").removeClass("active");
	$('#details_tab').hide();
	$('#review_tab').hide();
		
	// 指定箇所のみ表示
	$('#'+tabname+'_button').addClass("active");
	$('#'+tabname).show();
}

//  ==================== USD→JPYレート取得 ====================
function getRate(){
	var rate = 0;

	// レートの取得
	$.ajax({
		type: "GET",
		url: "/wordpress/wp-content/themes/engp/batch/rate.json",
		async: false,
		success: function(json) {
			rate = json.rate;
		}
	});

	return rate;
}

//  ==================== USD→JPY変換 ====================
function usd2jpy(rate, usd, visacost){
	var riskRange = 1.03;
	var exUsd = usd.split(",").join("");
	exUsd = parseInt(exUsd.split("$").join(""));
	var exCost = visacost || 0;
	exCost = parseInt(exCost);

	if (isNaN(exUsd)){
		retData = "-";
	}else{
		// 四捨五入
		exYEN = Math.round(exUsd * rate * riskRange) + exCost;
		// 桁区切り
		retData = "¥" + String(exYEN).replace( /(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	}

	return retData;
}

//======= お気に入り =================
function favorite(mode, ID, post_id, shape){

	var post_id = $('#hiddenID').val();

	if(mode != 0){
		var mode		= arguments[0];
		var post_id		= arguments[1];
	}

	var ID 			= $('#hiddenUserID').val();
	var shape		= $('#hiddenShape').val();
	var html 		= "#favorite" + post_id;

	var data = {'action' : 'engp_favorite','ID' : ID,'post_id' : post_id, 'mode' : mode, 'shape': shape};

	$.ajax({
		url: ajaxurl,
		data: data,
		type: 'post',
		async: false,
		success: function(response) {
			if(response){
				$(html).html(response);
			}
			else{
				alert('お気に入りは20校以上登録出来ません。');
			}
		}
	});
}

//======= 比較チェック =================
function myCheck(){
	myCnt = 0;
	cmpid = "";
	var checks=[];

	// チェック対象を取得
	$("#check_box [name='post_check[]']:checked").each(function(){
		checks.push(this.value);
	});

	for(var i=0; i<checks.length; i++){
		// チェック数 加算
		myCnt++;
		cmpid += checks[i] + "_";
	}

	if( myCnt <= 1 ){
		myMess = "比較する学校を選択してください。";
		myComment = myMess;
		alert ( myComment );
	}else if( myCnt > 5 ){
		// チェックは 5以下
		myMess = "同時に比較できる学校は5つまでです。";
		myComment = myMess;
		alert ( myComment );
	}else{
		cmpid = cmpid.slice(0, -1);
		$('#cmpid').val(cmpid);
		document.compare.submit();
	}
}

//======= 日付チェック =================
function dateFormat(obj,flg){
	var str0 = obj.value;
	if(str0 == "" || str0.match(/^\d{4}\/\d{2}\/\d{2}$/)){
		return;
	}else if(str0.match(/[0-9]{8}/)){
		str1 = str0.substring(0,4) + "/" + str0.substring(4,6) + "/" + str0.substring(6,8);
		obj.value = str1;
	}else{
		alert("年月日の順に8桁の数字を入力してください");
		obj.value = "";
	}
}
