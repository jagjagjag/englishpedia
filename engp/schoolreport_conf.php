<?php
/*
 Template Name: 学校情報相違通報_内容確認
 */

$postID				 = $_POST["postID"];
$school_name		 = $_POST["school_name"];
$school_jp_name		 = $_POST["school_jp_name"];
$report_name		 = $_POST["report_name"];
$email				 = $_POST["email"];
$report_text		 = $_POST["reporttxt"];
$display_report_text = nl2br($report_text);

get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">学校情報の間違いを報告する</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="regist_main">
		<div class ="regist_content_box">
			<table id="table_regist_conf" cellspacing="0" cellpadding="1"  class="table">
				<div id="regist_conf_line">
				以下の内容をご確認のうえ、よろしければ「送信する」をクリックしてください。<br>
				内容を変更される場合は「戻る」ボタンをクリックして入力フォームへお戻りください。
				</div>
				<tr>
					<th style="border:none;">お名前</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo esc_html($report_name); ?></th>
				</tr>

				<tr>
					<th>メールアドレス</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;"><?php echo esc_html($email); ?></th>
				</tr>

				<tr>
					<th>誤情報が含まれる学校名</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;">
						<p><?php echo esc_html($school_name)?></p>
						<p><?php echo esc_html($school_jp_name)?></p>
					</th>
				</tr>

				<tr>
					<th>内容</th>
				</tr>
				<tr>
					<th class="letter_style" style="border:none;">
					<?php
					$change_char = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $display_report_text);
					echo nl2br(esc_html($change_char));
					?></th>
				</tr>
			</table>

			<form name="form_conf" id="form_conf" method="post" action="<?php echo esc_url(home_url());?>/schoolreport_result">
				<div id="regist_conf_buttons">
					<input type="button" src="../images/return.png" alt="戻る" value="" onClick="history.go(-1)" id="btn_regist_return"/>
					<input type="submit" src="../images/send.png" alt="送信" name="btn02" value="" id="btn_report_send"/>
				</div>

				<div class="clear"></div>

				<input type="hidden" name="school_name" value="<?php echo esc_attr($school_name);?>" />
				<input type="hidden" name="school_jp_name" value="<?php echo esc_attr($school_jp_name);?>" />
				<input type="hidden" name="report_name" value="<?php echo esc_attr($report_name);?>" />
				<input type="hidden" name="email" value="<?php echo esc_attr($email);?>" />
				<input type="hidden" name="report_text" value="<?php echo esc_attr($report_text);?>" />
			</form>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->
<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
