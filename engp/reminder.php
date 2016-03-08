<?php
/*
 Template Name: パスワードリマインダー
*/
get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>" />

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">パスワードをお忘れの方へ</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="regist_main">
		<p class="regist_line">
			パスワードを確認したいメールアドレスを入力し、送信ボタンを押して下さい。<br>入力されたメールアドレスにパスワードをお送りします。
		</p>
		<div class="regist_content_box">
			<form class="form-horizontal" name="remind_form" method="post" action="<?php echo esc_url(home_url());?>/reminder_result" enctype="multipart/form-data" onsubmit="return remind_val_check();">
				<div class="regist_form">

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="regist_head">
								<label for="email"><span class="regist_chk_notes">*</span>Eメールアドレス</label>
							</p>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<input name="email" class="form-control" size="40" value=""  type="text">
						</div>
					</div>
				</div>

				<input type="hidden" name="remind" value="1" />
				<div id="regist_confirm">
					<input type="submit" value="" alt="送信" id="btn_remind_send">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->

<?php get_footer(); ?>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/textcheck.js" type="text/javascript"></script>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
