<?php
/*
 Template Name: 学校情報相違通報_送信完了
 */

get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">学校情報の間違いを報告する</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="regist_main">
		<div class="regist_content_box2">
			<h1 class="regist_results_h">報告が完了しました。</h1>
			<div id="form2">
				<div id="mailform_area">
<?php
	mb_language("Japanese");
	mb_internal_encoding("UTF-8");

	$school_name	 = $_POST["school_name"];
	$school_jp_name	 = $_POST["school_jp_name"];
	$report_name	 = $_POST["report_name"];
	$email			 = $_POST["email"];
	$report_text	 = $_POST["report_text"];
	
	//メール
	$from_addr = MASTER_MAIL_ADDRES;
	$to_addr = $email;
	$header = "From: ".$from_addr;
	$header .= "\n";
	$header .= "BCC: ".$from_addr;
	$footer = MASTER_MAIL_FOOTER;
	
	$subject = "【EnglishPedia】学校情報相違通報";

	$body_content = <<<BODY
$report_name 様
	
ご連絡いただき誠にありがとうございます。
下記の内容にて学校情報の相違についてのご連絡を承りました。
近日中に学校情報の確認を行い、情報を修正いたします。

---------------------------------------	

■学校名
$school_name
($school_jp_name)

■内容
$report_text
	
---------------------------------------

お急ぎの場合は下記の連絡先まで
お電話にてご連絡下さいますようよろしくお願い申し上げます。
この度は学校情報の相違についてのご連絡を誠にありがとうございました。

また、このメールに心当たりの無い場合は、
お手数ですが下記連絡先までお問い合わせください。
			
$footer
			
BODY;

	//送信
	$rslts = mb_send_mail($to_addr, $subject, $body_content, $header);
?>
				</div>
			</div>
			<div id="regist_results_line">学校情報の間違いをお知らせ頂きありがとうございました。</div>
			<a href="<?php echo esc_url(home_url());?>"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/btn_regist_top.png" width="230" height="50" alt="EnglishPediaトップページへ戻る" class="btn_regist_top"/></a>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->

<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
