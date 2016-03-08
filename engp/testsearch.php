<?php
/*
 Template Name: Test Search Only
*/
get_header();
$engp_master = engp_get_master();
$get_recommend = engp_school_recommend();
$rate_time = engp_get_rate_time();
$get_top_review = engp_school_review_top();
$get_epscore = engp_school_epscore();
?>
					<div class="col-xs-12 col-sm-12 col-md-8">
						<!-- Start: map -->
						<div id="map" class="f_left row">
							<!-- Start: map_left -->
							<div id="map_left" class="f_left col-md-4 col-sm-12 col-xs-12">
								<div class="form-group" style="margin-bottom:0px;">
									<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/test-search//">
									<!--	<input type="hidden" name="s" id="s" placeholder="検索" /> -->
									<!--	<input type="hidden" name="page" id="page" value="1" /> -->

										<h1>学校を探す</h1>

										<h4>学校名から探す</h4>
										<input type="text" class="form-control" name="school_name" id="school_name" placeholder="入力して下さい" style="cursor:text;">

										<h4>エリアから探す</h4>
										<select class="form-control" name="division" id="division">
											<option value="">選択して下さい</option>
<?php
	foreach ($engp_master['division'] as $key => &$val) {
		if ($key==$division) {
			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
		}else{
			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
		}
	}
?>
										</select>
<!-- 										<h4>目的から探す</h4> -->
<!-- 										<select class="form-control" name="purpose" id="purpose"> -->
<!-- 											<option value="">選択して下さい</option> -->
 <?php
// 	foreach ($engp_master['purpose'] as $key => &$val) {
// 		if ($key==$purpose) {
// 			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
// 		}else{
// 			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
// 		}
// 	}
// ?>
<!-- 										</select> -->

										<h4>学費で探す(1ヶ月あたり)</h4>
										<select class="form-control s_select" name="fee" id="fee">
											<option value="">選択して下さい</option>
<?php
	foreach ($engp_master['tuition'] as $key => &$val) {
		if ($key==$division) {
			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
		}else{
			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
		}
	}
?>
										</select>

										<!-- ↓検索ボタン↓ -->
										<div id="search_btn" class="row">
											<div class="col-md-4 col-ms-4 hidden-xs" style="padding-left: 0px; padding-right: 5px;">
												<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/bn_guarantee_3.png" alt="業界最安値" class="record_low f_right mob_none tab_none" style="padding-top: 0px;">
											</div>
											<div class="col-md-8 col-ms-8 col-xs-12" style="padding-left: 0px; padding-right: 0px; text-align:right;">
												<input id="submit_button" type="submit" value="" class="search_btn" style="background-image: url(<?php echo esc_url(get_template_directory_uri()); ?>/images/search_button.png); width:94px; height:47px; background-size: 94px 47px; border:none; margin-left: 5px;" />
											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- End: map_left -->
