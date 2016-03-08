<?php
/*
 Template Name: カウンセリングのお申込み
*/
get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>" />

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">
	カウンセリングのお申し込み
</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="regist_main">
		<p class="regist_line">下記項目をご入力の上、「送信内容の確認」ボタンを押して下さい。</p>
		<div class="regist_content_box">
			<form class="form-horizontal" name="inquiry_form" method="post" action="<?php echo esc_url(home_url());?>/counseling_conf" enctype="multipart/form-data" onsubmit="return counseling_val_check();">
				<div class="inquiry_form">
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p>以下の必要事項を入力してください。（<span class="regist_chk_notes">*</span>は必須項目です）</p>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="inquiry_head">
								<label for="last_name"><span class="regist_chk_notes">*</span>名前</label>
							</p>
						</div>
					</div>
					<div class="form-group form-inline row">
						<div class="col-md-offset-2 col-md-4 col-xs-6 col-sm-6">
							<input id="last_name" class="form-control" maxlength="80" style="width:100%;" name="last_name" placeholder="姓" type="text"/>
						</div>
						<div class="col-md-4 col-xs-6 col-sm-6">
							<input id="first_name" class="form-control" maxlength="40" style="width:100%;" name="first_name" placeholder="名" type="text" />
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="inquiry_head">
								<label for="prefectures">都道府県</label>
							</p>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-offset-2 col-md-8">
							<select id="prefectures" name="prefectures" class="form-control" title="都道府県">
								<option value="">--なし--</option>
								<option value="北海道">北海道</option>
								<option value="青森県">青森県</option>
								<option value="岩手県">岩手県</option>
								<option value="宮城県">宮城県</option>
								<option value="秋田県">秋田県</option>
								<option value="山形県">山形県</option>
								<option value="福島県">福島県</option>
								<option value="茨城県">茨城県</option>
								<option value="栃木県">栃木県</option>
								<option value="群馬県">群馬県</option>
								<option value="埼玉県">埼玉県</option>
								<option value="千葉県">千葉県</option>
								<option value="東京都">東京都</option>
								<option value="神奈川県">神奈川県</option>
								<option value="新潟県">新潟県</option>
								<option value="富山県">富山県</option>
								<option value="石川県">石川県</option>
								<option value="福井県">福井県</option>
								<option value="山梨県">山梨県</option>
								<option value="長野県">長野県</option>
								<option value="岐阜県">岐阜県</option>
								<option value="静岡県">静岡県</option>
								<option value="愛知県">愛知県</option>
								<option value="三重県">三重県</option>
								<option value="滋賀県">滋賀県</option>
								<option value="京都府">京都府</option>
								<option value="大阪府">大阪府</option>
								<option value="兵庫県">兵庫県</option>
								<option value="奈良県">奈良県</option>
								<option value="和歌山県">和歌山県</option>
								<option value="鳥取県">鳥取県</option>
								<option value="島根県">島根県</option>
								<option value="岡山県">岡山県</option>
								<option value="広島県">広島県</option>
								<option value="山口県">山口県</option>
								<option value="徳島県">徳島県</option>
								<option value="香川県">香川県</option>
								<option value="愛媛県">愛媛県</option>
								<option value="高知県">高知県</option>
								<option value="福岡県">福岡県</option>
								<option value="佐賀県">佐賀県</option>
								<option value="長崎県">長崎県</option>
								<option value="熊本県">熊本県</option>
								<option value="大分県">大分県</option>
								<option value="宮崎県">宮崎県</option>
								<option value="鹿児島県">鹿児島県</option>
								<option value="沖縄県">沖縄県</option>
							</select>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="inquiry_head">
								<label for="email"><span class="regist_chk_notes">*</span>Eメールアドレス</label>
							</p>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-offset-2 col-md-8">
							<input id="email" class="form-control" maxlength="80" name="email" size="20" type="text" />
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="inquiry_head">
								<label for="phone"><span class="regist_chk_notes">*</span>携帯電話番号</label>
							</p>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-offset-2 col-md-8">
							<input id="phone" class="form-control" maxlength="40" name="phone" size="20" type="text" />
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="inquiry_head">
								<label for="image">希望都市</label>
							</p>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-offset-2 col-md-8">
							<select id="image" name="image" class="form-control" title="希望留学目的" style="width:100%;">
								<option value="">--なし--</option>
								<option value="ロサンゼルス">ロサンゼルス</option>
								<option value="ニューヨーク">ニューヨーク</option>
								<option value="サンフランシスコ">サンフランシスコ</option>
								<option value="ハワイ">ハワイ</option>
								<option value="その他の都市／まだ決まっていない">その他の都市／まだ決まっていない</option>
							</select>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="inquiry_head">
								<label for="consultation">聞きたい内容</label>
							</p>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-offset-2 col-md-8">
							<textarea id="consultation"  class="form-control" name="consultation" rows="10" wrap="soft" placeholder="例&#13;&#10;・日本人が少ない学校を教えて欲しい&#13;&#10;・ビザの取り方を知りたい&#13;&#10;"></textarea>
						</div>
					</div>


					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="inquiry_head">
								<label for="travel_plan">留学予定時期</label>
							</p>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<select id="travel_plan" name="travel_plan" class="form-control" title="渡航予定期間" style="width:100%;">
								<option value="">--なし--</option>													
								<option value="半年以内">半年以内</option>
								<option value="1年以内">1年以内</option>
								<option value="1年以上先">1年以上先</option>
							</select>							
						</div>
					</div>
					
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-6 col-xs-12 col-sm-12">
							<p class="inquiry_head">
								<label for="preferred_date">カウンセリング希望日時</label>
							</p>
						</div>
					</div>
					<div class="form-group row">					
						<div class="col-md-offset-2 col-md-4 col-xs-12 col-sm-12">
							<input id="datepicker" name="preferred_date" class="form-control f_left mgnR8" style="width:180px;" name="preferred_date" placeholder="例:20140101" size="12" type="text" onBlur="dateFormat(this)"/>
						</div>
						<div class="col-md-2 col-xs-12 col-sm-12">
							<select id="preferred_time" name="preferred_time" class="form-control" title="希望時間" style="width:100%;">
								<option value="">--なし--</option>													
								<option value="10:00">10:00</option>
								<option value="10:30">10:30</option>
								<option value="11:00">11:00</option>
								<option value="11:30">11:30</option>
								<option value="12:00">12:00</option>
								<option value="12:30">12:30</option>
								<option value="13:00">13:00</option>
								<option value="13:30">13:30</option>
								<option value="14:00">14:00</option>
								<option value="14:30">14:30</option>
								<option value="15:00">15:00</option>
								<option value="15:30">15:30</option>
								<option value="16:00">16:00</option>
								<option value="16:30">16:30</option>
								<option value="17:00">17:00</option>
								<option value="17:30">17:30</option>
								<option value="18:00">18:00</option>
								<option value="18:30">18:30</option>
								<option value="19:00">19:00</option>
								<option value="19:30">19:30</option>
								<option value="20:00">20:00</option>								
							</select>														
						</div>
					</div>
										
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-6 col-xs-12 col-sm-12">
							<p class="inquiry_head">
								<label for="preferred_location">カウンセリング場所・方法</label>
							</p>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-offset-2 col-md-8">
							<select id="preferred_location" name="preferred_location" class="form-control" title="希望時間" style="width:100%;">
								<option value="">--なし--</option>
								<option value="新宿オフィス">新宿オフィス</option>																							
								<option value="大阪オフィス">大阪オフィス</option>
								<option value="電話でカウンセリング">電話でカウンセリング</option>
								<option value="スカイプでオンラインカウンセリング">スカイプでオンラインカウンセリング</option>
								<option value="LINEでカウンセリング">LINEでカウンセリング</option>
							</select>														
						</div>
					</div>
					
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
