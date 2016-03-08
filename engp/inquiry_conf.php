<?php
/*
 Template Name: お問い合わせ_確認
*/

$last_name		= $_POST["last_name"];
$first_name		= $_POST["first_name"];
$prefectures 	= $_POST["prefectures"];
$email			= $_POST["email"];
$phone			= $_POST["phone"];
$purpose		= $_POST["purpose"];
$image			= $_POST["image"];
$period			= $_POST["period"];
$consultation	= $_POST["consultation"];
$display_consultation = nl2br($consultation);

$fb				= $_POST["fb"];
$yahoo			= $_POST["yahoo"];
$google			= $_POST["google"];
$twitter		= $_POST["twitter"];
$friend			= $_POST["friend"];
$other			= $_POST["other"];

get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>" />

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">
	お問い合わせ内容のご確認
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
					<th class="letter_style" style="border:none;"><?php echo esc_html($last_name).esc_html($first_name) ?></th>
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
					<th>携帯電話</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo esc_html($phone) ?></th>
				</tr>
				<tr>
					<th>希望都市イメージ</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $image ?></th>
				</tr>
				<tr>
					<th>渡航時期</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo $period ?></th>
				</tr>
				<tr>
					<th>相談したい内容</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;">
					<?php
					$change_char = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $display_consultation);
					echo nl2br(esc_html($change_char));
					?></th>
				</tr>
				<tr>
					<th>何を見てお知りになりましたか？</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;">
				     <?php
	if(!empty($fb)){
		$html = '<p>'.$fb.'</p>';
	}
	if(!empty($yahoo)){
		$html .= '<p>'.$yahoo.'</p>';
	}
	if(!empty($google)){
		$html .= '<p>'.$google.'</p>';
	}
	if(!empty($twitter)){
		$html .= '<p>'.$twitter.'</p>';
	}
	if(!empty($friend)){
		$html .= '<p>'.$friend.'</p>';
	}
	if(!empty($other)){
		$html .= '<p>'.$other.'</p>';
	}
	echo $html;
?>				    </th>
				</tr>
			</table>
			<form name="form_conf" id="form_conf" method="post" action="<?php echo home_url(); ?>/inquiry_result">
				<div id="regist_conf_buttons">
					<input type="button" alt="戻る" value="" onClick="history.go(-1)" id="btn_regist_return"/>
					<input type="submit" alt="送信" name="submit" value="" id="btn_inquiry_send"/>
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

<?php
	if(!empty($fb)){
		$hidden_html .= '<input type="hidden" id="fb" name="fb" value="1" />';
	}
	if(!empty($yahoo)){
		$hidden_html .= '<input type="hidden" id="yahoo" name="yahoo" type="checkbox" value="1" />';
	}
	if(!empty($google)){
		$hidden_html .= '<input type="hidden" id="google" name="google" type="checkbox" value="1" />';
	}
	if(!empty($twitter)){
		$hidden_html .= '<input type="hidden" id="twitter" name="twitter" type="checkbox" value="1" />';
	}
	if(!empty($friend)){
		$hidden_html .= '<input type="hidden" id="friend" name="friend" type="checkbox" value="1" />';
	}
	if(!empty($other)){
		$hidden_html .= '<input type="hidden" id="other" name="other" type="checkbox" value="1" />';
	}
	echo $hidden_html;
?>
		  </form>
	  </div>
	</div>
</div>
<!-- End:コンテンツ -->


<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
