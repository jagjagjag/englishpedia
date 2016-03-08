<?php
/*
Template Name: 学校新規登録申請
*/
$engp_master = engp_get_master();
get_header('nologin');
?>

<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/textcheck.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/apply-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="apply_entry_title">掲載学校追加のお問い合わせ</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="apply_main">
		<p class="apply_line">EnglishPediaに自分の学校も追加して欲しい！という学校関係者様向けのお問い合わせフォームです。<br>下記項目をご記入の上、「送信内容の確認」ボタンを押して下さい。<br>お問い合せ後、EnglishPediaサポートセンターよりご連絡をさせて頂きます。</p>
		<div class ="apply_content_box">
			<form class="form-horizontal" name="schoolregist_form" method="post" action="<?php echo esc_url(home_url());?>/school_regist_conf" enctype="multipart/form-data" onsubmit="return schoolregist_val_check();">
				<div class="apply_form">
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p>以下の必要事項を入力してください。（<span class="apply_chk_notes">*</span>は必須項目です）</p>
							<h2 class="apply_box">ご担当者様情報</h2>
						</div>
					</div>
					
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<span class="apply_head"><label for="staff_name"><span class="apply_chk_notes">*</span>ご担当者様名</label></span>
						</div>
					</div>

					<div class="form-group row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">					
							<input name="staff_name" class="form-control" type="text" value=""/>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<span class="apply_head"><label for="staff_email"><span class="apply_chk_notes">*</span>ご担当者様のメールアドレス</label></span>
						</div>
					</div>

					<div class="form-group row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">					
							<input name="staff_email" class="form-control" type="text" value=""/>
						</div>
					</div>

					<div class=" row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<h2 class="apply_box">学校情報</h2>
							</div>
					</div>
					
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<span class="apply_head"><label for="school_name"><span class="apply_chk_notes">*</span>学校名(英名)</label></span>
						</div>
					</div>
						
					<div class="form-group row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">					
							<input name="school_name" class="form-control" type="text" value=""/>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<span class="apply_head"><label for="school_jp_name">学校名(和名)</label></span>
						</div>
					</div>
					<div class="form-group row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<input name="school_jp_name" class="form-control" type="text" value=""/>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">					
							<span class="apply_head"><label for="school_address"><span class="apply_chk_notes">*</span>住所</label></span>
						</div>
					</div>
					<div class="form-group row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">					
							<input name="school_address" class="form-control" type="text" value=""/>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<span class="apply_head"><label for="school_tel">電話番号</label></span>
						</div>
					</div>

					<div class="form-group row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">										
							<input name="school_tel" class="form-control" type="text" value=""/>	
						</div>
					</div>
					
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<span class="apply_head"><label for="電話番号">都市</label></span>
						</div>
					</div>
					<div class="form-group row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">			
							<input name="school_city" class="form-control" type="text" value=""/>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<span class="apply_head"><label for="school_division"><span class="apply_chk_notes">*</span>エリア</label></span>
						</div>
					</div>
					<div class="form-group row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">			
							<select class="form-control" name="school_division" id="school_division">
								<option value=""></option>
<?php
	foreach ($engp_master['division'] as $key => &$val) {
			echo "<option value='".$val."'>".$val."</option>".PHP_EOL;
	}
?>
							</select>
						</div>
					</div>

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<span class="apply_head"><label for="school_about"><span class="apply_chk_notes">*</span>概要(学校紹介文)</label></span>
						</div>
					</div>
					<div class=" row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<textarea name="school_about" class="form-control" rows="10"></textarea>
						</div>
					</div>
		
					<div class=" row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<span class="apply_head"><label for="school_hp">学校のHPアドレス</label></span>
						</div>
					</div>
					
					<div class="form-group row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">							
							<input name="school_hp" class="form-control" type="text" value=""/>
						</div>
					</div>
					
					<div class=" row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<span class="apply_head"><label for="school_youtube">学校紹介動画(YouTubeアドレス)</label></span>
						</div>
					</div>
					
					<div class="form-group row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">							
							<input name="school_youtube" class="form-control" type="text" value=""/>
						</div>
					</div>

					<div class=" row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<h2 class="apply_box">料金情報(任意)</h2>
							</div>
					</div>
					
					<div class=" row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">			
								<span class="apply_head"><label for="currency">料金情報の通貨</label></span>
							</div>
					</div>
					
					<div class="form-group row">
						<div class="col-md-offset-2 col-md-10 col-ms-12 col-xs-12">
							<input id="yen" name="currency" type="radio" value="$" />ドル表記<br />
							<input id="doller" name="currency" type="radio" value="¥" />円表記<br />
						</div>
					</div>					

					<div class=" row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">			
								<span class="apply_head"><label for="school_fee_admission">入学金</label></span>
							</div>
					</div>

					<div class="form-group row mgnB8">
						<div class="form-inline ">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">					
								<input name="school_fee_admission" class="form-control" type="text" value=""/>
							</div>
						</div>
					</div>
					<div class=" row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">			
							<span class="apply_head"><label for="school_fee_accommodation">滞在先手配料</label></span>
						</div>
					</div>					
					<div class="form-group row mgnB8">
						<div class="form-inline ">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<input name="school_fee_accommodation" class="form-control" type="text" value=""/>
							</div>
						</div>
					</div>

					<div class=" row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">						
							<span class="apply_head"><label for="school_fee_I20">I20発行・送料</label></span>
						</div>
					</div>
					<div class="form-group row mgnB8">
						<div class="form-inline ">					
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<input name="school_fee_I20" class="form-control" type="text" value=""/>
							</div>
						</div>
					</div>

						<div class=" row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<span class="apply_head"><label for="school_fee_airport">空港出迎え費</label></span>
							</div>
						</div>
						<div class="form-group row mgnB8">
							<div class="form-inline ">											
								<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">											
									<input name="school_fee_airport" class="form-control" type="text" value=""/>
								</div>
							</div>
						</div>

						<div class=" row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<span class="apply_head"><label for="school_fee_bankcharge">バンクチャージ</label></span>
							</div>
						</div>
						<div class="form-group row mgnB8">
							<div class="form-inline ">
								<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
									<input name="school_fee_bankcharge" class="form-control" type="text" value=""/>
								</div>
							</div>
						</div>

						<!-- Start:4Week -->
						<div class=" row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<h2 class="school_regist_box">4週間の学費(任意)</h2>
							</div>
						</div>
						<div class=" row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<span class="apply_head"><label for="school_tuition4w_part">授業料（パートタイム）</label></span>
							</div>
						</div>
						<div class="form-group row mgnB8">
							<div class="form-inline ">											
								<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">											
									<input name="school_tuition4w_part" class="form-control" type="text" value=""/>
								</div>
							</div>
						</div>

						<div class=" row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<span class="apply_head"><label for="school_tuition4w_full">授業料（フルタイム）</label></span>
							</div>
						</div>
						<div class="form-group row mgnB8">
							<div class="form-inline ">											
								<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
									<input name="school_tuition4w_full" class="form-control" type="text" value=""/>
								</div>
							</div>
						</div>

						<div class=" row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<span class="apply_head"><label for="school_tuition4w_stay">滞在費</label></span>
							</div>
						</div>
						<div class="form-group row mgnB8">
							<div class="form-inline ">											
								<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
									<input name="school_tuition4w_stay" class="form-control" type="text" value=""/>
								</div>
							</div>
						</div>

						<div class=" row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<span class="apply_head"><label for="school_tuition4w_text">テキスト代</label></span>
							</div>
						</div>
						<div class="form-group row mgnB8">
							<div class="form-inline ">											
								<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
									<input name="school_tuition4w_text" class="form-control" type="text" value=""/>
								</div>
							</div>
						</div>
						<!-- End:4week -->
					
					<div id="apply_confirm">
						<input type="submit" value="" alt="入力内容の確認" id="btn_apply_confirm">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->
<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
