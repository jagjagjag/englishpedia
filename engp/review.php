<?php
/*
 Template Name: レビュー投稿
*/
$ID = engp_get_id($_COOKIE['gu_id']);
$user_data = engp_get_user($ID);
$post_id = $_GET['revid'];
$school_data = engp_get_school($post_id);

get_header();
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
		<p class="regist_line">レビュー投稿フォームです。<br />あなたの留学体験をお聞かせ下さい。</p>
		<div class="regist_content_box3">
			<form class="form-horizontal" name="review_form" method="post" action="<?php echo esc_url(home_url());?>/review_conf" enctype="multipart/form-data" onsubmit="return review_val_check();">

				<div class="regist_form">
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p>以下の必要事項を入力してください。（<span class="regist_chk_notes">*</span>は必須項目です）</p>
						</div>
					</div>
					<div class="form-group row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
<?php  if(empty($ID)): ?>
							<p class="review_head">
								<label for="display_name"><span class="regist_chk_notes">*</span>お名前</label>
							</p>
							<input name="display_name" class="form-control" size="40" type="text">
<?php  else: ?>
							<p class="review_head">
								<label for="display_name">お名前</label>
							</p>
							<p><?php echo ($user_data->display_name)?></p>
							<input type="hidden" name="display_name" value="<?php echo ($user_data->display_name);?>" />
<?php endif; ?>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
					    	<hr style="margin-top:15px;margin-bottom:15px;">
					  </div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="review_head">
								<label for="school_name"><span class="regist_chk_notes"></span>レビューをする学校</label>
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
					    	<hr style="margin-top:15px;margin-bottom:15px;">
					  </div>
					</div>


					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="review_head2">
								現在通われている学校の特徴などを教えて下さい
							</p>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="review_head">
								<label for="voice_text"><span class="regist_chk_notes">*</span>ご利用者様の声</label>
<!-- 								<div id="idStrlength">あと500文字</div> -->
							</p>
						</div>
					</div>
					<div class="row mgnB16">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<textarea name="voice_text" class="form-control" rows="6" onkeyup="strlength(value)" placeholder="例&#13;&#10;・サイモンの授業が良かった&#13;&#10;・ホームステイが最高だった！&#13;&#10;・日本人が多かった&#13;&#10;・他の学校と比較すると安い"></textarea>
						</div>
					</div>

					<div class="row mgnB16">
							<label for="satisfaction_evaluation" class="review_head col-md-offset-2 col-md-4"><span class="regist_chk_notes">*</span>満足度</label>
							<div class="col-md-4">
								<select name="satisfaction_evaluation" class="form-control" id="satisfaction_evaluation" style="width:100%;">
									<option value="">▼ 選択して下さい</option>
									<option value="★★★★★">★★★★★</option>
									<option value="★★★★☆">★★★★☆</option>
									<option value="★★★☆☆">★★★☆☆</option>
									<option value="★★☆☆☆">★★☆☆☆</option>
									<option value="★☆☆☆☆">★☆☆☆☆</option>
								</select>
							</div>
					</div>

					<div class="row mgnB16">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
					    	<hr style="margin-top:15px;margin-bottom:15px;">
					  </div>
					</div>


					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="review_head2">
								お通いになられている語学学校についてご意見をお聞かせ下さい
							</p>
						</div>
					</div>

					<div class="row mgnB16">
							<label for="security_evaluation" class="review_head col-md-offset-2 col-md-4" style="font-weight:400;"><span class="regist_chk_notes">*</span>学校周辺の治安</label>
							<div class="col-md-4">
								<select name="security_evaluation" class="form-control" id="security_evaluation" style="width:100%;">
									<option value="">▼ 選択して下さい</option>
									<option value="5:良かった">5:良かった</option>
									<option value="4:まあまあ">4:まあまあ</option>
									<option value="3:普通">3:普通</option>
									<option value="2:あまり良くなかった">2:あまり良くなかった</option>
									<option value="1:悪かった">1:悪かった</option>
								</select>
							</div>
					</div>

					<div class="row mgnB16">
							<label for="traffic_evaluation" class="review_head col-md-offset-2 col-md-4" style="font-weight:400;"><span class="regist_chk_notes">*</span>交通の便</label>
							<div class="col-md-4">
								<select name="traffic_evaluation" class="form-control" id="traffic_evaluation" style="width:100%;">
									<option value="">▼ 選択して下さい</option>
									<option value="5:良かった">5:良かった</option>
									<option value="4:まあまあ">4:まあまあ</option>
									<option value="3:普通">3:普通</option>
									<option value="2:あまり良くなかった">2:あまり良くなかった</option>
									<option value="1:悪かった">1:悪かった</option>
								</select>
							</div>
					</div>

					<div class="row mgnB16">
							<label for="clean_evaluation" class="review_head col-md-offset-2 col-md-4" style="font-weight:400;"><span class="regist_chk_notes">*</span>衛生面(綺麗さ)</label>
							<div class="col-md-4">
								<select name="clean_evaluation" class="form-control" id="clean_evaluation" style="width:100%;">
									<option value="">▼ 選択して下さい</option>
									<option value="5:良かった">5:良かった</option>
									<option value="4:まあまあ">4:まあまあ</option>
									<option value="3:普通">3:普通</option>
									<option value="2:あまり良くなかった">2:あまり良くなかった</option>
									<option value="1:悪かった">1:悪かった</option>
								</select>
							</div>
					</div>

					<div class="row mgnB16">
							<label for="staff_evaluation" class="review_head col-md-offset-2 col-md-4" style="font-weight:400;"><span class="regist_chk_notes">*</span>学校スタッフの対応</label>
							<div class="col-md-4">
								<select name="staff_evaluation" class="form-control" id="staff_evaluation" style="width:100%;">
									<option value="">▼ 選択して下さい</option>
									<option value="5:良かった">5:良かった</option>
									<option value="4:まあまあ">4:まあまあ</option>
									<option value="3:普通">3:普通</option>
									<option value="2:あまり良くなかった">2:あまり良くなかった</option>
									<option value="1:悪かった">1:悪かった</option>
								</select>
							</div>
					</div>

					<div class="row mgnB16">
							<label for="lesson_evaluation" class="review_head col-md-offset-2 col-md-4" style="font-weight:400;"><span class="regist_chk_notes">*</span>授業内容</label>
							<div class="col-md-4">
								<select name="lesson_evaluation" class="form-control" id="lesson_evaluation" style="width:100%;">
									<option value="">▼ 選択して下さい</option>
									<option value="5:良かった">5:良かった</option>
									<option value="4:まあまあ">4:まあまあ</option>
									<option value="3:普通">3:普通</option>
									<option value="2:あまり良くなかった">2:あまり良くなかった</option>
									<option value="1:悪かった">1:悪かった</option>
								</select>
							</div>
					</div>

					<div class="row mgnB16">
							<label for="student_evaluation" class="review_head col-md-offset-2 col-md-4" style="font-weight:400;"><span class="regist_chk_notes">*</span>周りの学生の真剣さ</label>
							<div class="col-md-4">
								<select name="student_evaluation" class="form-control" id="student_evaluation" style="width:100%;">
									<option value="">▼ 選択して下さい</option>
									<option value="5:良かった">5:良かった</option>
									<option value="4:まあまあ">4:まあまあ</option>
									<option value="3:普通">3:普通</option>
									<option value="2:あまり良くなかった">2:あまり良くなかった</option>
									<option value="1:悪かった">1:悪かった</option>
								</select>
							</div>
					</div>
<!--
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="review_head">
								<label for="answer_2"><span class="regist_chk_notes">*</span>あなたの学校で気に入ってる先生やクラスを教えて下さい</label>
							</p>
						</div>
					</div>
					<div class="row mgnB16">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<textarea name="answer_2" class="form-control" rows="5" placeholder="例：「ラリーの授業が面白い！」「Speakingの授業が90分と充実してて良い」など"></textarea>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="review_head">
								<label for="answer_3">その他、あなたの学校で気に入ってる点について教えてください</label>
							</p>
						</div>
					</div>
					<div class="row mgnB16">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<textarea name="answer_3" class="form-control" rows="5" placeholder="例：「アクティビティーが多い」など"></textarea>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="review_head">
								<label for="answer_4">その他、あなたの通っている学校について気に入らない点について教えて下さい</label>
							</p>
						</div>
					</div>
					<div class="row mgnB16">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<textarea name="answer_4" class="form-control" rows="5" placeholder="例：「日本人が多すぎる」「クラス数が少なすぎる」など"></textarea>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="review_head">
								<label for="answer_1">あなたの学校の大体の国籍比率を教えて下さい<br>(クラスではなく学校全体の比率)</label>
							</p>
						</div>
					</div>
					<div class="row mgnB16">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<textarea name="answer_1" class="form-control" rows="5" placeholder="例：日本人30%、韓国人20%、スイス20%、その他30%"></textarea>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
					    	<hr style="margin-top:15px;margin-bottom:15px;">
					  </div>
					</div>
-->
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="review_head2">
								学校内や周辺環境の雰囲気が分かる写真を掲載させて頂けると幸いです。<br>(※最大3ファイル,合計容量4MBまで)
							</p>
						</div>
					</div>

					<div class="row mgnB16">
							<label for="security_evaluation" class="review_head col-md-offset-2 col-md-4" style="font-weight:400;">投稿写真ファイルを選択</label>
							<div class="col-md-4">
								<input type="file" id="files" name="files[]" accept="image/*" multiple>
							</div>
					</div>
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12 mgnB8">
							<p class="review_head2">
								イングリッシュペディアは2回目以降のご利用の方に授業料金の5%を割引（リピート割引）させて頂いているのをご存知ですか？
							</p>
						</div>
							<div class="col-md-offset-2 col-md-8">
									<label class="padR16">
										<input type="radio" name="repeat_discount_know" id="satisfaction_evaluation1" value="知ってはいた">
										知ってはいた
									</label>
									<label>
										<input type="radio" name="repeat_discount_know" id="satisfaction_evaluation2" value="知らなかった" checked>
										知らなかった
									</label>
							</div>

					</div>


				</div>

				<input type="hidden" name="ID" value="<?php echo ($user_data->user_id);?>" />
				<input type="hidden" name="postID" value="<?php echo ($post_id);?>" />
				<input type="hidden" name="school_name" value="<?php echo $school_data ->school_name?>" />
				<input type="hidden" name="school_jp_name" value="<?php echo $school_data ->school_jp_name?>" />

				<div id="regist_confirm">
					<input type="submit" value="" alt="入力内容の確認" id="btn_regist_confirm">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- End:コンテンツ -->
<?php get_footer(); ?>
<script type="text/javascript">
	function strlength(str) {
		document.getElementById("idStrlength").innerHTML = "あと" + (500-str.length) + "文字";
		if(str.length > 500){
			document.getElementById("idStrlength").innerHTML = "入力可能文字数を" + (str.length-500) + "文字オーバーしています";
		}
	}
</script>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/textcheck.js" type="text/javascript"></script>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
