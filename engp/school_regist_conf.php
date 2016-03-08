<?php
/*
 Template Name: 学校新規登録申請_確認
*/

$staff_name					= $_POST["staff_name"];
$staff_email				= $_POST["staff_email"];

$school_name				= $_POST["school_name"];
$school_jp_name				= $_POST["school_jp_name"];
$school_address				= $_POST["school_address"];
$school_tel					= $_POST["school_tel"];
$school_city				= $_POST["school_city"];
$school_division			= $_POST["school_division"];
$school_about				= $_POST["school_about"];
$display_school_about 		= nl2br($school_about);
$school_hp					= $_POST["school_hp"];
$school_youtube				= $_POST["school_youtube"];

$currency					= $_POST["currency"];
$school_fee_admission		= $_POST["school_fee_admission"];
$school_fee_accommodation	= $_POST["school_fee_accommodation"];
$school_fee_I20				= $_POST["school_fee_I20"];
$school_fee_airport			= $_POST["school_fee_airport"];
$school_fee_bankcharge		= $_POST["school_fee_bankcharge"];

$school_tuition4w_part		= $_POST["school_tuition4w_part"];
$school_tuition4w_full		= $_POST["school_tuition4w_full"];
$school_tuition4w_stay		= $_POST["school_tuition4w_stay"];
$school_tuition4w_text		= $_POST["school_tuition4w_text"];

get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/apply-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="apply_entry_title">送信内容のご確認</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="apply_main">
		<div class ="apply_content_box">
			<table id="table_apply_conf" cellspacing="0" cellpadding="1" class="table">
				<div id="apply_conf_line">
				以下の内容をご確認のうえ、よろしければ「送信する」をクリックしてください。<br>
				内容を変更される場合は「戻る」ボタンをクリックして入力フォームへお戻りください。
				</div>
				<tr>
					<th class="pause">【 ご担当者様情報 】</th>
				</tr>				
				
				<tr>
					<th style="border:none;">■ご担当者様名</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $staff_name ?></th>
				</tr>
				<tr>
					<th>■ご担当者様のメールアドレス</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $staff_email ?></th>
				</tr>
				<tr>
					<th class="pause">【 学校情報 】</th>
				</tr>				
				<tr>
					<th>■学校名(英名)</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $school_name ?></th>
				</tr>
				<tr>
					<th>■学校名(和名)</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $school_jp_name ?></th>
				</tr>
				<tr>
					<th>■住所</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $school_address ?></th>
				</tr>
				<tr>
					<th>■電話番号</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $school_tel ?></th>
				</tr>
				<tr>
					<th>■都市</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $school_city ?></th>
				</tr>
				<tr>
					<th>■エリア</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $school_division ?></th>
				</tr>
				<tr>
					<th>■概要(学校紹介文)</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $display_school_about ?></th>
				</tr>
				<tr>
					<th>■学校のHPアドレス</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $school_hp ?></th>
				</tr>
				<tr>
					<th>■学校紹介動画(YouTubeアドレス)</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $school_youtube ?></th>
				</tr>
				<tr>
					<th class="pause">【 料金情報(任意) 】</th>
				</tr>				
				<tr>
					<th>■入学金</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $currency ?><?php echo $school_fee_admission ?></th>
				</tr>
				<tr>
					<th>■滞在先手配料</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $currency ?><?php echo $school_fee_accommodation ?></th>
				</tr>
				<tr>
					<th>■I20発行・送料</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $currency ?><?php echo $school_fee_I20 ?></th>
				</tr>
				<tr>
					<th>■空港出迎え費</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $currency ?><?php echo $school_fee_airport ?></th>
				</tr>
				<tr>
					<th>■バンクチャージ</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $currency ?><?php echo $school_fee_bankcharge ?></th>
				</tr>				
				
				<tr>
					<th class="pause2">【 4週間の学費(任意) 】</th>
				</tr>
				<tr>
					<th>■授業料（パートタイム）</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $currency ?><?php echo $school_tuition4w_part ?></th>
				</tr>				
				<tr>
					<th>■授業料（フルタイム）</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $currency ?><?php echo $school_tuition4w_full ?></th>
				</tr>				
				<tr>
					<th>■滞在費</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $currency ?><?php echo $school_tuition4w_stay ?></th>
				</tr>				
				<tr>
					<th>■テキスト代</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $currency ?><?php echo $school_tuition4w_text ?></th>
				</tr>				
				
				
			</table>
			<form name="form_conf" id="form_conf" method="post" action="<?php echo home_url(); ?>/school_regist_result">
				<div id="apply_conf_buttons">
					<input type="button" src="../images/return.png" alt="戻る" value="" onClick="history.go(-1)" id="btn_apply_return"/>
					<input type="submit" src="../images/send.png" alt="送信" name="btn02" value="" id="btn_apply_send"/>
				</div>
				<div class="clear"></div>
				<input type="hidden" name="staff_name" value="<?php echo $staff_name ?>" />
				<input type="hidden" name="staff_email" value="<?php echo $staff_email ?>" />
				
				<input type="hidden" name="school_name" value="<?php echo $school_name ?>" />
				<input type="hidden" name="school_jp_name" value="<?php echo $school_jp_name ?>" />
				<input type="hidden" name="school_address" value="<?php echo $school_address ?>" />
				<input type="hidden" name="school_tel" value="<?php echo $school_tel ?>" />
				<input type="hidden" name="school_city" value="<?php echo $school_city ?>" />
				<input type="hidden" name="school_division" value="<?php echo $school_division ?>" />				
				<input type="hidden" name="school_about" value="<?php echo $school_about ?>" />
				<input type="hidden" name="school_hp" value="<?php echo $school_hp ?>" />
				<input type="hidden" name="school_youtube" value="<?php echo $school_youtube ?>" />
				
				<input type="hidden" name="currency" value="<?php echo $currency ?>" />				
				<input type="hidden" name="school_fee_admission" value="<?php echo $school_fee_admission ?>" />
				<input type="hidden" name="school_fee_accommodation" value="<?php echo $school_fee_accommodation ?>" />
				<input type="hidden" name="school_fee_I20" value="<?php echo $school_fee_I20 ?>" />
				<input type="hidden" name="school_fee_airport" value="<?php echo $school_fee_airport ?>" />				
				<input type="hidden" name="school_fee_bankcharge" value="<?php echo $school_fee_bankcharge ?>" />
				
				<input type="hidden" name="school_tuition4w_part" value="<?php echo $school_tuition4w_part ?>" />
				<input type="hidden" name="school_tuition4w_full" value="<?php echo $school_tuition4w_full ?>" />
				<input type="hidden" name="school_tuition4w_stay" value="<?php echo $school_tuition4w_stay ?>" />
				<input type="hidden" name="school_tuition4w_text" value="<?php echo $school_tuition4w_text ?>" />				
			</form>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->

<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
