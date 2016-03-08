<?php
/*
Template Name: Global wifi キャンペーン
*/
get_header();
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/other.css' ); ?>"/>
<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/globalwifi.css' ); ?>"/>

<!-- Start: コンテンツ -->
	<!-- Start: タイトル、hr -->
	<!-- End: タイトル、hr -->

	<!-- Start: コンテンツ -->
	<div class="container">
		<div class="int_main_small">
	    <h1 class="gwifi_h1"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/gwifi_title.png" alt="留学情報館ご利用でGlobalwifi月額16000円お得"></h1>
        
        <p class="gwifi_txt1">留学中、観光に、情報収集にスマートフォンは不可欠。でも、Wifiルーターの料金も決して安くない(T_T)<br>
        そこで、留学情報館はGlobal Wifiと提携しました！留学情報館が費用の一部を負担することによって、<br>
        お客様が<span>気軽に使える料金</span>を設定。わずか<span>月額3,980円</span>で日本からWifiルーターが持ち込めます！<br>
        留学情報館ならではこの企画をぜひご利用ください。</p>
        
        <h2 class="gwifi_h2">留学中にwifiがあるとこんなに便利！</h2>
        
        <div class="clearfix">
        <div class="gwifi_box">
		<p class="gwifi_ph"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/gwifi_ph_1.png" alt="ホームステイ先で" /></p>
        <p class="gwifi_txt2">ホームステイ先のインターネット回線を使わせてもらうには、ちょっと気が引ける。そんな事を気にせずに部屋で堂々とインターネットの利用が可能！</p>
        </div>

        <div class="gwifi_box">
		<p class="gwifi_ph"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/gwifi_ph_2.png" alt="学校の外でも" /></p>
        <p class="gwifi_txt2">授業中のみ学校の無線LANが使用可能。一歩外に出たらもう使えない。海外でのインターネットのプライベート利用にはwifiが必須！</p>
        </div>
        
        <div class="gwifi_box">
		<p class="gwifi_ph"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/gwifi_ph_3.png" alt="スマホもPCもタブレットも" /></p>
        <p class="gwifi_txt2">wifiルータがあればスマホやPCはもちろん、タブレットでもインターネットが使える！アプリのチャットや通話、メールでの連絡やネットでの情報収集ができるから便利！</p>
        </div>
        </div>
        
        <h2 class="gwifi_h2">Wifiルーターを1ヶ月間借りると通常・・・</h2>
        
		<p class="gwifi_gr"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/gwifi_gr.png" alt="留学情報館をご利用で！wifi月額3980円" /></p>
        <p class="gwifi_arrow"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/gwifi_arrow.png" alt="" /></p>        
        <p class="gwifi_txt3">つまり、通常より月額<span>約16,000円もお得！</span></p>
        
 	

			<!-- Start: お問い合わせください -->
			<div class="row" id="contact_box">
				<h3>まずはお気軽にお問い合わせください！</h3>			
				<div class="col-md-6 col-sm-6 col-xs-12" id="contact_box_fff" style="margin:0px; padding:10px;">

				<p>「留学はしたいが具体的なプランが決まっていない」「留学に行きたい気持ちはあるが…」まだ留学のプランがおぼろげでも、お気軽にお問い合わせください。<br> 経験豊富なカウンセラーが親身になってお答えいたします。</p>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/contact_byphone02.png" alt="お電話でのお問い合わせはこちらから" class="bud_margintop"/>
				<div class="btndeco3"><a href="//www.nes-ryugaku.com/counseling/">無料留学カウンセリングに申し込む</a></div>
				<div>
				</div>
				</div>
            </div>
			<!-- End: お問い合わせください -->

    </div>
</div>
<!-- End:コンテンツ -->
<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>