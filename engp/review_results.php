<?php
/*
 Template Name: レビュー投稿_投稿完了
 */
get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">レビュー投稿完了</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="regist_main">
		<div class="regist_content_box2">
			<h1 class="regist_results_h">レビューをご投稿頂き<br />ありがとうございました。</h1>
			<div id="form2">
				<a href="<?php echo esc_url(home_url());?>"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/btn_regist_top.png" width="230" height="50" alt="EnglishPediaトップページへ戻る" class="btn_regist_top"/></a>
<?php
	$post_id = $_POST["post_id"];
	$file_name = $_POST["file_name"];

	if($file_name){
		$tmp_dir = PHOTO_DIR.'tmp/';
		$unapproved_dir = PHOTO_DIR.$post_id.'/unapproved/';
		$approved_dir = PHOTO_DIR.$post_id.'/approved/';
		if(!file_exists($unapproved_dir)){
			mkdir($unapproved_dir,0777,TRUE);
			mkdir($approved_dir,0777,TRUE);
		}

		//ファイル移動
		foreach ($file_name as $move_file) {
 			$result = rename($tmp_dir.$move_file, $unapproved_dir.$move_file);
// 			if (($result = rename($tmp_dir.$move_file, $unapproved_dir.$move_file)) === true) {
// 				echo "ファイルの移動に成功しました。<br />";
// 			} else {
// 				echo "ファイルの移動に失敗しました。";
// 			}
		}
	}

	//DBに登録
	engp_review_post();
?>
			</div>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->
<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
