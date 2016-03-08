<?php
/*
 Template Name: お問い合わせ
*/
get_header('nologin');
$engp_master = engp_get_master();
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>" />

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">
	お問い合わせ
</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="regist_main">
		<p class="regist_line">下記項目をご入力の上、「送信内容の確認」ボタンを押して下さい。</p>
		<div class="regist_content_box">
			<form class="form-horizontal" name="inquiry_form" method="post" action="<?php echo esc_url(home_url());?>/inquiry_conf" enctype="multipart/form-data" onsubmit="return inquiry_val_check(0);">
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
							<input id="phone" class="form-control" maxlength="11" name="phone" size="20" type="text" placeholder="ハイフン抜きで入力して下さい"/>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="inquiry_head">
								<label for="image">希望都市イメージ</label>
							</p>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-offset-2 col-md-8">
							<select id="image" name="image" class="form-control" title="希望留学目的" style="width:100%;">
								<option value="まだ決まっていない">まだ決まっていない</option>
								<?php foreach ($engp_master['division'] as $key => &$val):?>
									<option value="<?php echo $val;?>"><?php echo $val;?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="inquiry_head">
								<label for="period">渡航時期</label>
							</p>
						</div>
					</div>
					<div class="form-group row mgnB15">
						<div class="col-md-offset-2 col-md-8">
							<select id="period" name="period" class="form-control" title="渡航時期" style="width:100%;">
								<option value="まだ決まっていない">まだ決まっていない</option>
								<option value="1ヶ月以内">1ヶ月以内</option>								
								<option value="3ヶ月以内">3ヶ月以内</option>								
								<option value="6ヶ月以内">6ヶ月以内</option>								
								<option value="1年以内">1年以内</option>								
								<option value="来年以降">来年以降</option>																																								
							</select>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="inquiry_head">
								<label for="consultation"><span class="regist_chk_notes">*</span>相談したい内容</label>
							</p>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-offset-2 col-md-8">
							<textarea id="consultation"  class="form-control" name="consultation" rows="10" wrap="soft"></textarea>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="inquiry_head">
								<label for="trigger">何をみてお知りになりましたか？(複数回答あり)</label>
							</p>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-offset-2 col-md-10 col-ms-12 col-xs-12">
							<input id="fb" name="fb" type="checkbox" value="「留学」Facebookページ" /> 「留学」Facebookページ<br />
							<input id="yahoo" name="yahoo" type="checkbox" value="Yahoo検索" /> Yahoo検索<br />
							<input id="google" name="google" type="checkbox" value="Google検索" /> Google検索<br />
							<input id="twitter" name="twitter" type="checkbox" value="Twitter" /> Twitter<br />
							<input id="friend" name="friend" type="checkbox" value="友人の紹介" /> 友人の紹介<br />
							<input id="other" name="other" type="checkbox" value="その他" /> その他<br />
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
