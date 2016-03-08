<?php
/*
 Template Name: パスワードリマインダー_送信完了
 */

//メールアドレス
$get_email = $_POST["email"];

$get_new_data = engp_pass_reminder($get_email);
$display_name = $get_new_data['displayName'];
$new_password = $get_new_data['tempPassword'];
$email_address = $get_new_data['mailAddress'];

get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">パスワードをお忘れの方へ</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="regist_main">
		<div class="regist_content_box2">
			<h1 class="regist_results_h">パスワードを送信しました</h1>
			<div id="form2">
				<div id="mailform_area">
<?php
	mb_language("Japanese");
	mb_internal_encoding("UTF-8");

	//メール
	$from_addr = MASTER_MAIL_ADDRES;
	$to_addr = $email_address;
	$header = "From: ".$from_addr;
	$footer = MASTER_MAIL_FOOTER;	

	$subject = "【EnglishPedia】パスワードのお知らせ";

	$body_content = <<<BODY
$display_name 様

EnglishPediaの仮パスワードをお知らせします。
仮パスワードでログイン後、パスワード変更を行って下さい。

■仮パスワード：$new_password

このメールに心当たりの無い場合は、
お手数ですが下記連絡先までお問い合わせください。
$footer
BODY;

	//送信
	$rslts = mb_send_mail($to_addr, $subject, $body_content, $header);
?>
				</div>
			</div>
			<div id="regist_results_line">ご登録頂いているEメールアドレスにパスワードを送信しました。<br />メールをご確認下さい。</div>
			<a href="<?php echo esc_url(home_url());?>"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/btn_regist_top.png" width="230" height="50" alt="EnglishPediaトップページへ戻る" class="btn_regist_top"/></a>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->

<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
