<?php
/*
 Template Name: 会員情報更新_更新完了
 */
get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">ユーザー情報を更新しました</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container footer_position">
	<div class="regist_main">
		<div class="regist_content_box3result">
<!-- 			<h1 class="regist_results_h">ユーザー情報更新完了</h1> -->
			<div id="form2">
				<div id="mailform_area">
<?php
	mb_language("Japanese");
	mb_internal_encoding("UTF-8");

	//メール
	$get_email = $_POST["email"];
	//パスワード
	$get_password = $_POST["password"];
	//名前
	$get_display_name = $_POST["display_name"];
	//名前
	$get_ID = $_POST["ID"];
	//DBに登録
	engp_user_regist();

	//メール
	$from_addr = MASTER_MAIL_ADDRES;
	$to_addr = $get_email;
	$header = "From: ".$from_addr;
	$footer = MASTER_MAIL_FOOTER;	

	$subject = "【EnglishPedia】会員情報更新完了";

	$body_content = <<<BODY
EnglishPediaからのお知らせ

$get_display_name 様

EnglishPedia会員情報の登録内容を変更しましたので、ご連絡させていただきます。

このメールに心当たりの無い場合は、
お手数ですが下記連絡先までお問い合わせください。

$footer
BODY;

	//送信
	$rslts = mb_send_mail($to_addr, $subject, $body_content, $header);
?>
				</div>
			</div>
			<div id="regist_results_line">ユーザー情報更新のメールをお送りしました。</div>
			<a href="<?php echo esc_url(home_url());?>"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/btn_regist_top.png" width="230" height="50" alt="EnglishPediaトップページへ戻る" class="btn_regist_top"/></a>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->
<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
