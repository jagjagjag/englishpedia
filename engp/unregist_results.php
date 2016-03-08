<?php
/*
 Template Name: 会員退会_退会完了
 */
$ID = engp_get_id($_COOKIE['gu_id']);
$user_data = engp_get_user($ID);
// cookie廃棄処理
setcookie('gu_id', "", time() - 3600, '/', null, 0);
setcookie('se_id', "", time() - 3600, '/', null, 0);

get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">ご利用ありがとうございました</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="regist_main">
		<div class="regist_content_box2">
			<h1 class="regist_results_h">退会完了</h1>
			<div id="form2">
<?php
	$from_addr = MASTER_MAIL_ADDRES;
	$to_addr = $user_data->email;
	$header = "From: ".$from_addr;
	$footer = MASTER_MAIL_FOOTER;
	
	$subject = "【EnglishPedia】退会処理が完了しました \n";
	
	$body_content = <<<BODY
	$user_data->display_name 様
	
	EnglishPediaの退会処理が完了しました。
	ご利用いただき誠にありがとうございました。
	
	
	このメールに心当たりの無い場合は、
	お手数ですが下記連絡先までお問い合わせください。
	$footer	
BODY;

	//送信
	$rslts = mb_send_mail($to_addr, $subject, $body_content, $header);
	
	//DBに登録
	engp_user_regist();
?>
			</div>
			<div id="regist_results_line">会員登録処理が完了しました。<br />ご利用ありがとうございました。</div>
			<a href="<?php echo esc_url(home_url());?>"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/btn_regist_top.png" width="230" height="50" alt="EnglishPediaトップページへ戻る" class="btn_regist_top"/></a>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->

<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
