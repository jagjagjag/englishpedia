<?php
/**
 * 検索バナー
 */
?>
		<div class="row">
			<div class="col-md-12">
				<div id="shcool_search" class="row" style="display:none;">
					<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
						<input type="hidden" name="s" id="s" placeholder="検索" />
						<input type="hidden" name="page" id="page" value="1" />
						<!-- Start: shcool_search_top -->
						<div class="f_left col-md-3 col-ms-12 col-xs-12">
							<h3>学校名から探す</h3>						
							<input type="text" class="form-control" name="school_name" id="school_name" placeholder="入力して下さい" <?php if($_SESSION['school_name']){ echo "value='".$_SESSION['school_name']."'";}?>"  style="cursor:text;">				
						</div>
												
						<div class="f_left col-md-3 col-ms-12 col-xs-12">						
							<h3>エリアから探す</h3>
							<select class="form-control c_select" name="division" id="division"" >
								<option value="">選択して下さい</option>
<?php
	foreach ($engp_master['division'] as $key => &$val) {
		if ($key == $_SESSION['division']) {
			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
		}
		else{
			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
		}
	}
?>
							</select>
						</div>
<!-- 						<div class="f_left col-md-3 col-ms-12 col-xs-12"> -->
<!-- 							<h3>目的から探す</h3> -->
<!-- 							<select class="form-control c_select" name="purpose""> -->
<!-- 								<option value="">選択して下さい</option> -->
 <?php
// 	foreach ($engp_master['purpose'] as $key => &$val) {
// 		if ($key == $_SESSION['purpose']) {
// 			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
// 		}
// 		else{
// 			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
// 		}
// 	}
 ?>
<!-- 							</select> -->
<!-- 						</div> -->
						<div class="f_left col-md-3 col-ms-12 col-xs-12">
							<h3>学費で探す(1ヶ月あたり)</h3>
							<select class="form-control c_select" name="fee"">
								<option value="">選択して下さい</option>
<?php
	foreach ($engp_master['tuition'] as $key => &$val) {
		if ($key == $_SESSION['fee']) {
			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
		}
		else{
			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
		}
	}
?>
							</select>
						</div>
						<div id="search_right_button" class="f_left col-md-3 col-ms-12 col-xs-12">
							<input type="submit" value="" style="background-image: url(<?php echo esc_url( get_template_directory_uri()); ?>/images/search_button.png); width:94px; height:46px; background-size:94px 46px;" />
						</div>
						<div class="clear"></div>
					</form>
				</div>
				<!-- End: school_search -->
			</div>
		</div>
