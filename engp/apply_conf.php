<?php
/*
 Template Name: 留学申し込み_内容確認
 */

//希望学校
$postID		= $_POST["postID"];
$school_data = engp_get_school($postID);
$get_want_school	 = $school_data->school_name;
//希望学校和名
$get_want_school_jp	 = $school_data->school_jp_name;

//コース
$get_course = $_POST["course"];
//開始年月　年
$get_start_year = $_POST["start_year"];
//開始年月　月
$get_start_month = $_POST["start_month"];
//留学期間
$get_period = $_POST["period"];
//滞在先
$get_stay_type = $_POST["stay_type"];
//滞在先の手配期間
$get_arrange_period = $_POST["arrange_period"];
if($get_arrange_period == ""){
	$get_arrange_period = "手配を依頼しない";
}

//姓
$get_last_name = $_POST["last_name"];
//名
$get_first_name = $_POST["first_name"];
//セイ
$get_last_name_kana = $_POST["last_name_kana"];
//メイ
$get_first_name_kana = $_POST["first_name_kana"];
//電話 1
$get_tel = $_POST["tel"];
//メール
$get_email = $_POST["email"];
//郵便番号
$get_postal = $_POST["postal"];
//都道府県
$get_prefecture = $_POST["prefecture"];
//ご住所
$get_address = $_POST["address"];
//建物名
$get_build = $_POST["build"];

//レビュー投稿キャンペーン
$get_campaign = $_POST["campaign"];

if(!$get_campaign){
	$get_campaign = "参加しない";
}

$get_option1 = $_POST["option1"];
$get_option2 = $_POST["option2"];
$get_option3 = $_POST["option3"];
$get_option4 = $_POST["option4"];
$get_option5 = $_POST["option5"];

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
					<th>■希望学校</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $get_want_school ?><br />(<?php echo $get_want_school_jp ?>)</th>
				</tr>
				<tr>
					<th>■コース</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $get_course ?></th>
				</tr>
				
				<tr>
					<th>■開始年月</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $get_start_year.$get_start_month ?></th>
				</tr>
				<tr>
					<th>■留学期間</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $get_period ?></th>
				</tr>
				<tr>
					<th>■滞在先</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $get_stay_type ?></th>
				</tr>
				<tr>
					<th>■滞在先の手配期間</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $get_arrange_period; ?></th>
				</tr>
				
				<tr>
					<th>■お名前（漢字）</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo esc_html($get_last_name).esc_html($get_first_name) ?></th>
				</tr>
				<tr>
					<th>■お名前（かな）</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo esc_html($get_last_name_kana).esc_html($get_first_name_kana) ?></th>
				</tr>
				<tr>
					<th>■Eメールアドレス</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo esc_html($get_email) ?></th>
				</tr>
				<tr>
					<th>■電話番号</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo esc_html($get_tel) ?></th>
				</tr>
				<tr>
					<th>■郵便番号</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;">〒<?php echo esc_html($get_postal) ?></th>
				</tr>
				<tr>
					<th>■都道府県</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $get_prefecture ?></th>
				</tr>
				<tr>
					<th>■ご住所</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo esc_html($get_address) ?></th>
				</tr>
				<tr>
					<th>■建物名</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo esc_html($get_build) ?></th>
				</tr>
				<tr>
					<th>■レビュー投稿キャンペーン</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $get_campaign ?></th>
				</tr>
				<tr>
					<th>■オプション</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;">
						<u>・ビザ申請サポート</u><br>
						<?php echo $get_option1; ?><br>
						<u>・飛行機チケットの手配</u><br>
						<?php echo $get_option2;?><br>
						<u>・海外留学保険の取得</u><br>
						<?php echo $get_option3;?><br>
						<u>・空港出迎え・現地留学サポート</u><br>
						<?php echo $get_option4;?><br>
						<u>・オンライン英会話レッスン</u><br>
						<?php echo $get_option5;?>
						
					</th>						
				</tr>
				
				
				

			</table>
			<form name="form_conf" id="form_conf" method="post" action="<?php echo home_url(); ?>/apply_result">
				<div id="apply_conf_buttons">
					<input type="button" src="../images/return.png" alt="戻る" value="" onClick="history.go(-1)" id="btn_apply_return"/>
					<input type="submit" src="../images/send.png" alt="送信" name="btn02" value="" id="btn_apply_send"/>
				</div>
				<div class="clear"></div>
				<input type="hidden" name="purpose" value="<?php echo $get_purpose ?>" />
				<input type="hidden" name="want_school" value="<?php echo $get_want_school ?>" />
				<input type="hidden" name="course" value="<?php echo $get_course ?>" />
				<input type="hidden" name="school_hours" value="<?php echo $get_hours ?>" />				
				<input type="hidden" name="start_year" value="<?php echo $get_start_year ?>" />
				<input type="hidden" name="start_month" value="<?php echo $get_start_month ?>" />
				<input type="hidden" name="period" value="<?php echo $get_period ?>" />
				<input type="hidden" name="stay_type" value="<?php echo $get_stay_type ?>" />				
				<input type="hidden" name="arrange_period" value="<?php echo $get_arrange_period ?>" />								
				<input type="hidden" name="last_name" value="<?php echo esc_attr($get_last_name) ?>" />
				<input type="hidden" name="first_name" value="<?php echo esc_attr($get_first_name) ?>" />
				<input type="hidden" name="last_name_kana" value="<?php echo esc_attr($get_last_name_kana) ?>" />
				<input type="hidden" name="first_name_kana" value="<?php echo esc_attr($get_first_name_kana) ?>" />
				<input type="hidden" name="tel" value="<?php echo esc_attr($get_tel) ?>" />
				<input type="hidden" name="email" value="<?php echo esc_attr($get_email) ?>" />
				<input type="hidden" name="postal" value="<?php echo esc_attr($get_postal) ?>" />
				<input type="hidden" name="prefecture" value="<?php echo $get_prefecture ?>" />
				<input type="hidden" name="address" value="<?php echo esc_attr($get_address) ?>" />
				<input type="hidden" name="build" value="<?php echo esc_attr($get_build) ?>" />
				<input type="hidden" name="campaign" value="<?php echo $get_campaign ?>" />
				<input type="hidden" name="option1" value="<?php echo $get_option1; ?>" />				
				<input type="hidden" name="option2" value="<?php echo $get_option2; ?>" />				
				<input type="hidden" name="option3" value="<?php echo $get_option3; ?>" />												
				<input type="hidden" name="option4" value="<?php echo $get_option4; ?>" />	
				<input type="hidden" name="option5" value="<?php echo $get_option5; ?>" />																				
			</form>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->

<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
