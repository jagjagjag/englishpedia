<?php
/*
 Template Name: 留学申し込み_送信完了
 */
get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/apply-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="apply_entry_title">留学のお申込み</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="apply_main">
		<div class="apply_content_box2"  style="text-align:center;">
			<div id="form2">
				<div id="mailform_area">
<?php
	mb_language("japanese");
	mb_internal_encoding("UTF-8");

	//希望学校
	$get_want_school = $_POST["want_school"];
	//コース
	$get_course = $_POST["course"];
	//開始年月　年
	$get_start_year = $_POST["start_year"];
	//開始年月　月
	$get_start_month = $_POST["start_month"];
	//留学期間
	$get_period = $_POST["period"];
	//滞在先
	$get_stay_type = $_POST["stay_type"];
	//滞在先の手配期間
	$get_arrange_period = $_POST["arrange_period"];
	//姓
	$get_last_name = $_POST["last_name"];
	//名
	$get_first_name = $_POST["first_name"];
	//セイ
	$get_last_name_kana = $_POST["last_name_kana"];
	//メイ
	$get_first_name_kana = $_POST["first_name_kana"];
	//電話 1
	$get_tel = $_POST["tel"];
	//メール
	$get_email = $_POST["email"];
	//郵便番号
	$get_postal = $_POST["postal"];
	//都道府県
	$get_prefecture = $_POST["prefecture"];
	//ご住所
	$get_address = $_POST["address"];
	//建物名
	$get_build = $_POST["build"];
	//キャンペーン参加有無
	$get_campaign = $_POST["campaign"];	

	//オプション
	$get_option1 = $_POST["option1"];
	$get_option2 = $_POST["option2"];
	$get_option3 = $_POST["option3"];
	$get_option4 = $_POST["option4"];	
	
	$from_addr = MASTER_MAIL_ADDRES;
	$to_addr = $get_email;
	$header = "From: ".$from_addr;
	$header .= "\n";
	$header .= "BCC: ".$from_addr;
	$footer = MASTER_MAIL_FOOTER;

	$subject = "【EnglishPedia】留学のお申込み";

	$body_content = <<<BODY
$get_last_name $get_first_name 様

この度はEnglishPediaより留学のお申し込みを頂き誠にありがとうございます。
留学のお申し込みを以下の内容で受付致しました。
サポートセンターよりご連絡させていただきますので、
今しばらくお待ち頂けますようよろしくお願いいたします。

--------------------------------- 

■希望学校：
$get_want_school

■コース：
$get_course

■開始年：
$get_start_year

■開始月：
$get_start_month

■留学期間：
$get_period

■滞在先：
$get_stay_type

■滞在先の手配期間：
$get_arrange_period
	
■名前：
$get_last_name $get_first_name 様

■ふりがな：
$get_last_name_kana $get_first_name_kana

■メールアドレス：
$get_email

■電話番号：
$get_tel

■郵便番号：
〒 $get_postal

■都道府県：
$get_prefecture

■ご住所：
$get_address

■建物名：
$get_build
	
■レビュー投稿キャンペーン
$get_campaign
	
■ビザ申請サポート
$get_option1

■飛行機チケットの手配
$get_option2
	
■海外留学保険の取得
$get_option3

■空港出迎え・現地留学サポート
$get_option4
	
--------------------------------- 
		
お急ぎの場合は下記の連絡先まで
お電話にてご連絡下さいますようよろしくお願い申し上げます。
この度は留学のお申し込みを頂き誠にありがとうございました。

また、このメールに心当たりの無い場合は、
お手数ですが下記連絡先までお問い合わせください。

$footer		

BODY;

	//送信
	$rslts = mb_send_mail($to_addr, $subject, $body_content, $header);
?>

				</div>
			</div>
			<div id="apply_results_line">
				EnglishPediaサポートセンターよりご連絡をさせて頂きます。<br>この度は、EnglishPediaより留学のお申し込みを頂きありがとうございました。</div>
				<a href="<?php echo esc_url(home_url());?>"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/btn_apply_top.png" width="230" height="50" alt="EnglishPediaトップページへ戻る" class="btn_apply_top"/></a>	
			</div>
		</div>
	</div>
<!-- End:コンテンツ -->
<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
