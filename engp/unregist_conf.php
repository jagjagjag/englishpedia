<?php
/*
 Template Name: 会員退会_退会確認
*/

//ID
$get_ID = $_POST["ID"];

get_header('nologin');
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/regist-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="regist_entry_title">EnglishPediaを退会</h1>
<hr>
<!-- End: タイトル、hr -->

<!-- Start: コンテンツ -->
<div class="container">
	<div class="regist_main">
		<div class ="regist_content_box">
			<table id="table_regist_conf" cellspacing="0" cellpadding="1" >
				<div id="regist_conf_line">
				退会するとお気に入り学校機能が使えなくなります。<br>
				それでもよろしければ以下の「退会」ボタンを押して下さい。
				</div>
			</table>

			<form name="form_conf" id="form_conf" method="post" action="unregist_result">
				<div id="regist_conf_buttons">
					<input type="button" src="../images/return.png" alt="戻る" value="" onClick="history.go(-1)" id="btn_regist_return"/>
					<input type="submit" src="../images/btn_resign02.png" alt="退会する" name="btn02" value="" id="btn_unregist_send"/>
				</div>

				<div class="clear"></div>

				<input type="hidden" name="ID" value="<?php echo $get_ID; ?>" />
				<input type="hidden" name="delete" value="1" />
			</form>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->
<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
