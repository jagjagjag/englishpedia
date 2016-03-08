<?php
/*
 Template Name: 学校情報相違通報
*/

$post_id = $_GET['repoid'];
$school_data = engp_get_school($post_id);

get_header('nologin');
?>

	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>" />

	<!-- Start: タイトル、hr -->
	<h1 class="regist_entry_title">
		学校情報の間違いを報告する
	</h1>
	<hr>
	<!-- End: タイトル、hr -->

	<!-- Start: コンテンツ -->
	<div class="container">
		<div class="regist_main">
			<p class="regist_line">学校情報に誤りがあった場合、こちらからお知らせ下さい。<br>下記項目をご記入の上、「送信内容の確認」ボタンを押して下さい。</p>
			<div class="regist_content_box">
				<form class="form-horizontal" name="report_form" method="post" action="<?php echo esc_url(home_url());?>/schoolreport_conf" enctype="multipart/form-data" onsubmit="return report_val_check(0);">
					<div class="regist_form">
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p>以下の必要事項を入力してください。（<span class="regist_chk_notes">*</span>は必須項目です）</p>
							</div>
						</div>
						
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="regist_head">
									<label for="name">お名前</label>
								</p>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-offset-2 col-md-8">
								<input id="report_name" class="form-control" name="report_name" type="text" />
							</div>
						</div>
						
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="regist_head">
									<label for="email">メールアドレス</label>
								</p>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-offset-2 col-md-8">
								<input id="email" class="form-control" name="email" type="text" />
							</div>
						</div>

						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="regist_head">
									<label for="report_school">誤情報が含まれる学校名</label>
								</p>
							</div>
						</div>
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p><?php echo $school_data ->school_name?></p>
								<p><?php echo $school_data ->school_jp_name?></p>
							</div>
						</div>

						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="regist_head">
									<label for="reporttxt"><span class="regist_chk_notes">*</span>内容</label>
								</p>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-offset-2 col-md-8">
								<textarea name="reporttxt" class="form-control" rows="10" style="width:100%;"></textarea>
							</div>
						</div>

						<input type="hidden" name="postID" value="<?php echo $post_id?>" />
						<input type="hidden" name="school_name" value="<?php echo $school_data ->school_name?>" />
						<input type="hidden" name="school_jp_name" value="<?php echo $school_data ->school_jp_name?>" />
						<div id="regist_confirm">
						<input type="submit" value="" alt="入力内容の確認" id="btn_regist_confirm">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- End:コンテンツ -->
<?php get_footer(); ?>
	<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/textcheck.js" type="text/javascript"></script>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
