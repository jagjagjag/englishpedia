<?php
/*
 Template Name: 会員登録_登録完了
 */
get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title hidden-xs">ご登録ありがとうございました</h1>
<hr class="hidden-xs">
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="regist_main">
		<div class="regist_content_box2">
			<h1 class="regist_results_h">会員登録完了</h1>
            <h2 class="hidden-md hidden-sm hidden-lg">ご登録ありがとうございました</h2>
			<div id="form2">
				<div id="mailform_area">
<?php
	mb_language("japanese");
	mb_internal_encoding("UTF-8");
	//メール
	$get_email = $_POST["email"];
	//パスワード
	$get_password = $_POST["password"];
	//名前
	$get_display_name = $_POST["display_name"];
	//DBに登録
	engp_user_regist();

	//メール
	$from_addr = MASTER_MAIL_ADDRES;
	$to_addr = $get_email;
	$header = "From: ".$from_addr;
	$footer = MASTER_MAIL_FOOTER;

	$subject = "【EnglishPedia】会員登録完了 \n";

	$body_content = <<<BODY
$get_display_name 様

この度はEnglishPediaへご入会いただき
誠にありがとうございます。

ご登録いただきましたログイン情報は次のとおりです。

■ログインID： $get_email
■パスワード： 申し込み時に入力したパスワード

※このメールにお心当たりがない場合、大変お手数ですが、
　メール本文に「登録した記憶がありません。」とご明記の上、
　このメールをそのままご返信ください。
	
$footer
BODY;

	//送信
	$rslts = mb_send_mail($to_addr, $subject, $body_content, $header);
?>
				</div>
			</div>
			<div id="regist_results_line">ご登録完了のメールをお送りしました。<br>ログインしてご利用下さい。</div>
			<a href="<?php echo esc_url(home_url());?>"/><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/btn_regist_top.png" width="230" height="50" alt="EnglishPediaトップページへ戻る" class="btn_regist_top"/></a>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->

<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
