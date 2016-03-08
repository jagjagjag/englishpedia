<?php
/*
 Template Name: お気に入りリスト
*/

// ログインして無い場合はログイン画面へ飛ばす
if(empty($_COOKIE['gu_id'])){
	$loginUrl = esc_url(home_url()) . "/login";
	header("Location: {$loginUrl}");
}
$ID = engp_get_id($_COOKIE['gu_id']);
$favlist = engp_get_favlist($ID);
get_header();
?>

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/favorite-style.css' ); ?>" />

<!-- Start: タイトル、hr -->
<h1 class="favo_entry_title">
	<?php the_title(); ?>
</h1>
<hr>
<!-- End: タイトル、hr -->

<div class="container">
	<div class="int_main">
		<div id="favo_container">
<?php
	if(empty($favlist)):
?>
		<p>お気に入りは登録されていません</p>
<?php else: ?>

<?php
	if( (strpos($_SERVER['HTTP_USER_AGENT'], "iPhone")) == false and
		(strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) == false and
		(strpos($_SERVER['HTTP_USER_AGENT'], "iPad")) == false and
		(strpos($_SERVER['HTTP_USER_AGENT'], "Android")) == false ) {
?>
			<div class="favo_check_navi">
				<p class="favo_check f_left">チェックした学校を</p>
				<a href="javascript:void(0);"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/compare.png" onclick="myCheck()" alt="比較する" class="favo_check_btn" width="73" height="32"></a>
				<form method="get" action="<?php echo home_url(); ?>/compare" name="compare">
					<input type="hidden" id="cmpid" name="cmpid" value="">
				</form>
				<div class="clear"></div>
			</div>
<?php } ?>
<?php foreach ($favlist as $data): ?>

			<div class="row" id="favo_bigbox">

				<!-- Start:school_photo  -->
				<div class="col-sm-4 col-md-4 favo_center">
<?php
	if( (strpos($_SERVER['HTTP_USER_AGENT'], "iPhone")) == false and
		(strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) == false and
		(strpos($_SERVER['HTTP_USER_AGENT'], "iPad")) == false and
		(strpos($_SERVER['HTTP_USER_AGENT'], "Android")) == false ) {
?>
				
					<div id="check_box" class="checkbox d_tablecell"><input name="post_check[]" type="checkbox"  style="margin-top: 35px;" value=<?php echo $data->post_id; ?> /></div>
<?php } ?>
<?php
	$image_post_id = get_post_meta($data->post_id, 'my_upload_images', true);
	if(!empty($image_post_id[0])):
		$rank_image = wp_get_attachment_image_src($image_post_id[0], array(90,90));
?>
					<img class="favo_left" style="width: 90px; height: 90px;" src="<?php echo $rank_image[0]; ?>" alt="学校の写真">
<?php else: ?>
					<img class="favo_left" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/nophoto_90x90.jpg" alt="学校の写真">
<?php endif; ?>
				</div>
				<!-- End:school_photo  -->

				<div class="col-sm-8 col-md-8 favo_nopadding">
					<a href="<?php echo home_url(); ?>?school=<?php echo $data->post_id; ?>">
						<h1 class="favo_name favo_mgnT3"><?php echo $data->school_name ?></h1>
					</a>
					<p><?php echo $data->school_jp_name ?></p>
					<div class="favo_btnset">
						<span class="favo_btn_entry"><a href="<?php echo home_url(); ?>/apply?aplid=<?php echo $data->post_id; ?>"><img class="favo_apply" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_bottom_contact02.png" alt="この学校に申し込む"></a></span>
						<span class="favo_btn_delete">
							<input id="hiddenID" type="hidden" value="<?php echo $data->post_id; ?>" />
							<input id="hiddenUserID" type="hidden" value="<?php echo $ID; ?>" />
							<input id="hiddenShape" type="hidden" value="circle" />
						</span>
						<div id="favorite<?php echo $data->post_id; ?>">
							<a href='javascript:void(0)' onclick='javaScript:favorite(2,<?php echo $data->post_id; ?>)'><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/favorite_remove_circle.png" alt="お気に入り解除"></a>
						</div>
					</div>
				</div>
			</div>
<?php
		endforeach;
	endif;
?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/favorite.js" type="text/javascript"></script>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
