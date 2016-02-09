<?php
/*
Template Name: 検索結果
*/
get_header();
// 検索パラメータをセッションに保存
$_SESSION['page'] = $_GET['page'];
// $_SESSION['purpose'] = $_GET['purpose'];
$_SESSION['school_name'] = $_GET['school_name'];
$_SESSION['fee'] = $_GET['fee'];
$_SESSION['course'] = $_GET['course'];
$_SESSION['sp_offer'] = $_GET['sp_offer'];
$_SESSION['location'] = $_GET['location'];
$_SESSION['how_to_go'] = $_GET['how_to_go'];
$_SESSION['location_type'] = $_GET['location_type'];
$_SESSION['nationality'] = $_GET['nationality'];
$_SESSION['security'] = $_GET['security'];
$_SESSION['local_staff'] = $_GET['local_staff'];
$_SESSION['facilities'] = $_GET['facilities'];
$_SESSION['division'] = $_GET['division'];
$_SESSION['sort'] = $_GET['sort'];

$engp_master = engp_get_master();
$search_columns = array(
	'page'=>$_GET['page'],
// 	'purpose'=>$_GET['purpose'],
	'school_name'=>$_GET['school_name'],
	'fee'=>$_GET['fee'],
	'course'=>$_GET['course'],
	'sp_offer'=>$_GET['sp_offer'],
	'location'=>$_GET['location'],
	'how_to_go'=>$_GET['how_to_go'],
	'location_type'=>$_GET['location_type'],
	'nationality'=>$_GET['nationality'],
	'security'=>$_GET['security'],
	'local_staff'=>$_GET['local_staff'],
	'facilities'=>$_GET['facilities'],
	'division'=>$_GET['division'],
	'sort'=>$_GET['sort'],
);
$ID = engp_get_id($_COOKIE['gu_id']);
$get_meta = engp_school_search($search_columns, $ID);
$data_count = $get_meta[count];
unset($get_meta[count]);
?>

<link rel="stylesheet" type="text/css" href="<?php echo esc_url(get_template_directory_uri() . '/css/reset.css' ); ?>" media="all" />
<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/css/detail-style.css' ); ?>"/>
<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/css/modal.css' ); ?>"/>

<div id="hr"></div>
<div id="primary" class="content-area">
<div id="main" class="site-main" role="main">

	<div class="container">
		<div class="row">
			<!-- left side -->
			<div class="col-md-3">
				<!-- Start: shcool_search -->
				<div id="shcool_search">
					<div class="form-group">
					<form name="sidesearch" method="get" id="searchform" action="<?php bloginfo('url'); ?>">
						<input type="hidden" name="s" id="s" placeholder="検索" />
						<input type="hidden" name="page" id="page" value="1" />
						<h1>学校を探す</h1>

						<h3>学校名から探す</h3>
						<input type="text" class="form-control" name="school_name" id="school_name" placeholder="入力して下さい" <?php if($search_columns['school_name']){ echo "value='".esc_attr($search_columns['school_name'])."'";}?>"  style="cursor:text;">

<!-- 						<h3>エリアから探す</h3> -->
<!-- 						<select class="form-control s_select" name="division" id="division"> -->
<!-- 							<option value="">選択して下さい</option> -->
<?php
// 	foreach ($engp_master['division'] as $key => &$val) {
// 		if ($key==$search_columns['division']) {
// 			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
// 		}
// 		else{
// 			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
// 		}
// 	}
?>
<!-- 						</select> -->
<!-- 						<h3>目的から探す</h3> -->
<!-- 						<select class="form-control s_select" name="purpose" id="purpose"> -->
<!-- 							<option value="">選択して下さい</option> -->
 <?php
// 	foreach ($engp_master['purpose'] as $key => &$val) {
// 		if ($key==$search_columns['purpose']) {
// 			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
// 		}
// 		else{
// 			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
// 		}
// 	}
 ?>
<!-- 						</select> -->
						<h3>学費で探す(1ヶ月あたり)</h3>
						<select class="form-control s_select" name="fee" id="fee">
							<option value="">選択して下さい</option>
<?php
	foreach ($engp_master['tuition'] as $key => &$val) {
		if ($key==$search_columns['fee']) {
			echo "<option value='".$key."' selected>".$val."</option>".PHP_EOL;
		}
		else{
			echo "<option value='".$key."'>".$val."</option>".PHP_EOL;
		}
	}
?>
						</select>
						<div id="search_right_button" class="f_right">
							<input type="submit" value="" style="background-image: url(<?php echo esc_url(get_template_directory_uri()); ?>/images/search_button.png); width:94px; height:47px; background-size: 94px 47px" />
						</div>
					</div>
						<div class="clear"></div>
					</div>
					<!-- End: school_search -->

					<div id="detail_search_title">
						<h1 class="f_left">条件で絞り込む</h1>
						<h2 class="f_right"><a href="javascript:void(0)" id="search_param_del">リセット</a></h2>
						<div class="clear"></div>
					</div>

					<!-- Start: detail_search -->
					<div id="detail_search">
						<dl id="acMenu" class="start">
							<dt <?php if($search_columns['course'] || $search_columns['sp_offer']
										 || ((strpos($_SERVER['HTTP_USER_AGENT'], "iPhone")) == false && (strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) == false && (strpos($_SERVER['HTTP_USER_AGENT'], "iPad") == false && (strpos($_SERVER['HTTP_USER_AGENT'], "Android")) == false )))
										{echo 'class="active"';} ?> >
								<h3>コース</h3>
							</dt>
							<dd <?php if($search_columns['course'] || $search_columns['sp_offer']
										 || ((strpos($_SERVER['HTTP_USER_AGENT'], "iPhone")) == false && (strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) == false && (strpos($_SERVER['HTTP_USER_AGENT'], "iPad") == false && (strpos($_SERVER['HTTP_USER_AGENT'], "Android")) == false )))
										{echo 'style="display: block;"';} ?> class="mgnB16">
								<!--
								<label><input name="course[]" type="checkbox" value="ESL" <?php if(in_array("ESL",$search_columns['course'])){echo "checked";} ?> /><span>ESL</span></label>
								<br />
								-->
								<label><input name="course[]" type="checkbox" value="TOEFL" <?php if(in_array("TOEFL",$search_columns['course'])){echo "checked";} ?> /><span>TOEFL</span></label>
								<br />
								<label><input name="course[]" type="checkbox" value="TOEIC" <?php if(in_array("TOEIC",$search_columns['course'])){echo "checked";} ?> /><span>TOEIC</span></label>
								<br />
								<!--
								<label><input name="course[]" type="checkbox" value="advance" <?php if(in_array("advance",$search_columns['course'])){echo "checked";} ?> /><span>進学</span></label>
								<br />
								-->
								<label><input name="course[]" type="checkbox" value="business" <?php if(in_array("business",$search_columns['course'])){echo "checked";} ?> /><span>ビジネス</span></label>
								<br />
								<!--
								<label><input name="course[]" type="checkbox" value="child" <?php if(in_array("child",$search_columns['course'])){echo "checked";} ?> /><span>子供(U12、U15等)</span></label>
								<br />
								<label><input name="course[]" type="checkbox" value="adult" <?php if(in_array("adult",$search_columns['course'])){echo "checked";} ?> /><span>アダルト（大人向け）</span></label>
								<br />
								<label><input name="course[]" type="checkbox" value="ILETS" <?php if(in_array("ILETS",$search_columns['course'])){echo "checked";} ?> /><span>ILETS</span></label>
								<br />
								<label><input name="sp_offer" type="checkbox" value="1" <?php if($search_columns['sp_offer']){echo "checked";} ?> /><span>スペシャルオファー(割引)</span></label>
								<br />
								-->
							</dd>
						</dl>
						<dl id="acMenu">
							<dt <?php if($search_columns['location'] || $search_columns['how_to_go'] || $search_columns['nationality'] || $search_columns['security'] || $search_columns['local_staff']
										 || ((strpos($_SERVER['HTTP_USER_AGENT'], "iPhone")) == false && (strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) == false && (strpos($_SERVER['HTTP_USER_AGENT'], "iPad") == false && (strpos($_SERVER['HTTP_USER_AGENT'], "Android")) == false )))
										{echo 'class="active"';}?> >
								<h3>環境</h3>
							</dt>
							<dd <?php if($search_columns['location'] || $search_columns['how_to_go'] || $search_columns['nationality'] || $search_columns['security'] || $search_columns['local_staff']
										|| ((strpos($_SERVER['HTTP_USER_AGENT'], "iPhone")) == false && (strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) == false && (strpos($_SERVER['HTTP_USER_AGENT'], "iPad") == false && (strpos($_SERVER['HTTP_USER_AGENT'], "Android")) == false )))
										{echo 'style="display: block;"';}?> class="mgnB16">
								<label>場所</label>
								<br />　
								<label><input name="location[]" type="checkbox" value="1" <?php if(in_array("1",$search_columns['location'])){echo "checked";} ?> /><span>セブ市内</span></label>
								<label><input name="location[]" type="checkbox" value="2,3,4,5,6,7" <?php if(in_array("2,3,4,5,6,7",$search_columns['location'])){echo "checked";} ?> /><span>セブ以外</span></label>
								<!--
								<input name="location[]" type="checkbox" value="3" <?php if(in_array("3",$search_columns['location'])){echo "checked";} ?> /><span>田舎</span>
								-->
								<br />
								<!--
								<label>交通手段</label>
								<br />　
								<input name="how_to_go[]" type="checkbox" value="1" <?php if(in_array("1",$search_columns['how_to_go'])){echo "checked";} ?> /><span>バス</span>
								<input name="how_to_go[]" type="checkbox" value="2" <?php if(in_array("2",$search_columns['how_to_go'])){echo "checked";} ?> /><span>車</span>
								<input name="how_to_go[]" type="checkbox" value="3" <?php if(in_array("3",$search_columns['how_to_go'])){echo "checked";} ?> /><span>電車</span>
								<br />
								-->
								<label><input name="location_type" type="checkbox" value="1" <?php if($search_columns['location_type']){echo "checked";} ?> /><span>大学敷地内</span></label>
								<br />
<!-- 								<label><input name="nationality" type="checkbox" value="1" <?php // if($search_columns['nationality']){echo "checked";} ?> /><span>国際性豊か</span></label>  -->
<!-- 								<br /> -->
								<label><input name="security" type="checkbox" value="5" <?php if($search_columns['security']){echo "checked";} ?> /><span>治安が良い</span></label>
<!-- 								<br /> -->
<!-- 								<label><input name="local_staff" type="checkbox" value="1" <?php // if($search_columns['local_staff']){echo "checked";} ?> /><span>現地サポートスタッフあり</span></label>  -->
							</dd>
						</dl>
						<!--
						<dl id="acMenu">
							<dt <?php if($search_columns['facilities']
										|| ((strpos($_SERVER['HTTP_USER_AGENT'], "iPhone")) == false && (strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) == false && (strpos($_SERVER['HTTP_USER_AGENT'], "iPad") == false && (strpos($_SERVER['HTTP_USER_AGENT'], "Android")) == false )))
										{echo 'class="active"';} ?> >
								<h3>設備</h3>
							</dt>
							<dd <?php if($search_columns['facilities']
										|| ((strpos($_SERVER['HTTP_USER_AGENT'], "iPhone")) == false && (strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) == false && (strpos($_SERVER['HTTP_USER_AGENT'], "iPad") == false && (strpos($_SERVER['HTTP_USER_AGENT'], "Android")) == false )))
										{echo 'style="display: block;"';} ?> class="mgnB16">
								<label><input name="facilities[]" type="checkbox" value="コンピュータルーム" <?php if(in_array("コンピュータルーム",$search_columns['facilities'])){echo "checked";} ?> /><span>コンピュータルーム</span></label>
								<br />
								<label><input name="facilities[]" type="checkbox" value="ワイヤレスインターネット利用" <?php if(in_array("ワイヤレスインターネット利用",$search_columns['facilities'])){echo "checked";} ?> /><span>ワイヤレスインターネット利用可</span></label>
								<br />
								<label><input name="facilities[]" type="checkbox" value="カウンセリングルーム" <?php if(in_array("カウンセリングルーム",$search_columns['facilities'])){echo "checked";} ?> /><span>カウンセリングルーム</span></label>
								<br />
								<label><input name ="facilities[]" type="checkbox" value="ジム" <?php if(in_array("ジム",$search_columns['facilities'])){echo "checked";} ?> /><span>ジム</span></label>
								<br />
								<label><input name="facilities[]" type="checkbox" value="図書館" <?php if(in_array("図書館",$search_columns['facilities'])){echo "checked";} ?> /><span>図書館</span></label>
							</dd>
						</dl>
						-->
						<div id="detail_search_button">
							<input type="submit" value="" style="background-image: url(<?php echo esc_url(get_template_directory_uri()); ?>/images/search_button_s.png); width:70px; height:30px; border: none; background-size: cover;" />
						</div>

					</div>
					<!-- End: detail_search -->
				</form>
				<div class="hidden-xs hidden-sm">
				<!-- HistoryModule -->
				<?php include(get_theme_root() . '/' . get_template() . "/inc/common-history.php");?>
				<!-- HistoryModule -->
				<a href="<?php echo esc_url(home_url());?>/introduction/"><img class="mgnT16" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner01.png" alt="バナー"></a><br />
				<a href="<?php echo esc_url(home_url());?>/posts_info/"><img class="mgnT16" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner02.png" alt="バナー"></a><br />
				<a href="<?php echo home_url(); ?>/cost_study/"><img class="mgnT16" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner03.png" alt="バナー"></a><br />
				<a href="<?php echo home_url(); ?>/study/"><img class="mgnT16" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner04.png" alt="バナー"></a><br />
				<a href="<?php echo home_url(); ?>/langageschool/"><img class="mgnT16" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner05.png" alt="バナー"></a>
                </div>
			</div>

			<!-- Start: right side -->
			<div class="col-md-9">
				<div id="search_right">
<?php if($search_columns['division']){?>
					<div class="mgnB16" id="division_box">
<?php 	switch ($search_columns['division']){
			case 1:
				$division_html .= '<img class="division_image mob_none" src="'.get_template_directory_uri().'/images/search_division_losangeles.png" alt="ロサンゼルス">';
				$division_html .= '<img class="division_image pc_none tab_none" src="'.get_template_directory_uri().'/images/search_division_losangeles02.png" alt="ロサンゼルス">';
				break;
			case 2:
				$division_html .= '<img class="division_image mob_none" src="'.get_template_directory_uri().'/images/search_division_newyork.png" alt="ニューヨーク">';
				$division_html .= '<img class="division_image pc_none tab_none" src="'.get_template_directory_uri().'/images/search_division_newyork02.png" alt="ニューヨーク">';
				break;
			case 3:
				$division_html .= '<img class="division_image mob_none" src="'.get_template_directory_uri().'/images/search_division_sanfrancisco.png" alt="サンフランシスコ">';
				$division_html .= '<img class="division_image pc_none tab_none" src="'.get_template_directory_uri().'/images/search_division_sanfrancisco02.png" alt="サンフランシスコ">';
				break;
			case 4:
				$division_html .= '<img class="division_image mob_none" src="'.get_template_directory_uri().'/images/search_division_boston.png" alt="ボストン">';
				$division_html .= '<img class="division_image pc_none tab_none" src="'.get_template_directory_uri().'/images/search_division_boston02.png" alt="ボストン">';
				break;
			case 5:
				$division_html .= '<img class="division_image mob_none" src="'.get_template_directory_uri().'/images/search_division_miami.png" alt="マイアミ">';
				$division_html .= '<img class="division_image pc_none tab_none" src="'.get_template_directory_uri().'/images/search_division_miami02.png" alt="マイアミ">';
				break;
			case 6:
				$division_html .= '<img class="division_image mob_none" src="'.get_template_directory_uri().'/images/search_division_hawaii.png" alt="ハワイ">';
				$division_html .= '<img class="division_image pc_none tab_none" src="'.get_template_directory_uri().'/images/search_division_hawaii02.png" alt="ハワイ">';
				break;
			case 7:
				$division_html .= '<img class="division_image mob_none" src="'.get_template_directory_uri().'/images/search_division_seattle.png" alt="シアトル">';
				$division_html .= '<img class="division_image pc_none tab_none" src="'.get_template_directory_uri().'/images/search_division_seattle02.png" alt="シアトル">';
				break;
			case 8:
				$division_html .= '<img class="division_imag mob_none" src="'.get_template_directory_uri().'/images/search_division_sandiego.png" alt="サンディエゴ">';
				$division_html .= '<img class="division_image pc_none tab_none" src="'.get_template_directory_uri().'/images/search_division_sandiego02.png" alt="サンディエゴ">';
				break;
			case 9:
				$division_html .= '<img class="division_image mob_none" src="'.get_template_directory_uri().'/images/search_division_chicago.png" alt="シカゴ">';
				$division_html .= '<img class="division_image pc_none tab_none" src="'.get_template_directory_uri().'/images/search_division_chicago02.png" alt="シカゴ">';
				break;
			case 10:
				$division_html .= '<img class="division_image mob_none" src="'.get_template_directory_uri().'/images/search_division_other.png" alt="その他">';
				$division_html .= '<img class="division_image pc_none tab_none" src="'.get_template_directory_uri().'/images/search_division_other02.png" alt="その他">';
				break;
		}
		echo $division_html;
		echo "</div>";
	}
 ?>
					<!-- Start: shcool_search -->
					<div id="search_result">
<?php
	$disp_data[]=null;
	if($search_columns['school_name']){
		$disp_data[] = esc_html($search_columns['school_name']);
	}
	if($search_columns['division']){
		$disp_data[] = $engp_master['division'][$search_columns['division']];
	}
// 	if($search_columns['purpose']){
// 		$disp_data[] = $engp_master['purpose'][$search_columns['purpose']];
// 	}

	if($search_columns['fee']){
		$disp_data[] = $engp_master['tuition'][$search_columns['fee']];
	}
	if($search_columns['course']){
		foreach ($search_columns['course'] as $val) {
			if($val == "advance"){
				$disp_data[] = "進学";
			}elseif($val == "business"){
				$disp_data[] = "ビジネス";
			}elseif($val == "child"){
				$disp_data[] = "子供(U12、U15等)";
			}elseif($val == "adult"){
				$disp_data[] = "アダルト(大人向け)";
			}else{
				$disp_data[] = $val;
			}
		}
	}
	if($search_columns['sp_offer']){
			$disp_data[] = "スペシャルオファー(割引)";
	}
	if($search_columns[location]){
		foreach ($search_columns[location] as $val) {
			if($val == "1"){
				$disp_data[] = $engp_master['location'][$val];
			}else if($val == "2,3,4,5,6,7"){
				$disp_data[] = "セブ以外";
			}
// 			$disp_data[] = $engp_master['location'][$val];
		}
	}
	if($search_columns[how_to_go]){
		foreach ($search_columns[how_to_go] as $val) {
			$disp_data[] = $engp_master['how_to_go'][$val];
		}
	}
	if($search_columns[nationality]){
		$disp_data[] = "国際性豊か";
	}
	if($search_columns[security]){
		$disp_data[] = "治安が良い";
	}
	if($search_columns[local_staff]){
		$disp_data[] = "現地サポートスタッフあり";
	}
	if($search_columns[facilities]){
		foreach ($search_columns[facilities] as $val) {
			$disp_data[] = $val;
		}
	}
	foreach ($disp_data as $key => &$val) {
		if ($search_data) {
			$search_data = $search_data.','.$val;
		}else{
			$search_data = $val;
		}
	}

	if ( ! empty( $get_meta ) ):
?>
						<h2>【 検索条件 】</h2><h2><?php if($search_data){echo $search_data;}else{echo "全ての学校を表示";} ?><br><span class="result_color mgnR8"><?php echo $data_count; ?></span>校が見つかりました
							<span class="mgnT8 mob_none" style="font-size: 80%;">
<?php
	$start = ($search_columns['page'] - 1) * 10 + 1;
	if( $search_columns['page'] * 10 > $data_count){
		$end = $data_count;
	}else{
		$end = $search_columns['page'] * 10;
	}
	echo "（".$search_columns['page']."ページ ".$start."-".$end."校を表示中)";
 ?>
						 	</span>
							<p class="pc_none tab_none" style="font-size: 80%;">
<?php
	$start = ($search_columns['page'] - 1) * 10 + 1;
	if( $search_columns['page'] * 10 > $data_count){
		$end = $data_count;
	}else{
		$end = $search_columns['page'] * 10;
	}
	echo "（".$search_columns['page']."ページ ".$start."-".$end."校を表示中)";
 ?>
						 	</p>

						 </h2>
						<div class="clear"></div>
					</div>
					<!-- End: school_search -->

<?php
	if( (strpos($_SERVER['HTTP_USER_AGENT'], "iPhone")) == false and
		(strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) == false and
		(strpos($_SERVER['HTTP_USER_AGENT'], "iPad")) == false and
		(strpos($_SERVER['HTTP_USER_AGENT'], "Android")) == false ) {
?>
					<!-- Start: check_navi -->
					<div id="check_navi" class="hidden-xs hidden-sm">
						<ul>
							<li>
<!-- 								<p class="mgnL8 padL8 f_left">チェックした学校を</p> -->
								<a href="javascript:void(0);"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/compare2.png" onclick="myCheck()" class="f_left btn_compare" alt="比較する"></a>
								<?php
									//ソートURL作成
									$sort_url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
									if($search_columns["sort"]){
										$sort_url = strstr($sort_url, "&sort=", TRUE);
									}
									$cost_url = $sort_url."&sort=cost";
									$review_url = $sort_url."&sort=review";
									$satisfaction_url = $sort_url."&sort=satisfaction";
								?>
								<img class="mgnL16 padL8 f_left mgnT5" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sort.png" class="f_left" alt="並び順" style="width:58px;">
								<a href="<?php echo $cost_url; ?>"><img class="btn_sort1" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sort_cost<?php if($search_columns["sort"] == "cost"){echo "_on";} ?>.png" class="f_left" alt="安い順"></a>
								<!--
								<a href="<?php echo $review_url; ?>"><img class="btn_sort"  src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sort_review<?php if($search_columns["sort"] == "review"){echo "_on";} ?>.png" class="f_left" alt="レビュー数順"></a>
								-->
								<a href="<?php echo $satisfaction_url; ?>"><img class="btn_sort2" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sort_satisfaction<?php if($search_columns["sort"] == "satisfaction"){echo "_on";} ?>.png" class="f_left" alt="満足度順"></a>
								<form method="get" action="<?php echo home_url(); ?>/compare" name="compare">
									<input type="hidden" id="cmpid" name="cmpid" value="">
								</form>
							</li>
						</ul>
						<div class="clear"></div>
					</div>
					<!-- End: check_navi -->
<?php }else{ ?>
					<!-- Start: check_navi_mob -->
					<div id="check_navi" class="hidden-lg">
						<ul>
							<li>
								<?php
									//ソートURL作成
									$sort_url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
									if($search_columns["sort"]){
										$sort_url = strstr($sort_url, "&sort=", TRUE);
									}
									$cost_url = $sort_url."&sort=cost";
									$review_url = $sort_url."&sort=review";
									$satisfaction_url = $sort_url."&sort=satisfaction";
								?>
								<a href="<?php echo $cost_url; ?>"><img class="btn_sort1" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sort_cost<?php if($search_columns["sort"] == "cost"){echo "_on";} ?>.png" class="f_left" alt="安い順"></a>
								<a href="<?php echo $satisfaction_url; ?>"><img class="btn_sort2" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sort_satisfaction<?php if($search_columns["sort"] == "satisfaction"){echo "_on";} ?>.png" class="f_left" alt="満足度順"></a>
																<form method="get" action="<?php echo home_url(); ?>/compare" name="compare">
									<input type="hidden" id="cmpid" name="cmpid" value="">
								</form>
							</li>
						</ul>
						<div class="clear"></div>
					</div>
					<!-- End: check_navi_mob -->

					<!-- Start: result_school_box -->
					<div id="result_school_box">
						<!-- Start: school_box -->
<?php
	}

	foreach ($get_meta as $data):
?>
						<div id="school_box" class="d_table">
							<div class="row">
								<div class="col-md-4">
<?php
	if( (strpos($_SERVER['HTTP_USER_AGENT'], "iPhone")) == false and
		(strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) == false and
		(strpos($_SERVER['HTTP_USER_AGENT'], "iPad")) == false and
		(strpos($_SERVER['HTTP_USER_AGENT'], "Android")) == false ) :
?>
									<div id="check_box" class="checkbox d_tablecell"><input name="post_check[]" class="check-child" type="checkbox" value=<?php echo $data->post_id; ?> /></div>
<?php else: ?>
									<div id="check_box" class="checkbox d_tablecell"></div>
<?php
		endif;

		$imagePostId = get_post_meta($data->post_id, 'my_upload_images', true );
		if(!empty($imagePostId[0])):
			$schoolImage = wp_get_attachment_image_src($imagePostId[0], array(182, 182));
?>
									<div id="school_img" class="d_tablecell"><img style="width: 182px; height: 182px;" src="<?php echo $schoolImage[0]; ?>" alt="<?php echo $data->school_name; ?>"></div>
<?php else:?>
									<div id="school_img" class="d_tablecell"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/nophoto_182x182.jpg" alt="<?php echo $data->school_name; ?>"></div>
<?php endif; ?>
								</div>
								<!-- Start: school_info -->
								<div class="col-md-4" style="padding-left:0px;">
									<div id="school_info" class="d_tablecell">
										<a href="<?php echo home_url(); ?>?school=<?php echo $data->post_id; ?>"><h1 class="f_left"><?php echo $data->school_name; ?></h1></a>
										<div class="clear"></div>
										<p><?php echo $data->city; ?></p>
										<p class="address"><?php echo $data->address; ?></p>
<?php
	$outputHtml = '';
	if($data->target_ESL){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_esl.png" alt="ESL">';
	}
	if($data->target_TOEFL){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_toefl.png" alt="TOEFL">';
	}
	if($data->target_TOEIC){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_toeic.png" alt="TOEIC">';
	}
	if($data->target_advance){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_advance.png" alt="advance">';
	}
	if($data->target_business){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_business.png" alt="business">';
	}
	if($data->target_child){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_child.png" alt="child">';
	}
	if($data->target_adult){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_adult.png" alt="adult">';
	}
	if($data->target_ILETS){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_ilets.png" alt="ILETS">';
	}
	if($data->target_so){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_sp_offer.png" alt="sp_offer">';
	}
	echo $outputHtml;
?>
									</div>
								</div>
								<!-- End: school_info -->

								<!-- Start: review -->
								<div class="col-md-4">
									<div id="review" class="d_tablecell">
										<!-- Start: reviewbox -->
										<div id="reviewbox">
											<!-- Start: reviewyes -->
											<div id="reviewyes">
<?php
	$review_data = engp_get_review_star($data->post_id, STAR_MIDDLE);
	if($review_data['review_sum'] == 0):
?>
											<h4 class="search_title_rev">レビューの数 <span class="result_color">-</span></h4>
											<p>留学生の満足度　<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/<?php echo $review_data['img_file'] ?>"> </p>
<?php else:?>
											<h4 class="search_title_rev">レビューの数 <span class="result_color"><?php echo $review_data['review_sum'] ?></span></h4>
											<p>留学生の満足度　<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/<?php echo $review_data['img_file'] ?>"> </p>
											<p class="link_sankaku mgnB8"><a href="<?php echo home_url(); ?>?school=<?php echo $data->post_id; ?>&review">評価を見る</a></p>
<?php endif; ?>
											</div>
											<!-- End: reviewyes -->
											<!-- Start: reviewno -->
											<div id="reviewno">
												<p>4週間（およそ1ヶ月）の授業料</p>
												<h2>
<?php
// 		$min = $data->tuition_4w_pt;
// 		$max = $data->tuition_4w_ft;
		$tuition = $data->tuition;
		if($data->viewtype_yen == 0){
			$moneyHead = "$";
		}else{
			$moneyHead = "&yen;";
		}

// 		if(!empty($min) && !empty($max)){
// 			echo $moneyHead.number_format($min)." 〜 ".$moneyHead.number_format($max);
// 		}elseif(!empty($min) && empty($max)){
// 			echo $moneyHead.number_format($min);
// 		}elseif(empty($min) && !empty($max)){
// 			echo $moneyHead.number_format($max);
// 		}else{
// 			echo "－";
// 		}
// 		if(!empty($min)){
// 			echo $moneyHead.number_format($min)." 〜 ";
// 		}else if(!empty($max)){
// 			echo $moneyHead.number_format($max)." 〜 (全日制)";
// 			echo $moneyHead.number_format($max)." 〜 ";			
// 		}else{
// 			echo "－";
// 		}
		if(!empty($tuition)){
			echo $moneyHead.number_format($tuition)."〜";
		}else{
			echo "－";
		}
?>
												</h2>
												<a href="<?php echo home_url(); ?>/estimate?estid=<?php echo $data->post_id; ?>"><img class="mgnR16 mgnT5" style="width:120px; height:28px;" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_estimate.png" alt="見積もり"></a>

												<!-- Start: favorite -->
												<input id="hiddenID" type="hidden" value="<?php echo $data->post_id ?>" />
												<input id="hiddenUserID" type="hidden" value="<?php echo $ID ?>" />
												<input id="hiddenShape" type="hidden" value="circle" />
												<span class="sear_ico_favorite">
													<div id ="favorite<?php echo $data->post_id ?>">
<?php if(empty($ID)){ ?>
														<div id="modal-content">
															<p class="modal_shut"><a id="modal-close"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/delete.png" alt="閉じる"></a></p>
															<p class="modal_title">ユーザー登録(無料)をしてください！</p>
															<div class="modal_button"><a href="<?php echo home_url(); ?>/regist">ご登録はこちらから</a></div>
															<p class="modal_login">登録済の方は<a href="<?php echo home_url(); ?>/login">ログイン</a>してください。</p>
															<p class="modal_text">ユーザー登録をするとお気に入りの学校を保存しておくことができます！</p>
														</div>
														<p><a id="modal-open" class="button-link"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/favorite_add_circle.png" alt="お気に入り"></a></p>
<?php }
	else{
		if($data->favorite=='1'){
			echo "<a href='javascript:void(0)' onclick='javaScript:favorite(2,$data->post_id)'><img src='" . esc_url(get_template_directory_uri()) . "/images/favorite_remove_circle.png' alt='お気に入り解除'></a>";
		}else {
			echo "<a href='javascript:void(0)' onclick='javaScript:favorite(1,$data->post_id)'><img src='" . esc_url(get_template_directory_uri()) . "/images/favorite_add_circle.png' alt='お気に入り追加'></a>";
		}
	}
?>
													</div>
												</span>
												<!-- End: favorite  -->
											</div>
											<!-- End: reviewno -->
										</div>
										<!-- End: reviewbox -->
									</div>
								</div>
								<!-- End: review -->
							</div>
						</div>
<?php endforeach; ?>
					</div>
					<!-- End: school_box -->

					<!-- Start:search_result_pager -->
					<p class="p_ccc2"><?php echo $data_count."校中 ".$search_columns[page]."ページ目 ".$start."-".$end."校を表示中"; ?></p>
					<div id="search_result_pager" class="f_left">
						<p class="f_left p_ccc">
<?php
	if($data_count < 10){
		$maxpage = 1;
	}else if(($data_count % 10) == 0){
		$maxpage = $data_count / 10;
	} else {
		$maxpage = ($data_count - ($data_count % 10)) / 10 + 1;
	}
	echo $search_columns[page] . "/" . $maxpage . "ページ";
?>
						</p>
						<div id="search_result_pager_navi" class="f_right">
							<ul>
								<li class="mgnR8">
<?php
	//ページャー作成
	$servername = $_SERVER["SERVER_NAME"];
	$url = "//".$servername.$_SERVER['REQUEST_URI'];
	$current_page = "page=".$search_columns[page];

	if($search_columns[page] != "1"){
		$back_page = $search_columns[page]-1;
		$back_url = str_replace($current_page, "page=".$back_page, $url);
		echo "<a href=\"".$back_url."\">< 前へ</a>";
	}else{
		echo "< 前へ";
	}
?>
								</li>
<?php

// 	if($search_columns['page'] >=3 AND $maxpage > 3){
// 		if($maxpage - 1 == $search_columns['page']){
// 			$start_page = $search_columns['page'] - 3;
// 		}else if($maxpage == $search_columns['page']){
// 			$start_page = $search_columns['page'] - 4;
// 		}else{
// 			$start_page = $search_columns['page'] - 2;
// 		}
// 	}else{
// 		$start_page = 1;
// 	}


	if($search_columns['page'] >=5 AND $maxpage > 5){
		if($maxpage - 1 == $search_columns['page']){
			$start_page = $search_columns['page'] - 7;
		}else if($maxpage - 2 == $search_columns['page']){
			$start_page = $search_columns['page'] - 6;
		}else if($maxpage - 3 == $search_columns['page']){
			$start_page = $search_columns['page'] - 5;
		}else if($maxpage == $search_columns['page']){
			$start_page = $search_columns['page'] - 8;
		}else{
			$start_page = $search_columns['page'] - 4;
		}
	}else{
		$start_page = 1;
	}
	
	for ($i = $start_page ; $i <= $maxpage && $i <= $start_page + 8; $i++) {
		$new_page = "page=".$i;
		$new_url = str_replace($current_page, $new_page, $url);
		if($search_columns[page] == $i){
			echo "<li class=\"mob_none\"><span class=\"p_ccc\">".$i."</span></li>";
		}else{
			echo "<li class=\"mob_none\"><a href=\"".$new_url."\">".$i."</a></li>";
		}
	}
	
	
// 	for ($i = 1 ; $i <= $maxpage && $i <= 10; $i++) {
// 		$new_page = "page=".$i;
// 		$new_url = str_replace($current_page, $new_page, $url);
// 		if($search_columns[page] == $i){
// 			echo "<li class=\"mob_none\"><span class=\"p_ccc\">".$i."</span></li>";
// 		}else{
// 			echo "<li class=\"mob_none\"><a href=\"".$new_url."\">".$i."</a></li>";
// 		}
// 	}

	if($search_columns[page] != $maxpage){
		$next_page = $search_columns[page]+1;
		$new_url = str_replace($current_page, "page=".$next_page, $url);
		echo "<li class=\"mgnL8\"><a href=\"".$new_url."\">次へ ></a></li>";
	}else{
		echo "<li class=\"mgnL8\">次へ ></li>";
	}
?>
							</ul>
						</div>
					</div>
				<!-- End:search_result_pager -->
				</div>

		<!-- Start: bannar -->
		<div id="info_banner" class="tab_none pc_none">
			<div class="row">
				<div class="col-sm-4 col-xs-4 mob_top_banner_right">
					<a href="<?php echo esc_url(home_url());?>/introduction/">
						<img class="mgnT20" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/mob_banner01.png" alt="EnglishPediaの使い方" />
					</a>
				</div>
				<div class="col-sm-4 col-xs-4 mob_top_banner_center">
					<a href="<?php echo esc_url(home_url());?>/posts_info/">
						<img class="mgnT20" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/mob_banner02.png" alt="留学情報まとめ" />
					</a>
				</div>
				<div class="col-sm-4 col-xs-4 mob_top_banner_left">
					<a href="<?php echo esc_url(home_url());?>/inquiry/">
						<img class="mgnT20" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/mob_banner06.png" alt="お問合せ" />
					</a>
				</div>
			</div>
		</div>
		<!-- End: bannar -->



			</div>
			<!-- End: right side -->
<?php else: ?>
			<h2>検索条件：<?php if($search_data){echo $search_data;}else{echo "全ての学校を表示";} ?><br>一致する学校は見つかりませんでした。</h2>
			</div>
<?php endif; ?>
		</div>
	</div>

	<div class="container">
	<?php include(get_theme_root() . '/' . get_template() . "/common-inquiry.php");?>
	</div>
</div><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); ?>
<script src="<?php echo esc_url( get_template_directory_uri() . '/js/search.js' ); ?>"></script>
<script src="<?php echo esc_url( get_template_directory_uri() . '/js/modal.js' ); ?>"></script>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
