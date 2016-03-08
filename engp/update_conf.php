<?php
/*
 Template Name: 会員情報更新_内容確認
 */

//メール
$get_email = $_POST["email"];
//パスワード
$get_password = $_POST["password"];
//名前
$get_display_name = $_POST["display_name"];
//ID
$get_ID = $_POST["ID"];

get_header('nologin');
?>
<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">更新内容のご確認</h1>
<hr>
<!-- End: タイトル、hr -->
<!-- Start: コンテンツ -->
<div id = "wrap">
	<div class="container">
		<div class="regist_main">
			<div class ="regist_content_box3">
				<table id="table_regist_conf" cellspacing="0" cellpadding="1" class="table">
					<div id="regist_conf_line2">
					以下の内容をご確認のうえ、よろしければ「更新する」をクリックしてください。<br>
					内容を変更される場合は「戻る」ボタンをクリックして入力フォームへお戻りください。
					</div>
					<tr>
						<th style="border:none;">名前</th>
						<td style="border:none;"><?php echo $get_display_name ?></td>
					</tr>
					<tr>
						<th>Eメールアドレス</th>
						<td><?php echo $get_email ?></td>
					</tr>
					<?php if($get_password):?>
					<tr>
						<th>新しいパスワード</th>
						<td><?php echo $get_password ?></td>
					</tr>
					<?php endif;?>
				</table>

				<form name="form_conf" id="form_conf" method="post" action="update_result">
					<div id="regist_conf_buttons">
						<input type="button" src="../images/return.png" alt="戻る" value="" onClick="history.go(-1)" id="btn_regist_return"/>
						<input type="submit" src="../images/renew.png" alt="更新する" name="btn02" value="" id="btn_renew_send"/>
					</div>
					<div class="clear"></div>
					<input type="hidden" name="email" value="<?php echo $get_email ?>" />
					<input type="hidden" name="password" value="<?php echo $get_password ?>" />
					<input type="hidden" name="display_name" value="<?php echo $get_display_name ?>" />
					<input type="hidden" name="ID" value="<?php echo $get_ID ?>" />
				</form>
			</div>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->

<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
