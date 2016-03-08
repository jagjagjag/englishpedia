<?php
/*
 Template Name: 会員情報更新
*/
// ログインして無い場合はログイン画面へ飛ばす
if(empty($_COOKIE['gu_id'])){
	$loginUrl = esc_url(home_url()) . "/login";
	header("Location: {$loginUrl}");
}
$ID = engp_get_id($_COOKIE['gu_id']);
$user_data = engp_get_user($ID);

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

			<p class="regist_line">	ユーザー情報更新フォームです。<br>更新したい項目を入力して、「送信内容の確認」ボタンを押して下さい。</p>
			<div class="regist_content_box3">
				<form class="form-horizontal" name="regist_form" method="post" action="<?php echo esc_url(home_url());?>/update_conf" enctype="multipart/form-data" onsubmit="return regist_val_check(1);">
					<div class="regist_form">
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p>以下の必要事項を入力してください。（<span class="regist_chk_notes">*</span>は必須項目です）</p>
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
								<input name="display_name" class="form-control" size="40" value="<?php echo ($user_data->display_name);?>" type="text">
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
								<input name="email" class="form-control" size="40" value="<?php echo ($user_data->email);?>" type="text">
							</div>
						</div>

						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="regist_head">
									<label for="password">新しいパスワード</label>
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
									<label for="password">新しいパスワード（確認用）</label>
								</p>
							</div>
						</div>
						<div class="form-group row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<input name="password_confirm" class="form-control" size="40" value="" maxlength="20" type="text">
							</div>
						</div>
					</div>
					<input type="hidden" name="ID" value="<?php echo ($user_data->user_id);?>" />
					<div id="regist_confirm">
						<input type="submit" value="" alt="入力内容の確認" id="btn_regist_confirm">
					</div>
				</form>
			</div>

			<form class="form-horizontal" name="unregist_form" method="post" action="<?php echo esc_url(home_url());?>/unregist_conf" enctype="multipart/form-data">
				<input type="hidden" name="ID" value="<?php echo ($user_data->user_id);?>" />
				<div id="regist_confirm">
					<input type="submit" value="" alt="EnglishPediaの退会" id="btn_resign_confirm">
				</div>
			</form>
		</div>
	</div>
	<!-- End:コンテンツ -->
<?php get_footer(); ?>
	<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/textcheck.js" type="text/javascript"></script>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
