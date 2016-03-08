<?php
/*
 Template Name: ゲストレビュー投稿
*/
$post_id = 0;
$school_data = engp_get_school($post_id);
$engp_master = engp_get_master();
$division_list = $engp_master['division'];
get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>" />

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">
	レビューを投稿する
</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="regist_main">
		<p class="regist_line">レビュー投稿フォームです。</p>
		<div class="regist_content_box3">
			<form class="form-horizontal" name="review_form" method="post" action="<?php echo esc_url(home_url());?>/review_conf" enctype="multipart/form-data" onsubmit="return guest_review_val_check();">
				<div class="regist_form">
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p>以下の必要事項を入力してください。（<span class="regist_chk_notes">*</span>は必須項目です）</p>
						</div>
					</div>

					<div class="form-group mgnB0">
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="regist_head">
									<label for="display_name"><span class="regist_chk_notes">*</span>お名前</label>
								</p>
							</div>
						</div>
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<input name="display_name" class="form-control" size="40" type="text">
							</div>
						</div>
					</div>

					<div class="form-group mgnB0">
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="regist_head">
									<label for="postID"><span class="regist_chk_notes">*</span>レビューをする学校</label>
								</p>
							</div>
						</div>
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<select name="postID" class="form-control" id="postID" style="width:100%;">							
									<option value="">▼ 学校名</option>
									<?php 
									$division_id = null; 
									foreach ($school_data as $data) : 
										  if($division_id != $data->division){
											$division_id = $data->division;
											$division_name = $division_list[$division_id];
											$html .= "<optgroup label=".$division_name.">";
											$html .= "<option value=".$data->post_id.">".$data->school_name."(".$data->school_jp_name.")</option>";

										  }else{
											$html .= "<option value=".$data->post_id.">".$data->school_name."(".$data->school_jp_name.")</option>";
										}
									endforeach;
									echo $html;															
									?>
								</select>
							</div>
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
								現在通われている学校への入学を決めた決め手はなんですか？<br>またその満足度を教えて下さい
							</p>
						</div>
					</div>
					
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="review_head">
								<label for="review_text"><span class="regist_chk_notes">*</span>入学の決め手</label>
<!-- 								<div id="idStrlength">あと500文字</div> -->
							</p>
						</div>
					</div>
										
					<div class="row mgnB16">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<textarea name="review_text" class="form-control" rows="10" onkeyup="strlength(value)"></textarea>
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
