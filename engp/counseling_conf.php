<?php
/*
 Template Name: カウンセリング申し込み_確認
*/

$last_name				= $_POST["last_name"];
$first_name				= $_POST["first_name"];
$prefectures 			= $_POST["prefectures"];
$email					= $_POST["email"];
$phone					= $_POST["phone"];
$image					= $_POST["image"];
$purpose				= $_POST["purpose"];
$consultation			= $_POST["consultation"];
$display_consultation	= nl2br($consultation);
$travel_plan			= $_POST["travel_plan"];
$preferred_date			= $_POST["preferred_date"] ." ". $_POST["preferred_time"];
$preferred_location		= $_POST["preferred_location"];

get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>" />

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">
	カウンセリング申し込み
</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="regist_main">
		<div class ="regist_content_box">
			<table id="table_inquiry_conf" cellspacing="0" cellpadding="1"  class="table">
				<div id="regist_conf_line">
				以下の内容をご確認のうえ、よろしければ「送信する」をクリックしてください。<br>
				内容を変更される場合は「戻る」ボタンをクリックして入力フォームへお戻りください。
				</div>
				<tr>
					<th style="border:none;">名前</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo esc_html($last_name).esc_html($first_name); ?></th>
				</tr>
				<tr>
					<th>都道府県</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $prefectures ?></th>
				</tr>
				<tr>
					<th>Eメールアドレス</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo esc_html($email) ?></th>
				</tr>
				<tr>
					<th>携帯電話番号</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo esc_html($phone) ?></th>
				</tr>
				<tr>
					<th>希望都市</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $image ?></th>
				</tr>
				<tr>
					<th>聞きたい内容</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;">
					<?php
					$change_char = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $display_consultation);
					echo nl2br(esc_html($change_char));
					?></th>
				</tr>
				<tr>
					<th>留学予定時期</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $travel_plan ?></th>
				</tr>
				<tr>
					<th>カウンセリング希望日時</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $preferred_date ?></th>
				</tr>
				<tr>
					<th>カウンセリング場所・方法</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $preferred_location ?></th>
				</tr>


			</table>
			<form name="counseling" method="post"  action="./counseling_result">
				<div id="regist_conf_buttons">
					<input type="button" alt="戻る" value="" onClick="history.go(-1)" id="btn_regist_return"/>
					<input type="submit" alt="送信" name="send" value="" id="btn_inquiry_send">
			  </div>
				<div class="clear"></div>
				<input type="hidden" id="first_name" name="first_name" value="<?php echo esc_attr($first_name) ?>"/>
				<input type="hidden" id="last_name" name ="last_name"value="<?php echo esc_attr($last_name) ?>"/>
				<input type="hidden" id="prefectures" name="prefectures" value="<?php echo $prefectures ?>"/>
				<input type="hidden" id="email" name="email" value="<?php echo esc_attr($email) ?>"/>
				<input type="hidden" id="phone" name="phone" value="<?php echo esc_attr($phone) ?>"/>
				<input type="hidden" id="purpose" name="purpose" value="<?php echo $purpose ?>"/>
				<input type="hidden" id="image" name="image" value="<?php echo $image ?>"/>
				<input type="hidden" id="period" name="period" value="<?php echo $period ?>"/>
				<input type="hidden" id="consultation" name="consultation" value="<?php echo esc_attr($consultation) ?>"/>
				<input type="hidden" id="candidate" name="candidate" value="<?php echo $candidate ?>"/>
				<input type="hidden" id="travel_plan" name="travel_plan" value="<?php echo $travel_plan ?>"/>
				<input type="hidden" id="preferred_date" name="preferred_date" value="<?php echo $preferred_date ?>"/>
				<input type="hidden" id="preferred_location" name="preferred_location" value="<?php echo $preferred_location ?>"/>
		  </form>
	  </div>
	</div>
</div>
<!-- End:コンテンツ -->


<?php get_footer(); ?>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/textcheck.js" type="text/javascript"></script>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
