<?php
/*
 Template Name: 会員登録
*/
get_header('nologin');
?>

	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>" />

	<!-- Start: タイトル、hr -->
	<h1 class="regist_entry_title">
		<?php the_title(); ?>
	</h1>
	<hr>
	<!-- End: タイトル、hr -->

	<!-- Start: コンテンツ -->
	<div class="container">
		<div class="regist_main">
			<p class="regist_line">会員登録フォームです。<br>下記項目をご記入の上、「送信内容の確認」ボタンを押して下さい。</p>
           
			<div class="regist_content_box">
				<form class="form-horizontal" name="regist_form" method="post" action="<?php echo esc_url(home_url());?>/regist_conf" enctype="multipart/form-data" onsubmit="return regist_val_check(0);">

					<div class="regist_form">
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p id="regist_conf_line">以下の必要事項を入力してください。（<span class="regist_chk_notes">*</span>は必須項目です）</p>
							</div>
						</div>

						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="regist_head">
									<label for="display_name"><span class="regist_chk_notes">*</span>名前</label>
								</p>
							</div>
						</div>
						<div class="form-group row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<input name="display_name" class="form-control" size="40" value="" type="text">
								<p>ここで入力した名前は、学校レビュー投稿時に公開されます。</p>
							</div>
						</div>

						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="regist_head">
									<label for="email"><span class="regist_chk_notes">*</span>Eメールアドレス</label>
								</p>
							</div>
						</div>
						<div class="form-group row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<input name="email" class="form-control" size="40" value=""  type="text">
							</div>
						</div>

						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="regist_head">
									<label for="password"><span class="regist_chk_notes">*</span>登録パスワード</label>
								</p>
							</div>
						</div>
						<div class="form-group row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<input name="password" class="form-control" size="40" value="" maxlength="20" type="text">
							</div>
						</div>

						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="regist_head">
									<label for="password"><span class="regist_chk_notes">*</span>登録パスワード（確認用）</label>
								</p>
							</div>
						</div>
						<div class="form-group row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<input name="password_confirm" class="form-control" size="40" value="" maxlength="20" type="text">
							</div>
						</div>
					
						<div class="form-group row mgnB8">
								<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12 checkbox-inline" style="padding-left: 45px;">
									<input type="checkbox" name="agree" value="同意します">
									<label for="agree"><a href="<?php echo esc_url(home_url());?>/terms" target="_blank">約款</a>及び<a href="<?php echo esc_url(home_url());?>/policy" target="_blank">個人情報の取扱について</a>同意する</label>
								</div>
							</div>
						</div>
					</div>					

					<input type="hidden" name="ID" value="" />
					<div id="regist_confirm">
						<input type="submit" value="" alt="入力内容の確認" id="btn_regist_confirm">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- End:コンテンツ -->
<?php get_footer(); ?>
	<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/textcheck.js" type="text/javascript"></script>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
