<?php
/*
 Template Name: 留学申し込み
*/
$ID = engp_get_id($_COOKIE['gu_id']);
$user_data = engp_get_user($ID);

$post_id = $_GET['aplid'];
if(empty($post_id)){
	$post_id = 0;
}

$school_data = engp_get_school($post_id);
$get_meta = engp_school_detail($post_id);

$engp_master = engp_get_master();
$division_list = $engp_master['division'];

if(isset($_GET['course'])){
	$course = $_GET['course'];	
	$period = $_GET['period'];
	$stay = $_GET['stay'];
	$arrange_period = $_GET['arrange'];
}

get_header('nologin');
?>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/textcheck.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/apply-style.css' ); ?>"/>

<!-- Start: タイトル、hr -->
<h1 class="apply_entry_title">留学のお申込み</h1>
<hr>
<!-- End: タイトル、hr -->


<!-- Start: コンテンツ -->
<div class="container">
	<div class="apply_main">
		<!-- Start: お申込みから留学開始までの流れ -->
		<div class="bn_step"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/bn_step2.png" class="img-responsive hidden-xs hidden-sm" width="100%" height="auto" alt="お申込みから留学開始までの流れ" />
		<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/bn_step_mob.png" class="img-responsive hidden-md hidden-lg" width="1060" height="175" alt="お申込みから留学開始までの流れ" /></div>
		<!-- End: お申込みから留学開始までの流れ -->	
		<p class="apply_line">留学お申し込みフォームです。<br>下記項目をご記入の上、「送信内容の確認」ボタンを押して下さい。<br>お申込み後、EnglishPediaサポートセンターよりご確認のご連絡させて頂きます。</p>
		<div class ="apply_content_box">
			<form class="form-horizontal" name="form" method="post" action="<?php echo esc_url(home_url());?>/apply_option" enctype="multipart/form-data" onsubmit="return val_check();">
				<div class="apply_form">
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p style="margin-top: 5px;">以下の必要事項を入力してください。<br>（<span class="apply_chk_notes">*</span>は必須項目です）</p>
							<h2 class="apply_box">留学情報</h2>
						</div>
					</div>

<!-- 					<div class="row mgnB8"> -->
<!-- 						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12"> -->
<!-- 							<span class="apply_head"><label for="purpose">留学目的</label></span> -->
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 					<div class="form-group row mgnB8"> -->
<!-- 						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12"> -->
<!-- 							<select id="purpose" name="purpose" title="希望留学目的" class="form-control" style="width:100%;"> -->
<!-- 								<option value="">--なし--</option> -->
<!-- 								<option value="とにかく外国語を話せるようになりたい。">とにかく外国語を話せるようになりたい。</option> -->
<!-- 								<option value="資格取得/TOEICスコアアップなど留学を形に残したい!!">資格取得/TOEICスコアアップなど留学を形に残したい!!</option> -->
<!-- 								<option value="ワーホリ/インターンシップなど現地で働く経験がしたい!!">ワーホリ/インターンシップなど現地で働く経験がしたい!!</option> -->
<!-- 								<option value="ダンス/ヨガ/ネイルなど語学＋&amp;alpha;のスキルを身につけたい！">ダンス/ヨガ/ネイルなど語学＋αのスキルを身につけたい！</option> -->
<!-- 								<option value="とにかく海外で（を）生活・体験してみたい">とにかく海外で（を）生活・体験してみたい</option> -->
<!-- 								<option value="将来は大学・大学院へ進学したい!">将来は大学・大学院へ進学したい!</option> -->
<!-- 								<option value="その他">その他</option> -->
<!-- 							</select> -->
<!-- 						</div> -->
<!-- 					</div> -->

					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
<?php  if(empty($post_id)): ?>
							<p class="apply_head"><label for="want_school"><span class="apply_chk_notes">*</span>希望学校</label></p>
						</div>
					</div>
					<div class="form-group row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<select name="postID" class="form-control" id="postID">
									<option value="">▼ 学校名</option>
									<?php 
									$division_id = null; 
									foreach ($school_data as $data) : 
										  if($division_id != $data->division){
											$division_id = $data->division;
											$division_name = $division_list[$division_id];
 											$html .= "<optgroup label=".$division_name.">";
											$html .= "<option value=".$data->post_id.">".$data->school_name."(".$data->school_jp_name.")</option>";
										  }else{
											$html .= "<option value=".$data->post_id.">".$data->school_name."(".$data->school_jp_name.")</option>";
										}
									endforeach;
									echo $html;															
									?>
								</select>
							</div>
										</div>
<?php else:?>
							<p class="apply_head"><label for="want_school">希望学校</label></p>
						</div>
					<div class="form-group row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p><b><?php echo $school_data ->school_name?></b></p>
							<p>(<?php echo $school_data ->school_jp_name?>)</p>
						</div>
					</div>
					<input type="hidden" name="postID" id="postID" value="<?php echo ($post_id);?>" />					
<?php endif;?>
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="apply_head"><label for="course"><span class="apply_chk_notes">*</span>コース</label></p>
						</div>
					</div>

					<div class="form-group row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
<?php
	if(empty($post_id)){
		echo "<select name='course' class='form-control' id='course'>";
		echo "<option value=''>▼ コース</option>";
		foreach ($engp_master['course'] as $key => &$val) {	
			echo "<option value='".$val."'>".$val."</option>".PHP_EOL;
		}
		echo "</select>";
	}elseif ($course){
		if($course == "pt"){echo "<input type='hidden' name='course' value='{$get_meta->course_name_pt}'><p><b>{$get_meta->course_name_pt}</b></p>";};
		if($course == "ft"){echo "<input type='hidden' name='course'value='{$get_meta->course_name_ft}'><p><b>{$get_meta->course_name_ft}</b></p>";};		
		if($course == "cs3"){echo "<input type='hidden' name='course' value='{$get_meta->course_name_cs3}'><p><b>{$get_meta->course_name_cs3}</b></p>";};				
		if($course == "cs4"){echo "<input type='hidden' name='course' value='{$get_meta->course_name_cs4}'><p><b>{$get_meta->course_name_cs4}</b></p>";};		
		if($course == "cs5"){echo "<input type='hidden' name='course' value='{$get_meta->course_name_cs5}'><p><b>{$get_meta->course_name_cs5}</b></p>";};		
		if($course == "cs6"){echo "<input type='hidden' name='course' value='{$get_meta->course_name_cs6}'><p><b>{$get_meta->course_name_cs6}</b></p>";};
		if($course == "cs7"){echo "<input type='hidden' name='course' value='{$get_meta->course_name_cs7}'><p><b>{$get_meta->course_name_cs7}</b></p>";};				
		
	}else{
		echo "<select name='course' class='form-control' id='course'>";
		echo "<option value=''>▼ コース</option>";
		if($get_meta->target_ESL){echo "<option value='ESL'>ESL</option>".PHP_EOL;}
		if($get_meta->target_TOEFL){echo "<option value='TOEFL'>TOEFL</option>".PHP_EOL;}
		if($get_meta->target_TOEIC)	{echo "<option value='TOEIC'>TOEIC</option>".PHP_EOL;}
		if($get_meta->target_advance){echo "<option value='大学進学'>大学進学</option>".PHP_EOL;}
		if($get_meta->target_business){echo "<option value='ビジネス'>ビジネス</option>".PHP_EOL;}
		if($get_meta->target_child)	{echo "<option value='子供向け(U12、U15など)'>子供向け(U12、U15など)</option>".PHP_EOL;}
		if($get_meta->target_adult)	{echo "<option value='アダルト(大人向け)'>アダルト(大人向け)</option>".PHP_EOL;}
		if($get_meta->target_ILETS)	{echo "<option value='IELTS'>IELTS</option>".PHP_EOL;}
		if($get_meta->target_so)	{echo "<option value='スペシャルオファー'>スペシャルオファー</option>".PHP_EOL;}
		if($get_meta->target_other)	{echo "<option value='その他'>その他</option>".PHP_EOL;}		
		echo "</select>";
	}
?>
							<p class="annotation_text">※留学期間が90日以内であっても、全日制(フルタイム)を選択される場合はビザ取得が必要となります。</p>
						</div>
					</div>

<!-- 					<div class="row mgnB8"> -->
<!-- 						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12"> -->
<!-- 							<p class="apply_head"><label for="school_hours"><span class="apply_chk_notes">*</span>授業時間</label></p> -->
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 					<div class="form-group row mgnB8"> -->
<!-- 						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12"> -->
<!-- 							<div class="radio-inline"> -->
<!-- 								<input type="radio" value="全日制(フルタイム)" name="school_hours" id="full" <?php // if($hour == "0"){ echo "checked";}?> -->
<!-- 								<label for="full">全日制(フルタイム)</label> -->
<!-- 							</div> -->
<!-- 							<div class="radio-inline"> -->
<!-- 								<input type="radio" value="半日制(パートタイム)" name="school_hours" id="helf" <?php // if($hour == "1"){ echo "checked";}?>>  -->
<!-- 								<label for="helf">半日制(パートタイム)</label> -->
<!-- 							</div> -->
<!-- 							<p class="annotation_text">※留学期間が90日以内であっても、全日制(フルタイム)を選択される場合はビザ取得が必要となります。</span> -->
<!-- 						</div> -->
<!-- 					</div> -->
					
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="apply_head"><label for="start_year"><span class="apply_chk_notes">*</span>留学開始年月</label></p>
						</div>
					</div>
					<div class="form-group form-inline row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<select name="start_year" class="form-control" id="start_year">
								<option value="">▼ 年</option>
								<option value="<?php echo date("Y年")?>"><?php echo date("Y年")?></option>
								<option value="<?php echo date("Y年",strtotime("+1 year"));?>"><?php echo date("Y年",strtotime("+1 year"));?></option>
							</select>
							<select name="start_month" class="form-control" id="start_month">
								<option value="">▼ 月</option>
								<option value="1月">1月</option>
								<option value="2月">2月</option>
								<option value="3月">3月</option>
								<option value="4月">4月</option>
								<option value="5月">5月</option>
								<option value="6月">6月</option>
								<option value="7月">7月</option>
								<option value="8月">8月</option>
								<option value="9月">9月</option>
								<option value="10月">10月</option>
								<option value="11月">11月</option>
								<option value="12月">12月</option>
							</select>
						</div>
					</div>
					<div class="row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<p class="apply_head"><label for="period"><span class="apply_chk_notes">*</span>留学期間</label></p>
						</div>
					</div>
					<div class="form-group row mgnB8">
						<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
							<select id="period" name="period" class="form-control">
								<option value="">▼ 期間</option>
<?php
	if(empty($course)){
		foreach ($engp_master['week'] as $key => &$val) {
			if($key == 2){continue;}
			echo "<option value='".$val."'>".$val."</option>".PHP_EOL;
		}
// 		echo "<option value='スペシャルオファー (割引)1'>スペシャルオファー (割引)1</option>".PHP_EOL;
// 		echo "<option value='スペシャルオファー (割引)2'>スペシャルオファー (割引)2</option>".PHP_EOL;
// 		echo "<option value='スペシャルオファー (割引)3'>スペシャルオファー (割引)3</option>".PHP_EOL;		
// 		echo "<option value='スペシャルオファー (割引)4'>スペシャルオファー (割引)4</option>".PHP_EOL;
	}
	else{
		$select_course = "tuition_4w_".$course;
		if(!empty($get_meta->$select_course)){
			if($period == "4"){echo "<option value='4週間（およそ1ヶ月）' selected>4週間（およそ1ヶ月）</option>".PHP_EOL;}else{echo "<option value='4週間（およそ1ヶ月）'>4週間（およそ1ヶ月）</option>".PHP_EOL;}
		}
		$select_course = "tuition_8w_".$course;
		if($get_meta->$select_course){
			if($period == "8"){echo "<option value='8週間（およそ2ヶ月）' selected>8週間（およそ2ヶ月）</option>".PHP_EOL;}else{echo "<option value='8週間（およそ2ヶ月）'>8週間（およそ2ヶ月）</option>".PHP_EOL;}
		}
		$select_course = "tuition_12w_".$course;		
		if($get_meta->$select_course){
			if($period == "12"){echo "<option value='12週間（およそ3ヶ月）' selected>12週間（およそ3ヶ月）</option>".PHP_EOL;}else{echo "<option value='12週間（およそ3ヶ月）'>12週間（およそ3ヶ月）</option>".PHP_EOL;}
		}
		$select_course = "tuition_16w_".$course;		
		if($get_meta->$select_course){
			if($period == "16"){echo "<option value='16週間（およそ4ヶ月）' selected>16週間（およそ4ヶ月）</option>".PHP_EOL;}else{echo "<option value='16週間（およそ4ヶ月）'>16週間（およそ4ヶ月）</option>".PHP_EOL;}
		}
		$select_course = "tuition_24w_".$course;		
		if($get_meta->$select_course){
			if($period == "24"){echo "<option value='24週間（およそ6ヶ月）' selected>24週間（およそ6ヶ月）</option>".PHP_EOL;}else{echo "<option value='24週間（およそ6ヶ月）'>24週間（およそ6ヶ月）</option>".PHP_EOL;}
		}
		$select_course = "tuition_36w_".$course;		
		if($get_meta->$select_course){
			if($period == "36"){echo "<option value='36週間（およそ9ヶ月）' selected>36週間（およそ9ヶ月）</option>".PHP_EOL;}else{echo "<option value='36週間（およそ9ヶ月）'>36週間（およそ9ヶ月）</option>".PHP_EOL;}
		}
		$select_course = "tuition_48w_".$course;
		if($get_meta->$select_course){
			if($period == "48"){echo "<option value='48週間（およそ12ヶ月）' selected>48週間（およそ12ヶ月）</option>".PHP_EOL;}else{echo "<option value='48週間（およそ12ヶ月）'>48週間（およそ12ヶ月）</option>".PHP_EOL;}
		}
// 		if($get_meta->tuition_2w_pt || $get_meta->tuition_2w_ft){if($period == "2"){echo "<option value='2週間' selected>2週間</option>".PHP_EOL;}else{echo "<option value='2週間'>2週間</option>".PHP_EOL;}}	
// 		if($period == "4"){echo "<option value='4週間(およそ1ヶ月)' selected>4週間(およそ1ヶ月)</option>".PHP_EOL;}else{echo "<option value='4週間(およそ1ヶ月)'>4週間(およそ1ヶ月)</option>".PHP_EOL;}		
// 		if($period == "8"){echo "<option value='8週間(およそ2ヶ月)' selected>8週間(およそ2ヶ月)</option>".PHP_EOL;}else{echo "<option value='8週間(およそ2ヶ月)'>8週間(およそ2ヶ月)</option>".PHP_EOL;}
// 		if($period == "12"){echo "<option value='12週間(およそ3ヶ月)' selected>12週間(およそ3ヶ月)</option>".PHP_EOL;}else{echo "<option value='12週間(およそ3ヶ月)'>12週間(およそ3ヶ月)</option>".PHP_EOL;}
// 		if($period == "16"){echo "<option value='16週間(およそ4ヶ月)' selected>16週間(およそ4ヶ月)</option>".PHP_EOL;}else{echo "<option value='16週間(およそ4ヶ月)'>16週間(およそ4ヶ月)</option>".PHP_EOL;}
// 		if($period == "24"){echo "<option value='24週間(およそ6ヶ月)' selected>24週間(およそ6ヶ月)</option>".PHP_EOL;}else{echo "<option value='24週間(およそ6ヶ月)'>24週間(およそ6ヶ月)</option>".PHP_EOL;}
// 		if($period == "36"){echo "<option value='36週間(およそ9ヶ月)' selected>36週間(およそ9ヶ月)</option>".PHP_EOL;}else{echo "<option value='36週間(およそ9ヶ月)'>36週間(およそ9ヶ月)</option>".PHP_EOL;}
// 		if($period == "48"){echo "<option value='48週間(およそ12ヶ月)' selected>48週間(およそ12ヶ月)</option>".PHP_EOL;}else{echo "<option value='48週間(およそ12ヶ月)'>48週間(およそ12ヶ月)</option>".PHP_EOL;}
// 		if($get_meta->so1_pt_offer || $get_meta->so1_ft_offer){if($period == "so1"){echo "<option value='スペシャルオファー (割引)1' selected>スペシャルオファー (割引)1</option>".PHP_EOL;}else{echo "<option value='スペシャルオファー (割引)1'>スペシャルオファー (割引)1</option>".PHP_EOL;}}
// 		if($get_meta->so2_pt_offer || $get_meta->so2_ft_offer){if($period == "so2"){echo "<option value='スペシャルオファー (割引)2' selected>スペシャルオファー (割引)2</option>".PHP_EOL;}else{echo "<option value='スペシャルオファー (割引)2'>スペシャルオファー (割引)2</option>".PHP_EOL;}}
// 		if($get_meta->so3_pt_offer || $get_meta->so3_ft_offer){if($period == "so3"){echo "<option value='スペシャルオファー (割引)3' selected>スペシャルオファー (割引)3</option>".PHP_EOL;}else{echo "<option value='スペシャルオファー (割引)3'>スペシャルオファー (割引)3</option>".PHP_EOL;}}
// 		if($get_meta->so4_pt_offer || $get_meta->so4_ft_offer){if($period == "so4"){echo "<option value='スペシャルオファー(割引) 4' selected>スペシャルオファー(割引) 4</option>".PHP_EOL;}else{echo "<option value='スペシャルオファー(割引) 4'>スペシャルオファー(割引) 4</option>".PHP_EOL;}}
	}
?>							</select>
							</div>
						</div>
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="apply_head"><label for="accommodation"><span class="apply_chk_notes">*</span>滞在先</label></p>
							</div>
						</div>
						<div class="form-group row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<select id="stay_type" name="stay_type" class="form-control">
									<option value = "">▼滞在先</option>
									<option value="ホームステイ(1人部屋)" <?php if($stay == 1){echo "selected";}?>>ホームステイ(1人部屋)</option>
									<option value="学生寮(1人部屋)" <?php if($stay == 2){echo "selected";}?>>学生寮(1人部屋)</option>
									<option value="学生寮(2人部屋)" <?php if($stay == 3){echo "selected";}?>>学生寮(2人部屋)</option>												
									<option value="学生寮(3人部屋)" <?php if($stay == 4){echo "selected";}?>>学生寮(3人部屋)</option>																								
									<option value="学生寮(4人部屋)" <?php if($stay == 5){echo "selected";}?>>学生寮(4人部屋)</option>
									<option value="自分で手配する" <?php if($stay == 6){echo "selected";}?>>自分で手配する</option>																																																
								</select>
							</div>
						</div>
						
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="apply_head"><label for="accommodation"><span class="apply_chk_notes">*</span>滞在先の手配期間</label></p>
							</div>
						</div>
						<div class="form-group row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<select name="arrange_period" class="form-control <?php if($stay == "6"){echo "select_invalid";}?>"  id="arrange_period">
									<option value = "">▼滞在先の手配期間</option>
									<?php if($period != 2):?>
										<option value="最初の4週間のみ手配を依頼" <?php if($arrange_period == "1"){echo "selected";}?>>最初の4週間のみ手配を依頼</option>
									<?php endif;?>
									<?php if($period != 2 && $period != 4):?>
										<option value="最初の8週間のみ手配を依頼" <?php if($arrange_period == "2"){echo "selected";}?>>最初の8週間のみ手配を依頼</option>
									<?php endif;?>				
									<option value="留学期間中すべて手配を依頼" <?php if($arrange_period == "3"){echo "selected";}?>>留学期間中すべて手配を依頼</option>																																			
								</select>
							</div>
						</div>
						
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<h2 class="apply_box">ご本人様情報</h2>
							</div>
						</div>
	
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="apply_head"><label for="last_name"><span class="apply_chk_notes">*</span>お名前（漢字）</label></p>
							</div>
						</div>
						<div class="form-group form-inline row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<div class="col-xs-6"><input name="last_name" placeholder="姓" class="form-control" type="text" value="" style="width:100%;" /></div>
								<div class="col-xs-6"><input name="first_name" placeholder="名" class="form-control" type="text" value="" style="width:100%;" /></div>
							</div>
						</div>
	
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="apply_head"><label for="last_name_kana"><span class="apply_chk_notes">*</span>お名前（ふりがな）</label></p>
							</div>
						</div>
						<div class="form-group form-inline row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<div class="col-xs-6"><input name="last_name_kana" placeholder="姓(ふりがな)" class="form-control" type="text" value="" style="width:100%;" /></div>
								<div class="col-xs-6"><input name="first_name_kana" placeholder="名(ふりがな)" class="form-control" type="text" value="" style="width:100%;" /></div>
							</div>
						</div>
	
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="apply_head"><label for="email"><span class="apply_chk_notes">*</span>Eメールアドレス</label></p>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<input name="email" class="form-control" size="40" value="<?php echo ($user_data->email)?>" type="text">
							</div>
						</div>
	
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="apply_head" style="width:50%;"><label for="tel1"><span class="apply_chk_notes">*</span>電話番号</label></p>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<input name="tel" type="text" class="form-control" value="" maxlength="12"/>
							</div>
						</div>
	
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="apply_head"><label for="postal"><span class="apply_chk_notes">*</span>郵便番号</label></p>
							</div>
						</div>
						<div class="form-group form-inline row">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								〒<input name="postal" placeholder="例:1001011" maxlength="7" class="form-control" type="text" value="" style="width:50%" />
							</div>
						</div>
	
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="apply_head"><label for="prefecture"><span class="apply_chk_notes">*</span>都道府県</label></p>
							</div>
						</div>
						<div class="form-group form-inline row">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<select name="prefecture" class="form-control" id="Prefecture">
									<option value="">▼ 都道府県</option>
									<option value="北海道">北海道</option>
									<option value="青森県">青森県</option>
									<option value="岩手県">岩手県</option>
									<option value="宮城県">宮城県</option>
									<option value="秋田県">秋田県</option>
									<option value="山形県">山形県</option>
									<option value="福島県">福島県</option>
									<option value="茨城県">茨城県</option>
									<option value="栃木県">栃木県</option>
									<option value="群馬県">群馬県</option>
									<option value="埼玉県">埼玉県</option>
									<option value="千葉県">千葉県</option>
									<option value="東京都">東京都</option>
									<option value="神奈川県">神奈川県</option>
									<option value="新潟県">新潟県</option>
									<option value="富山県">富山県</option>
									<option value="石川県">石川県</option>
									<option value="福井県">福井県</option>
									<option value="山梨県">山梨県</option>
									<option value="長野県">長野県</option>
									<option value="岐阜県">岐阜県</option>
									<option value="静岡県">静岡県</option>
									<option value="愛知県">愛知県</option>
									<option value="三重県">三重県</option>
									<option value="滋賀県">滋賀県</option>
									<option value="京都府">京都府</option>
									<option value="大阪府">大阪府</option>
									<option value="兵庫県">兵庫県</option>
									<option value="奈良県">奈良県</option>
									<option value="和歌山県">和歌山県</option>
									<option value="鳥取県">鳥取県</option>
									<option value="島根県">島根県</option>
									<option value="岡山県">岡山県</option>
									<option value="広島県">広島県</option>
									<option value="山口県">山口県</option>
									<option value="徳島県">徳島県</option>
									<option value="香川県">香川県</option>
									<option value="愛媛県">愛媛県</option>
									<option value="高知県">高知県</option>
									<option value="福岡県">福岡県</option>
									<option value="佐賀県">佐賀県</option>
									<option value="長崎県">長崎県</option>
									<option value="熊本県">熊本県</option>
									<option value="大分県">大分県</option>
									<option value="宮崎県">宮崎県</option>
									<option value="鹿児島県">鹿児島県</option>
									<option value="沖縄県">沖縄県</option>
								</select>
							</div>
						</div>
	
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="apply_head"><label for="address"><span class="apply_chk_notes">*</span>ご住所</label></p>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<input name="address" class="form-control" value="" type="text">
							</div>
						</div>
	
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="apply_head"><label for="build">建物名</label></p>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<input name="build" class="form-control" value="" type="text">
							</div>
						</div>
						
						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<h2 class="apply_box2">レビュー投稿キャペーン</h2>
								<p class="campaign">あなたの留学する学校のレビューをご投稿下さい！<br>
								投稿はわずか3分程度。<br>あなたの留学費用がその場で3000円割引になります！</p>
								<label class='checkbox chkbox'><input type='checkbox' name="campaign" value="参加する">キャンペーンに参加する</label>							
							</div>
						</div>

						<div class="row mgnB8">
							<div class="col-md-offset-2 col-md-8 col-xs-12 col-sm-12">
								<p class="clause">
									<label class='checkbox chkbox'><input type='checkbox' name="clause" value="約款に同意する"><a href="<?php echo home_url();?>/terms" target="_blank">約款</a>に同意する</label>							
							</div>
						</div>
						
	
				
					<div id="apply_confirm">
						<input type="submit" value="" alt="入力内容の確認" id="btn_apply_next">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- End:コンテンツ -->
<?php get_footer(); ?>
<script src="<?php echo esc_url( get_template_directory_uri() . '/js/apply.js' ); ?>"></script>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
