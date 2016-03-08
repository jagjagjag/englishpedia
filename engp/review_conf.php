<?php
/*
 Template Name: レビュー投稿_内容確認
 */

$display_name			 = $_POST["display_name"];
$security_evaluation	 = $_POST["security_evaluation"];
$traffic_evaluation		 = $_POST["traffic_evaluation"];
$clean_evaluation		 = $_POST["clean_evaluation"];
$staff_evaluation		 = $_POST["staff_evaluation"];
$lesson_evaluation		 = $_POST["lesson_evaluation"];
$student_evaluation		 = $_POST["student_evaluation"];
//$answer_1				 = $_POST["answer_1"];
//$answer_2				 = $_POST["answer_2"];
//$answer_3				 = $_POST["answer_3"];
//$answer_4				 = $_POST["answer_4"];
//$review_text			 = $_POST["review_text"];
$voice_text			 	 = $_POST["voice_text"];
$satisfaction_evaluation = $_POST["satisfaction_evaluation"];
$repeat_discount_know	 = $_POST["repeat_discount_know"];

//$answer_1 = nl2br($answer_1);
//$answer_2 = nl2br($answer_2);
//$answer_3 = nl2br($answer_3);
//$answer_4 = nl2br($answer_4);
//$review_text = nl2br($review_text);
$voice_text = nl2br($voice_text);

$school_name			 = $_POST["school_name"];
$school_jp_name			 = $_POST["school_jp_name"];
$ID						 = $_POST["ID"];
$post_id				 = $_POST["postID"];

if(empty($school_name) and empty($school_jp_name)){
	$school_data = engp_get_school($post_id);
	$school_name	 = $school_data->school_name;
	$school_jp_name	 = $school_data->school_jp_name;;
}

get_header('nologin');

// ファイル処理
// 複数ファイルのアップロード対応
$photo_file_name = "";
//一時保存用ディレクトリが存在するかチェック
$dir = PHOTO_DIR.'tmp/';
if(!file_exists($dir)){
	if (!mkdir($dir,0777,TRUE)) {
		// ディレクトリ生成に失敗
		//echo 'Failed to create directory: ';
	}
}

foreach ($_FILES["files"]["error"] as $key => $value) {
	// アップロード成功した際の処理
	if ($value == UPLOAD_ERR_OK) {
		// ファイル名、拡張子
		$file_name = $_FILES["files"]["name"][$key];
		$extension = substr($file_name, strrpos($file_name, '.'));
		$file_list[] = $file_name;
		// ファイルタイプ（MIME）
		$file_type = $_FILES["files"]["type"][$key];
		// ファイルサイズ（byte）
		$file_size = $_FILES["files"]["size"][$key];
		// 一時的に保存された場所へのパス
		$file_temp = $_FILES["files"]["tmp_name"][$key];

		// 保存するファイル名 作成
		$new_name = uniqid("$post_id"."_").$extension;
		$new_name_list[] = $new_name;
		$file = $dir.$new_name;

 		if (($result = move_uploaded_file($file_temp, $file)) === true) {
 			// 画像サイズ算出
 			list($width, $height) = getimagesize($file);
 			$widthNew = $width;
 			$heightNew = $height;
 			// リサイズ
 			$image_p = imagecreatetruecolor($widthNew, $heightNew);
 			// 横幅を高さに合わせて縮小
 			$image = imagecreatefromjpeg($file);
 			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $widthNew, $heightNew, $width, $height);
 			// Exifより回転角度取得(iPadで撮影した画像の場合の対応)
 			$exif_datas = exif_read_data($file);
 			$rotate = 0;
 			if(isset($exif_datas['Orientation'])){
 				if ($exif_datas['Orientation'] == 3) {
 					$rotate = 180;
 				} elseif ($exif_datas['Orientation'] == 6) {
 					$rotate = 270;
 				} elseif ($exif_datas['Orientation'] == 8) {
 					$rotate = 90;
 				}
 			}
 			if ($rotate != 0) {
 				$image_p = imagerotate($image_p, $rotate, 0);
 				imagejpeg($image_p, $file);
 				imagedestroy($image_p);
 			}

 		} else {
 			echo "ファイルのアップロードに失敗しました。";
 		}
	}
}


?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">レビュー内容のご確認</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="regist_main">
		<div class ="review_content_box">
				<div id="regist_conf_line2">
				以下の内容をご確認のうえ、よろしければ「投稿する」をクリックしてください。<br>
				内容を変更される場合は「戻る」ボタンをクリックしてレビュー投稿フォームへお戻りください。
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-5 col-xs-12">
						<p class="title">お名前</p>
					</div>
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<?php echo esc_html($display_name) ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<hr>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-5 col-xs-12">
						<p class="title">学校名</p>
					</div>
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
							<?php echo $school_name ?><br /><?php echo $school_jp_name ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<hr>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<p class="title">ご利用者様の声</p>
					</div>
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<?php
						$change_char = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $voice_text);
						echo nl2br(esc_html($change_char));
						?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<hr>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-4 col-sm-offset-1 col-sm-5 col-xs-12">
						<p class="title">満足度</p>
					</div>
					<div class="col-md-4 col-sm-5col-xs-12">
						<?php echo $satisfaction_evaluation ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<hr>
					</div>
				</div>


				<div class="row">
					<div class="col-md-offset-2 col-md-4 col-sm-offset-1 col-sm-5 col-xs-12">
						<p class="title">学校周辺の治安</p>
					</div>
					<div class="col-md-4 col-sm-5col-xs-12">
						<?php echo $security_evaluation ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-4 col-sm-offset-1 col-sm-5col-xs-12">
						<p class="title">交通の便</p>
					</div>
					<div class="col-md-4 col-sm-5col-xs-12">
						<?php echo $traffic_evaluation ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-4 col-sm-offset-1 col-sm-5col-xs-12">
						<p class="title">衛生面(綺麗さ)</p>
					</div>
					<div class="col-md-4 col-sm-5col-xs-12">
						<?php echo $clean_evaluation ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-4 col-sm-offset-1 col-sm-5col-xs-12">
						<p class="title">学校スタッフの対応</p>
					</div>
					<div class="col-md-4 col-sm-5col-xs-12">
						<?php echo $staff_evaluation ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-4 col-sm-offset-1 col-sm-5col-xs-12">
						<p class="title">授業内容</p>
					</div>
					<div class="col-md-4 col-sm-5col-xs-12">
						<?php echo $lesson_evaluation ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-4 col-sm-offset-1 col-sm-5col-xs-12">
						<p class="title">周りの学生の真剣さ</p>
					</div>
					<div class="col-md-4 col-sm-5col-xs-12">
						<?php echo $student_evaluation ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<hr>
					</div>
				</div>

<!--				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<p class="title">あなたの学校で気に入ってる先生やクラスを教えて下さい
					</div>
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<?php echo $answer_2 ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<hr>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<p class="title">その他、あなたの学校で気に入ってる点について教えてください</p>
					</div>
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<?php echo $answer_3 ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<hr>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<p class="title">その他、あなたの通っている学校について気に入らない点について教えて下さい</p>
					</div>
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<?php echo $answer_4 ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<hr>
					</div>
				</div>


				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<p class="title">あなたの学校の大体の国籍比率を教えて下さい<br>(クラスではなく学校全体の比率)</p>
					</div>
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<?php echo $answer_1 ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<hr>
					</div>
				</div>
 -->
				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<p class="title">投稿写真</p>
					</div>
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<?php
						foreach ($file_list as $photo_name) {
							echo $photo_name."<br />";
						}
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<hr>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<p class="title">イングリッシュペディアは2回目以降のご利用の方に授業料金の5%を割引（リピート割引）させて頂いているのをご存知ですか？</p>
					</div>
					<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
						<?php echo $repeat_discount_know ?>
					</div>
				</div>



			<form name="form_conf" id="form_conf" method="post" action="review_result">
				<div id="regist_conf_buttons">
					<input type="button" src="../images/return.png" alt="戻る" value="" onClick="history.go(-1)" id="btn_regist_return"/>
					<input type="submit" src="../images/send.png" alt="送信" name="btn02" value="" id="btn_review_send"/>
				</div>

				<div class="clear"></div>

				<input type="hidden" name="display_name" value="<?php echo $display_name ?>" />
				<input type="hidden" name="security_evaluation" value="<?php echo $security_evaluation ?>" />
				<input type="hidden" name="traffic_evaluation" value="<?php echo $traffic_evaluation ?>" />
				<input type="hidden" name="clean_evaluation" value="<?php echo $clean_evaluation ?>" />
				<input type="hidden" name="staff_evaluation" value="<?php echo $staff_evaluation ?>" />
				<input type="hidden" name="lesson_evaluation" value="<?php echo $lesson_evaluation ?>" />
				<input type="hidden" name="student_evaluation" value="<?php echo $student_evaluation ?>" />
				<input type="hidden" name="answer_1" value="<?php echo $answer_1 ?>" />
				<input type="hidden" name="answer_2" value="<?php echo $answer_2 ?>" />
				<input type="hidden" name="answer_3" value="<?php echo $answer_3 ?>" />
				<input type="hidden" name="answer_4" value="<?php echo $answer_4 ?>" />
				<input type="hidden" name="security_evaluation" value="<?php echo $security_evaluation ?>" />
				<input type="hidden" name="voice_text" value="<?php echo $voice_text ?>" />
				<input type="hidden" name="satisfaction_evaluation" value="<?php echo $satisfaction_evaluation ?>" />
				<input type="hidden" name="repeat_discount_know" value="<?php echo $repeat_discount_know ?>" />

				<?php
				foreach ($new_name_list as $photo_new_name) {
					echo '<input type="hidden" name="file_name[]" value='."$photo_new_name".' />';
				}
				?>

				<input type="hidden" name="ID" value="<?php echo $ID ?>" />
				<input type="hidden" name="post_id" value="<?php echo $post_id ?>" />
			</form>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->
<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
