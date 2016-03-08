<?php
/*
 Template Name: 留学見積もり
*/
get_header(); 
?>

<?php include('jquery.php'); ?>
<?php // Capture all variables using AJAX and send to sendmail.php using GET method by: Odysseus Ambut(ody@web-mech.net)?>
<script>
function passVar(){
var admission_fee_usd = $('#admission_fee_usd').text();
var admission_fee_jpy = $('#admission_fee_jpy').text();
var tuition_usd = $('#tuition_usd').text();
var tuition_jpy = $('#tuition_jpy').text();
var i20_issuance_postage_usd = $('#i20_issuance_postage_usd').text();
var i20_issuance_postage_jpy = $('#i20_issuance_postage_jpy').text();
var totalcost_usd = $('#totalcost_usd').text();
var totalcost_jpy = $('#totalcost_jpy').text();
var table_title = $('#capture_title').text();

$('#adm_fee_usd').val(admission_fee_usd);
$('#adm_fee_jpy').val(admission_fee_jpy);
$('#t_usd').val(tuition_usd);
$('#t_jpy').val(tuition_jpy);
$('#issuance_usd').val(i20_issuance_postage_usd);
$('#issuance_jpy').val(i20_issuance_postage_jpy);
$('#tcost_usd').val(totalcost_usd);
$('#tcost_jpy').val(totalcost_jpy);
$('#c_title').val(table_title);
}

</script>


<?php
$search_param = engp_set_return_search_param();
$engp_master = engp_get_master();
$post_id = $_GET['estid'];
// 初期値設定（12週間：全日制）
$period = (!empty($_POST['time'])) ? $_POST['time'] : "12";
$setParam = array(
		'estId' => $post_id,
		'period' => $period,
		'course'=>$_POST['course'],		
		'check_school_time'=>$_POST['check_school_time'],
// 		'check_airport'=>$_POST['check_airport'],
// 		'check_visa'=>$_POST['check_visa'],
		'stay_type'=>$_POST['stay_type'],		
		'arrange_period'=>$_POST['arrange_period'],		
);
$get_meta = engp_school_estimate($setParam);
$totalCost = 0;
?>　
<input type="hidden" id="estid" value="<?php echo $post_id;?>">

<link rel="stylesheet" type="text/css" href="<?php echo esc_url(get_template_directory_uri() . '/css/estimate-style.css' ); ?>"/>

<div id="hr"></div>
<div id="primary" class="content-area">
	<div id="main" class="site-main" role="main">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<p class="f_left link_search" onclick="OnOff1(shcool_search);" class="open"><a href="javascript:void(0)">もう一度検索する</a></p>
					<p class="f_left link_sankaku mgnT8 mgnR24" style="margin-bottom: 6px;"><a href="<?php echo home_url(); ?>/?s=<?php echo $search_param; ?>">検索結果に戻る</a></p>
					<p class="f_left link_sankaku mgnT8" style="margin-bottom: 6px;"><a href="<?php echo esc_url(home_url());?>/?school=<?php echo $get_meta->post_id; ?>">学校詳細に戻る</a></p>
				</div>
			</div>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-search.php");?>
		</div>

		<div class="container">
			<div class="row" style="margin-left: 0px; margin-right: 0px;">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<h1 class="h1_title">留学自動見積もり</h1>
				</div>
			</div>
			<!-- Start: estimate_schoo_waku -->
			<div class="row" style="margin-left: 0px; margin-right: 0px;">
				<div id="estimate_school" class="d_tablecell col-md-3 col-sm-12 col-xs-12">
					<p>自動見積もりをする学校</p>
				</div>
				<div id="estimate_school_info" class="d_tablecell col-md-9 col-sm-12 col-xs-12">
					<h1><?php echo $get_meta->school_name; ?></h1>
					<p><?php echo $get_meta->school_jp_name; ?></p>
				</div>
				<div class="clear"></div>
			</div>
			<!-- End: estimate_schoo_waku -->

 <?php // if($get_meta->so1_pt_offer || $get_meta->so2_pt_offer || $get_meta->so3_pt_offer || $get_meta->so4_pt_offer ||
// 		$get_meta->so1_ft_offer || $get_meta->so2_ft_offer || $get_meta->so3_ft_offer || $get_meta->so4_ft_offer){ ?>
			<!-- Start: sp_offer -->
<!-- 			<div class="row"> -->
<!-- 				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
<!-- 					<div id="sp_offer" class="d_table"> -->
<!-- 						<div id="sp_offer_left" class="d_tablecell col-lg-6 col-md-6 col-sm-12 col-xs-12"> -->
<!-- 							<p class="sp_offer_p color_yes">この学校にはスペシャルオファー(割引)があります！</p> -->
<!-- 						</div> -->
<!-- 						<div id="sp_offer_right" class="d_tablecell col-lg-6 col-md-6 col-sm-12 col-xs-12"> -->
							<!-- <p style="margin-bottom:0px;">スペシャルオファー(割引)とは、留学の長期割引です。<br>通常の留学とは異なり、入学日が定められています。</p>  -->
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 				</div> -->
<!-- 			</div> -->
			<!-- End: sp_offer -->
 <?php // } ?>

			<!-- Start: estimate_select_waku -->
			<div class="row" style="margin-left: 0px; margin-right: 0px;">
				<div id="estimate_select_waku" class="d_tablecell col-md-12 col-sm-12 col-xs-12">
					<div id="estimate_select" class="d_tablecell col-md-3 col-sm-12 col-xs-12">
						<p>見積もり条件を選択</p>
					</div>
					<div id="estimate_select_info" class="d_tablecell col-md-9 col-sm-12 col-xs-12">
						<div class="col-xs-1 col-sm-1 hidden-lg hidden-md">  </div>
						<div class="col-md-12 col-sm-10 col-xs-10">
							<form method="post" name="estimate" class="form-group">
								<div id="estimate_select_drop" class="d_tablecell">
									<p>コースを選択</p>
										<select class="g_select" name="course" id="course">
											<?php if(!empty($get_meta->name_pt)):?>
													<option value="pt" <?php if($setParam['course']=="pt"){echo "selected";}?>><?php echo $get_meta->name_pt;?></option>
											<?php endif; if(!empty($get_meta->name_ft)):?>
													<option value="ft" <?php if($setParam['course']=="ft"){echo "selected";}?>><?php echo $get_meta->name_ft;?></option>
											<?php endif; if(!empty($get_meta->name_cs3)):?>																							
													<option value="cs3" <?php if($setParam['course']=="cs3"){echo "selected";}?>><?php echo $get_meta->name_cs3;?></option>														
											<?php endif; if(!empty($get_meta->name_cs4)):?>																							
													<option value="cs4" <?php if($setParam['course']=="cs4"){echo "selected";}?>><?php echo $get_meta->name_cs4;?></option>														
											<?php endif; if(!empty($get_meta->name_cs5)):?>																							
													<option value="cs5" <?php if($setParam['course']=="cs5"){echo "selected";}?>><?php echo $get_meta->name_cs5;?></option>														
											<?php endif; if(!empty($get_meta->name_cs6)):?>																							
													<option value="cs6" <?php if($setParam['course']=="cs6"){echo "selected";}?>><?php echo $get_meta->name_cs6;?></option>														
											<?php endif; if(!empty($get_meta->name_cs7)):?>																							
													<option value="cs7" <?php if($setParam['course']=="cs7"){echo "selected";}?>><?php echo $get_meta->name_cs7;?></option>														
											<?php endif;?>		
										</select><br>								
									<span class="estimate_label_annotation">※コースによってはビザが必要になります。</span>									
 									<hr class="estimate_separator">									
									
									<p>留学期間を選択</p>
										<select class="g_select" name="time" id="time">
<?php
	if($setParam['course']){
		$time_course = $setParam['course'];
	}else{
		$time_course = "pt";
	}

	foreach ($engp_master['week'] as $key => &$val) {
		$check = $key."w_".$time_course;
		if($get_meta->$check){
			//2週間は出さない
			if($key == 2){continue;}
			
			if ($key == $setParam['period']) {
				echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
			}else{
				echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
			}
		}
	}
//	スペシャルオファーは非表示
// 	if($get_meta->so1_pt_offer || $get_meta->so1_ft_offer){
// 		if ('so1' == $setParam['period']) {
// 			echo "<option value='so1' selected>スペシャルオファー (割引)1</option>".PHP_EOL;
// 		}else{
// 			echo "<option value='so1'>スペシャルオファー (割引)1</option>".PHP_EOL;
// 		}
// 	}
// 	if($get_meta->so2_pt_offer || $get_meta->so2_ft_offer){
// 		if ('so2' == $setParam['period']) {
// 			echo "<option value='so2' selected>スペシャルオファー (割引)2</option>".PHP_EOL;
// 		}else{
// 			echo "<option value='so2'>スペシャルオファー (割引)2</option>".PHP_EOL;
// 		}
// 	}
// 	if($get_meta->so3_pt_offer || $get_meta->so3_ft_offer){
// 		if ('so3' == $setParam['period']) {
// 			echo "<option value='so3' selected>スペシャルオファー (割引)3</option>".PHP_EOL;
// 		}else{
// 			echo "<option value='so3'>スペシャルオファー (割引)3</option>".PHP_EOL;
// 		}
// 	}
// 	if($get_meta->so4_pt_offer || $get_meta->so4_ft_offer){
// 		if ('so4' == $setParam['period']) {
// 			echo "<option value='so4' selected>スペシャルオファー(割引) 4</option>".PHP_EOL;
// 		}else{
// 			echo "<option value='so4'>スペシャルオファー(割引) 4</option>".PHP_EOL;
// 		}
// 	}
?>
									</select><br>
<!-- 									<hr class="estimate_separator"> -->
									<div>
<!-- 										<p class="estimate_school_time">授業時間</p> -->
<!-- 										<p> -->
<!-- 											<label class="estimate_label"><input name="check_school_time" type="radio" value="0" <?php // if ($setParam['check_school_time'] != "1") echo 'checked="chekced"'; ?> /> 全日制(フルタイム) </label><br>
											<label class="estimate_label_first"><input name="check_school_time" type="radio" value="1" <?php // if ($setParam['check_school_time'] == "1") echo 'checked="chekced"'; ?> /> 半日制(パートタイム)</label><br>  -->
<!-- 											<span class="estimate_label_annotation">※全日制(フルタイム)の場合はビザが必要になります。</span> -->
<!-- 										</p> -->
										<hr class="estimate_separator">
										<p>滞在先</p>
										<p>
											<select name="stay_type" class="g_select" id="stay_type">
												<option value = "">▼選択して下さい</option>
												<?php if($get_meta->homestay):?>
													<option value="1" <?php if($setParam['stay_type'] == "1"){echo "selected";}?>>ホームステイ(1人部屋)</option>
												<?php endif;?>
												<?php if($get_meta->dormitory_1):?>												
													<option value="2" <?php if($setParam['stay_type'] == "2"){echo "selected";}?>>学生寮(1人部屋)</option>
												<?php endif;?>
												<?php if($get_meta->dormitory_2):?>																								
												<option value="3" <?php if($setParam['stay_type'] == "3"){echo "selected";}?>>学生寮(2人部屋)</option>												
												<?php endif;?>
												<?php if($get_meta->dormitory_3):?>																								
												<option value="4" <?php if($setParam['stay_type'] == "4"){echo "selected";}?>>学生寮(3人部屋)</option>
												<?php endif;?>
												<?php if($get_meta->dormitory_4):?>																								
												<option value="5" <?php if($setParam['stay_type'] == "5"){echo "selected";}?>>学生寮(4人部屋)</option>
												<?php endif;?>
												<option value="6" <?php if($setParam['stay_type'] == "6"){echo "selected";}?>>自分で手配する</option>																																																
																																															
											</select>
										</p>
										<hr class="estimate_separator">
										<p>滞在先の手配期間</p>										
										<p>
											<select name="arrange_period" class="g_select <?php if($setParam['stay_type'] == "6"){echo "select_invalid";}?>"  id="arrange_period">
												<option value = "">▼選択して下さい</option>
													<option value="1" <?php if($setParam['arrange_period'] == "1"){echo "selected";}?>>最初の4週間のみ手配を依頼</option>
												<?php if($period != 4):?>
													<option value="2" <?php if($setParam['arrange_period'] == "2"){echo "selected";}?>>最初の8週間のみ手配を依頼</option>
												<?php endif;?>				
												<option value="3" <?php if($setParam['arrange_period'] == "3"){echo "selected";}?>>留学期間中すべて手配を依頼</option>																																			
											</select>
										</p>
										<p class="arrange_period_bottom">
											※手配を依頼した期間が終了した後は、ご自身で滞在先の手配をお願いします。<br>
											※滞在期間を延長したり変更することも可能です。ご相談下さい。
										</p>
										
										
										<!-- 
										<p>
											<label class="estimate_label"><input name="check_airport" type="checkbox" value="1" <?php // if ($setParam['check_airport'] == "1") echo 'checked="chekced"'; ?> /> 空港出迎え有 </label>
											<label class="estimate_label"><input name="check_visa" type="checkbox" value="1" <?php // if ($setParam['check_visa'] == "1") echo 'checked="chekced"'; ?> /> ビザ申請代行(有料) </label>
										</p>
										 -->
										<a id="estimate_submit_mob" href="javascript:void(0);"><img class="pc_none tab_none estimate_mob_btn" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/estimate_bottun.png"  alt="自動見積もり"/></a>
									</div>
								</div>
								<div id="estimate_select_button" class="d_tablecell mob_none">
									<a id="estimate_submit" href="javascript:void(0);"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/estimate_bottun.png" alt="自動見積もり"/></a>
								</div>
							</form>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
			<!-- End: estimate_select_waku -->

			<!-- Start: estimate_title -->
			<div class="row" style="margin:0px;">
				<div id="estimate_title" class="d_table col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-9 col-xs-12">
							<h1 class="d_tablecell">自動見積もり結果</h1>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
							<p class="d_tablecell"><span style="color:#f24040;">※この自動見積もりは概算です。</span><br />この見積りには空港出迎え費用や航空券などの費用は含まれていません。<br>オプションなども含めた詳細見積りが必要な場合は、お電話にてお申し出ください。</p>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
			<!-- End: estimate_title -->

			<!-- Start: table_box -->
			<div id="table_box" class="d_table">
<?php
// 	if($setParam['period'] == 'so1'){
// 		$periodTitle = "スペシャルオファー (割引)1";
// 	}elseif($setParam['period'] == 'so2'){
// 		$periodTitle = "スペシャルオファー (割引)2";
// 	}elseif($setParam['period'] == 'so3'){
// 		$periodTitle = "スペシャルオファー (割引)3";
// 	}elseif($setParam['period'] == 'so4'){
// 		$periodTitle = "スペシャルオファー (割引)4";
// 	}else{
		$periodTitle = $get_meta->course_name."　".$engp_master['week'][$setParam['period']];
// 	}
?>
				<h1 class="glaftitle">留学費用 【 <span id="capture_title"> <?php echo $periodTitle; ?>】</h1></span>
				<table class="f_left">
					<tr>
						<th scope="row">&nbsp;</th>
						<td class="bigfont">ドル（米）</td>
						<td class="bigfont">日本円換算</td>
					</tr>
					<tr>
						<th scope="row">入学金</th>
<?php
	if(is_numeric($get_meta->admission_fee)){
		$viewCost = number_format($get_meta->admission_fee);
		$tempCost = intval($get_meta->admission_fee);
	}else{
		$viewCost = "-";
		$tempCost = 0;
	}
	$totalCost += $tempCost;

	if($get_meta->viewtype_yen == 0):
?>
						<td>
						<span id="admission_fee_usd" class="dollar"><?php echo $viewCost === "-" ? $viewCost : "$".$viewCost; ?></span>
						</td>
						<td>
							<span id="admission_fee_jpy">-</span>
						</td>
<?php else: ?>
						<td>
							<span>-</span>
						</td>
						<td>
							<span id="admission_fee"><?php echo $viewCost === "-" ? $viewCost : "&yen;".$viewCost; ?></span>
							</span>
						</td>
<?php endif; ?>
					</tr>
					<tr>
						<th scope="row">授業料</th>
<?php
	if(is_numeric($get_meta->tuition)){
			$viewCost = number_format($get_meta->tuition);
			$tempCost = intval($get_meta->tuition);
		}else{
			$viewCost = "-";
			$tempCost = 0;
		}
	$totalCost += $tempCost;

	if($get_meta->viewtype_yen == 0):
?>
						<td>
							<span id="tuition_usd" class="dollar"><?php echo $viewCost === "-" ? $viewCost : "$".$viewCost; ?></span>
							</span>
						</td>
						<td>
							<span id="tuition_jpy">-</span>
						</td>
<?php else: ?>
						<td>
							<span>-</span>
						</td>
						<td>
							<span id="tuition"><?php echo $viewCost === "-" ? $viewCost : "&yen;".$viewCost; ?></span>
						</td>

<?php endif; ?>
					</tr>
<?php
	if(is_numeric($get_meta->textbooks)):
		$viewCost = number_format($get_meta->textbooks);
		$tempCost = intval($get_meta->textbooks);
		$totalCost += $tempCost;
?>
					<tr>
						<th scope="row">テキスト代</th>
<?php if($get_meta->viewtype_yen == 0): ?>
						<td>
							<span id="textbooks_usd" class="dollar"><?php echo $viewCost === "-" ? $viewCost : "$".$viewCost; ?></span>
						</td>
						<td>
							<span id="textbooks_jpy">-</span>
						</td>
<?php else: ?>
						<td>
							<span>-<span>
						</td>
						<td>
							<span id="textbooks"><?php echo $viewCost === "-" ? $viewCost : "&yen;".$viewCost; ?></span>
						</td>
<?php endif; ?>
					</tr>
<?php
	endif;
	if( ($setParam['period'] >= 12) || ($setParam['period'] < 12 && $setParam['check_school_time'] != 1) ):
?>
					<tr>
						<th scope="row">I-20発行費</th>
<?php
		if(is_numeric($get_meta->i20_issuance_postage)){
			$viewCost = number_format($get_meta->i20_issuance_postage);
			$tempCost = intval($get_meta->i20_issuance_postage);
		}else{
			$viewCost = "-";
			$tempCost = 0;
		}
		$totalCost += $tempCost;

		if($get_meta->viewtype_yen == 0):
?>
						<td>
							<span id="i20_issuance_postage_usd" class="dollar"><?php echo $viewCost === "-" ? $viewCost : "$".$viewCost; ?></span>
						</td>
						<td>
							<span id="i20_issuance_postage_jpy">-</span>
						</td>
<?php else: ?>
						<td>
							<span>-</span>
						</td>
						<td>
							<span id="i20_issuance_postage"><?php echo $viewCost === "-" ? $viewCost : "&yen;".$viewCost; ?></span>
						</td>
<?php endif; ?>
					</tr>
<?php endif; ?>
<?php if($setParam['stay_type'] != "" and $setParam['stay_type'] != "6"):?>
					<tr>
						<th scope="row">滞在先手配料</th>
	<?php
		if(is_numeric($get_meta->accommodation_placement_fee)){
			$viewCost = number_format($get_meta->accommodation_placement_fee);
			$tempCost = intval($get_meta->accommodation_placement_fee);
		}else{
			$viewCost = "-";
			$tempCost = 0;
		}
		$totalCost += $tempCost;
	
		if($get_meta->viewtype_yen == 0):
	?>
							<td>
								<span id="accommodation_placement_fee_usd" class="dollar"><?php echo $viewCost === "-" ? $viewCost : "$".$viewCost; ?></span>
							</td>
							<td>
								<span id="accommodation_placement_fee_jpy">-</span>
							</td>
	<?php else: ?>
							<td>
								<span>-</span>
							</td>
							<td>
								<span id="accommodation_placement_fee"><?php echo $viewCost === "-" ? $viewCost : "&yen;".$viewCost; ?></span>
							</td>
	<?php endif; ?>
						</tr>
<?php
	$fee = 0;
	switch ($setParam['stay_type']){
		case "1":
			$tr_title = "ホームステイ(1人部屋)";
			$fee = intval($get_meta->homestay);
			break;
		case "2":
			$tr_title = "学生寮(1人部屋)";			
			$fee = intval($get_meta->dormitory_1);			
			break;
		case "3":
			$tr_title = "学生寮(2人部屋)";			
			$fee = intval($get_meta->dormitory_2);			
			break;
		case "4":
			$tr_title = "学生寮(3人部屋)";			
			$fee = intval($get_meta->dormitory_3);			
			break;
		case "5":
			$tr_title = "学生寮(4人部屋)";			
			$fee = intval($get_meta->dormitory_4);			
			break;
		default:
			$tr_title ="その他";
			$fee = 0;
	}
	//料金計算
	$caution_text = "";
	if($period == 'so1' || $period == 'so2' || $period == 'so3' || $period == 'so4'){
		$caution_text = "※お問い合わせ下さい　";
	}else{
		//依頼期間
		if($setParam['arrange_period']){
			if($setParam['arrange_period'] == 3){
				$stay_month = $period / 4;
			}else{
				$stay_month = $setParam['arrange_period'];
			}
		}
		//寮/ホームステイの料金 * 依頼期間
		$fee = $fee * $stay_month;
	
		//表示
		if($fee != 0){
			$viewCost = number_format($fee);
			$tempCost = intval($fee);
		}else{
			$viewCost = "-";
			$tempCost = 0;
		}
		$totalCost += $tempCost;
	}
?>
				<tr>
					<th scope="row"><?php echo $tr_title;?></th>
<?php 
	if($get_meta->viewtype_yen == 0):
?>
						<td>
							<span id="homestay_cost_usd" class="dollar"><?php if(mb_strlen($caution_text) == 0){ echo $viewCost === "-" ? $viewCost : "$".$viewCost; }else{echo $caution_text;}?></span>
						</td>
						<td>
							<span id="homestay_cost_jpy">-</span>
						</td>
<?php else: ?>
						<td>
							<span>-</span>
						</td>
						<td>
							<span id="homestay_cost"><?php if(mb_strlen($caution_text) == 0){ echo viewCost === "-" ? $viewCost : "&yen;".$viewCost; }else{echo $caution_text;}?></span>
						</td>
<?php endif; ?>
					</tr>
<?php endif;?>
					
<?php //if($setParam['check_airport']): ?>
<!-- 					<tr> -->
<!-- 						<th scope="row">空港出迎え</th> -->
<?php
// 	if(is_numeric($get_meta->airport_pickup_cost)){
// 		$viewCost = number_format($get_meta->airport_pickup_cost);
// 		$tempCost = intval($get_meta->airport_pickup_cost);
// 	}else{
// 		$viewCost = "-";
// 		$tempCost = 0;
// 	}
// 	$totalCost += $tempCost;

// 	if($get_meta->viewtype_yen == 0):
?>
<!-- 						<td> -->
<!-- 							<span id="airport_pickup_cost_usd" class="dollar"><?php // echo $viewCost === "-" ? $viewCost : "$".$viewCost; ?></span> -->
<!-- 						</td> -->
<!-- 						<td> -->
<!-- 							<span id="airport_pickup_cost_jpy">-</span> -->
<!-- 						</td> -->
<?php // else: ?>
<!-- 						<td> -->
<!-- 							<span>-</span> -->
<!-- 						</td> -->
<!-- 						<td> -->
<!-- 							<span id="airport_pickup_cost"><?php // echo $viewCost === "-" ? $viewCost : "&yen;".$viewCost; ?></span> -->
<!-- 						</td> -->
<?php // endif; ?>
					</tr>
<?php
	// endif;
	if(is_numeric($get_meta->bank_charge)):
		$viewCost = number_format($get_meta->bank_charge);
		$tempCost = intval($get_meta->bank_charge);
		$totalCost += $tempCost;
?>
					<tr>
						<th scope="row">バンクチャージ</th>
<?php if($get_meta->viewtype_yen == 0): ?>
						<td>
							<span id="bank_charge_usd" class="dollar"><?php echo $viewCost === "-" ? $viewCost : "$".$viewCost; ?></span>
						</td>
						<td>
							<span id="bank_charge_jpy">-</span>
						</td>
<?php else: ?>
						<td>
							<span>-</span>
						</td>
						<td>
							<span id="bank_charge"><?php echo $viewCost === "-" ? $viewCost : "&yen;".$viewCost; ?></span>
						</td>
<?php endif; ?>
					</tr>
<?php
	endif;
// 	if($setParam['check_visa']):
 ?>
<!-- 					<tr> -->
<!-- 						<th scope="row">ビザ申請サポート</th> -->
<!-- 						<td><span>-</span></td> -->
<?php // if($setParam['period'] < 12 && ($setParam['check_school_time'] != 1)): ?>
<!-- 						<td> -->
<!-- 							<span>-</span> 
							<span id="visa" style="display:none">0</span> -->
<!-- 						</td> -->
<?php // else: ?>
<!-- 						<td> -->
<!-- 							<span>&yen;14,800</span> 
							<span id="visa" style="display:none">14800</span> -->
<!-- 						</td> -->
<?php
	 //endif;
?>
<!-- 					</tr> -->
<?php // endif;?>
					<tr class="sum">
						<th scope="row">合計</th>
<?php if($get_meta->viewtype_yen == 0): ?>
						<td>
							<span id="totalcost_usd" class="sumnumber"><?php echo "$".number_format($totalCost); ?></span>
						</td>
						<td>
							<span id="totalcost_jpy" class="sumnumber">-</span>
						</td>
<?php else: ?>
						<td>
							<span>-</span>
						</td>
						<td>
							<span id="totalcost" class="sumnumber"><?php echo "&yen;".number_format($totalCost); ?></span>
						</td>
<?php endif; ?>
					</tr>
				</table>
			</div>
			<!-- End: table_box -->
			
			
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<a href="<?php echo home_url();?>/counseling">
						<div class="detail_btn">
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/detail_link07_estimate.png" alt="カウンセリングに申し込む" class="detail_btnimg"><br/>カウンセリングに申し込む
						</div>
					</a>						
				</div>
				
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="detail_btn3"">
						<a id="modal_trigger" href="#modal">
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sendmail.png" alt="お見積もりをメールで受信する" class="detail_btnimg"><br/>お見積もりをメールで受信する
						</div>
					</a>
				<div id="modal" class="popupContainer" style="display:none;">
				<header class="popupHeader">
				<span class="header_title">Send Estimates To Email</span>
				<span class="modal_close"><i class="fa fa-times"></i></span>
				</header>
				<section class="popupBody">
			
			<div class="user_register">
				<form method="get" action="<?php echo home_url();?>/send-email-estimates">
					<label>Full Name</label>
					<input type="text" name="recName" required />
					<br />

					<label>Email Address</label>
					<input type="email" name="recEmail" required />
					<br />

					<div class="checkbox">
						<input id="send_updates" name="recNewsletter" type="checkbox" value="yes"/>
						<label for="send_updates">Add me to Newsletter</label>
					</div>

					<div class="action_btns">
					
					 <input type="submit" value="Send Email" class="pbtn pbtn_red" onCLick ="passVar()"> 
					
					<!-- Initialize variables for email estimates -->
					<input type="hidden" name="adm_fee_usd" id="adm_fee_usd">
					<input type="hidden" name="adm_fee_jpy" id="adm_fee_jpy">
					<input type="hidden" name="t_usd" id="t_usd">
					<input type="hidden" name="t_jpy" id="t_jpy">
					<input type="hidden" name="issuance_usd" id="issuance_usd">
					<input type="hidden" name="issuance_jpy" id="issuance_jpy">
					<input type="hidden" name="tcost_usd" id="tcost_usd">
					<input type="hidden" name="tcost_jpy" id="tcost_jpy">
					<input type="hidden" name="c_title" id="c_title">
					<input type="hidden" name="school_n" value ="<?php echo $get_meta->school_name; ?>">
					<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
			
					</div>
				</form>
			</div>
		</section>
	</div>
</div>




<script type="text/javascript">
	$("#modal_trigger").leanModal({top : 200, overlay : 0.6, closeButton: ".modal_close" });
	
</script>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<a href="<?php echo home_url();?>/apply?aplid=<?php echo $post_id;?>&period=<?php echo $period;?>&course=<?php if($setParam['course']){ echo $setParam['course'];}else{echo "pt";};?>&stay=<?php echo $setParam['stay_type'];?>&arrange=<?php echo $setParam['arrange_period'];?>">
						<div class="detail_btn2">
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/detail_link08_estimate.png" alt="この内容で留学申し込みをする" class="detail_btnimg"><br/>この内容で留学申し込みをする
						</div>
					</a>					
				</div>
				
			</div>
			
			<!-- Start: estimate_column -->
			<div id="estimate_column">
				<p id="estimate_remarks">
					※ビザ取得が必要な場合、取得に必要な費用が別途発生します。<br>
					※航空費、海外保険費、などのオプション料金は含まれていません。<br>
					※バンクチャージ/海外送金費が別途かかる場合があります。<br>
					※テキスト代はクラス分け後に現地でお支払い頂きます。<br>
					※滞在先によっては保証金や早朝/深夜着料金が発生する場合があります。<br>
					※為替変動により若干料金が変更になる可能性があります。<br>
					※実際のご請求三井住友銀行の為替レートを使用しており、<br>
					　為替レートの変動に対してはリスクヘッジをさせていただいております。<br>
					※表示金額はすべて外税です。
				</p>
			
 <?php // if($setParam['period'] < 12 && $setParam['check_school_time'] != 1): ?>
<!-- 				<p id="estimate_remarks"> -->
<!-- 					※滞在先手配期間はホームステイ1人部屋2食付きです。その他の滞在方法をご希望の場合は別途お問合せください。<br> -->
<!-- 					※滞在先によっては入居時デポジットが必要な場合があります。<br> -->
<!-- 					※到着/入居の時間によっては、早朝/深夜料金が発生する場合があります。<br> -->
<!-- 					※航空費、海外保険費、現地留学サポートは含まれていません。ご希望の場合は、別途お問い合わせください。<br> -->
<!-- 					※お申し込み時プランによっては金額が異なる場合があります。<br> -->
<!-- 					※テキスト代はクラス分けテスト後に現地でお支払いください。<br> -->
<!-- 					※バンクチャージ/海外送金費が別途かかる場合があります。<br> -->
<!-- 					※上記でご案内した見積もりは、現時点でのものです。お申込時に料金が変更されている場合がありますので、あらかじめご了承ください。<br> -->
<!-- 					※実際の請求金額は、三井住友銀行の為替レートを使用しており、為替レートの変動に対してはリスクヘッジをさせていただいております。<br> -->
<!-- 					※表示金額はすべて外税です。 -->
<!-- 				</p> -->
 <?php // elseif($setParam['period'] < 12 && $setParam['check_school_time'] == 1): ?>
<!-- 				<p id="estimate_remarks"> -->
<!-- 					※滞在先手配期間はホームステイ1人部屋2食付きです。その他の滞在方法をご希望の場合は別途お問合せください。<br> -->
<!-- 					※滞在先によっては入居時デポジットが必要な場合があります。<br> -->
<!-- 					※ビザ申請サポートをお申込でない場合、SEVIS費・ビザ申請費はご自分でお支払となります。<br> -->
<!-- 					※到着/入居の時間によっては、早朝/深夜料金が発生する場合があります。<br> -->
<!-- 					※航空費、海外保険費、現地留学サポートは含まれていません。ご希望の場合は、別途お問い合わせください。<br> -->
<!-- 					※お申し込み時プランによっては金額が異なる場合があります。<br> -->
<!-- 					※テキスト代はクラス分けテスト後に現地でお支払いください。<br> -->
<!-- 					※バンクチャージ/海外送金費が別途かかる場合があります。<br> -->
<!-- 					※上記でご案内した見積もりは、現時点でのものです。お申込時に料金が変更されている場合がありますので、あらかじめご了承ください。<br> -->
<!-- 					※実際の請求金額は、三井住友銀行の為替レートを使用しており、為替レートの変動に対してはリスクヘッジをさせていただいております。<br> -->
<!-- 					※表示金額はすべて外税です。 -->
<!-- 				</p> -->
 <?php // elseif($setParam['period'] >= 12): ?>
<!-- 				<p id="estimate_remarks"> -->
<!-- 					※滞在先手配期間はホームステイ1人部屋2食付きです。その他の滞在方法をご希望の場合は別途お問合せください。<br> -->
<!-- 					※滞在先によっては入居時デポジットが必要な場合があります。<br> -->
<!-- 					※ビザ申請サポートをお申込でない場合、SEVIS費・ビザ申請費はご自分でお支払となります。<br> -->
<!-- 					※到着/入居の時間によっては、早朝/深夜料金が発生する場合があります。<br> -->
<!-- 					※航空費、海外保険費、現地留学サポートは含まれていません。ご希望の場合は、別途お問い合わせください。<br> -->
<!-- 					※お申し込み時プランによっては金額が異なる場合があります。<br> -->
<!-- 					※テキスト代はクラス分けテスト後に現地でお支払いください。<br> -->
<!-- 					※バンクチャージ/海外送金費が別途かかる場合があります。<br> -->
<!-- 					※上記でご案内した見積もりは、現時点でのものです。お申込時に料金が変更されている場合がありますので、あらかじめご了承ください。<br> -->
<!-- 					※実際の請求金額は、三井住友銀行の為替レートを使用しており、為替レートの変動に対してはリスクヘッジをさせていただいております。<br> -->
<!-- 					※表示金額はすべて外税です。 -->
<!-- 				</p> -->
 <?php // else: ?>
<!-- 				<p id="estimate_remarks"> -->
<!-- 					※表示金額はすべて外税です。 -->
<!-- 				</p> -->
 <?php // endif; ?>
			</div>
			<!-- End: estimate_column -->

			<!-- Start: estimate_contact_box -->
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div id="estimate_contact_box" class="d_table">
						<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
							<p class="esti_contact_p">
								<span style="color:#f24040;">※この自動見積もりは概算です。</span><br />
								この見積りには空港出迎え費用や航空券などの費用は含まれていません。オプションなども含めた詳細見積りが必要な場合は、お電話にてお申し出ください。
							</p>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-5 hidden-xs">
							<div id="esti_contact_btn">
									<a href="<?php echo esc_url(home_url());?>/inquiry"><img class="img-responsive esti_contact_img" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_bottom_contact.png" alt="メールで問い合わせる"/></a>
							</div>
							<div id="esti_entry_btn">
								<a href="<?php echo esc_url(home_url());?>/apply?aplid=<?php echo $get_meta->post_id; ?>"><img class="esti_apply_img" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_bottom_entry.png" alt="この学校に申し込む"/></a>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-7 hidden-xs" style="padding:0px;">
							<div id="contact_minibox" class="d_tablecell">
								<img class="esti_entry_img" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/contact_byphone.png" alt="お電話でのお問い合わせはこちらから" align="left"/>
							</div>
						</div>
						<div class="hidden-lg hidden-md hidden-sm col-xs-6">
							<a href="<?php echo esc_url(home_url());?>/apply?aplid=<?php echo $get_meta->post_id; ?>"><img class="img-responsive" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_bottom_entry_mob.png" alt="この学校に申し込む"/></a>
						</div>
						<div class="hidden-lg hidden-md hidden-sm col-xs-6">
								<img class="img-responsive" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/contact_byphone_mob.png" alt="お電話でのお問い合わせはこちらから" align="left"/>
						</div>

					</div>
				</div>
			</div>
			<!-- End: estimate_contact_box -->
		</div>

		<div class="container">
			<!-- Start: info_banner -->

			<div id="info_banner" class="mob_none tab_none">
				<div class="row">
					<div class="col-md-4 col-ms-4 col-xs-4 mob_top_banner_right">
						<a href="<?php echo esc_url(home_url());?>/introduction/">
							<img class="mgnT20" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner01.png" alt="EnglishPediaの使い方" />
						</a>
					</div>
					<div class="col-md-4 col-ms-4 col-xs-4 mob_top_banner_center" >
						<a href="<?php echo esc_url(home_url());?>/posts_info/">
							<img class="mgnT20" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner02.png" alt="留学情報まとめ" />
						</a>
					</div>
					<div class="col-md-4 col-ms-4 col-xs-4 mob_top_banner_left" >
						<a href="<?php echo home_url(); ?>/budget/">
							<img class="mgnT20" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner03.png" alt="留学費用の相場" />
						</a>
					</div>
				</div>
			</div>
			<!-- End:info_banner -->
			<!-- Start:mob_info_banner -->
			<div id="info_banner" class="pc_none">
				<div class="row">
					<div class="hidden-lg hidden-md col-sm-4 col-xs-4 mob_top_banner_right">
						<a href="<?php echo esc_url(home_url());?>/introduction/">
							<img class="mgnT20" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/mob_banner01.png" alt="EnglishPediaの使い方" />
						</a>
					</div>
					<div class="hidden-lg hidden-md col-sm-4 col-xs-4 mob_top_banner_center">
						<a href="<?php echo esc_url(home_url());?>/posts_info/">
							<img class="mgnT20" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/mob_banner02.png" alt="留学情報まとめ" />
						</a>
					</div>
					<div class="hidden-lg hidden-md col-sm-4 col-xs-4 mob_top_banner_left">
						<a href="<?php echo esc_url(home_url());?>/inquiry/">
							<img class="mgnT20" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/mob_banner06.png" alt="お問合せ" />
						</a>
					</div>
				</div>
			</div>
			<!-- End:mob_info_banner -->
		</div>

	</div><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); ?>
<script src="<?php echo esc_url( get_template_directory_uri() . '/js/estimate.js' ); ?>"></script>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
