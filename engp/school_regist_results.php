<?php
/*
 Template Name: 学校新規登録申請_送信完了
 */
get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/apply-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="apply_entry_title">掲載学校追加のお問い合わせ</h1>
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

	$staff_name					= $_POST["staff_name"];
	$staff_email				= $_POST["staff_email"];

	$school_name				= $_POST["school_name"];
	$school_jp_name				= $_POST["school_jp_name"];
	$school_address				= $_POST["school_address"];
	$school_tel					= $_POST["school_tel"];
	$school_city				= $_POST["school_city"];
	$school_division			= $_POST["school_division"];
	$school_about				= $_POST["school_about"];
	$school_hp					= $_POST["school_hp"];
	$school_youtube				= $_POST["school_youtube"];

	$currency					= $_POST["currency"];	
	$school_fee_admission		= $_POST["school_fee_admission"];
	$school_fee_accommodation	= $_POST["school_fee_accommodation"];
	$school_fee_I20				= $_POST["school_fee_I20"];
	$school_fee_airport			= $_POST["school_fee_airport"];

	$school_fee_bankcharge		= $_POST["school_fee_bankcharge"];
	$school_tuition4w_part		= $_POST["school_tuition4w_part"];
	$school_tuition4w_full		= $_POST["school_tuition4w_full"];
	$school_tuition4w_stay		= $_POST["school_tuition4w_stay"];
	$school_tuition4w_text		= $_POST["school_tuition4w_text"];

	$from_addr = MASTER_MAIL_ADDRES;
	$to_addr = $staff_email;
	$header = "From: ".$from_addr;
	$header .= "\n";
	$header .= "BCC: ".$from_addr;
	$footer = MASTER_MAIL_FOOTER;

	$subject = "【EnglishPedia】掲載学校追加のお問い合わせ";

	$body_content = <<<BODY
$staff_name 様

この度はEnglishPediaより掲載学校追加のお問い合わせを頂き誠にありがとうございます。
学校情報につきまして下記の内容で受付致しました。
担当者よりご連絡させていただきますので、
今しばらくお待ち頂けますようよろしくお願いいたします。

--------------------------------- 

【ご担当者様情報】
■ご担当者様名
$staff_name 様

■ご担当者様のメールアドレス
$staff_email

【 学校情報 】	
	
■学校名(英名)
$school_name

■学校名(和名)
$school_jp_name

■学校の所在地
$school_address

■電話番号
$school_tel

■都市
$school_city

■エリア
$school_division

■概要(学校紹介文)
$school_about

■学校のHPアドレス
$school_hp

■学校紹介動画(YouTubeアドレス)
$school_youtube

【 料金情報 】	
	
■入学金
$currency $school_fee_admission

■滞在先手配料
$currency $school_fee_accommodation

■I20発行・送料
$currency $school_fee_I20

■空港出迎え費
$currency $school_fee_airport

■バンクチャージ
$currency $school_fee_bankcharge

【 4週間の学費 】

■授業料(パートタイム)
$currency $school_tuition4w_part

■授業料(フルタイム)
$currency $school_tuition4w_full

■滞在費
$currency $school_tuition4w_stay

■テキスト代
$currency $school_tuition4w_text

--------------------------------- 
		
お急ぎの場合は下記の連絡先まで
お電話にてご連絡下さいますようよろしくお願い申し上げます。
この度は掲載学校追加のお問い合わせを頂き誠にありがとうございました。

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
