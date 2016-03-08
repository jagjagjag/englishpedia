<?php
/*
 Template Name: 比較結果
*/
get_header();

$engp_master = engp_get_master();
$search_param = engp_set_return_search_param();
$setParam = array(
		'compareId' => $_GET['cmpid'],
		'week' => $_GET['week'],
		'dir' => $_GET['dir'],
);
$ID = engp_get_id($_COOKIE['gu_id']);
$get_meta = engp_school_compare($setParam,$ID);
$data_num = count($get_meta);
$result_id = "result" . $data_num;
?>
<link rel="stylesheet" type="text/css" href="<?php echo esc_url(get_template_directory_uri() . '/css/compare-style.css' ); ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo esc_url(get_template_directory_uri() . '/css/modal.css' ); ?>"/>

<div id="primary" class="content-area">
	<div id="main" class="site-main" role="main">
		<div class="clear"></div>
		<div id="compare_hr"></div>

		<div class="content">
			<div class="row">
				<div class="col-md-4">
					<p class="f_left link_search" onclick="OnOff1(shcool_search);" class="open"><a href="javascript:void(0)">もう一度検索する</a></p>
					<p class="f_left link_sankaku mgnT8" style="margin-bottom: 6px;"><a href="<?php echo home_url(); ?>/?s=<?php echo $search_param; ?>">検索結果にもどる</a></p>
				</div>
			</div>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-search.php");?>
		</div>

		<div class="content">
			<!-- Start: search_result -->
			<div id="search_result">
				<h2><span class="result_color mgnR8"><?php echo $data_num; ?>校</span> 学校情報比較</h2>
				<div class="clear"></div>
			</div>
			<!-- End: school_search -->

			<!-- Start: table_box -->
			<div id="table_box" class="d_table">
				<table class="f_left" id="<?php $result_id; ?>">
					<tr class="delete_bar">
						<th scope="row" class="side_header"></th>
<?php for($i=0; $i<$data_num; $i++): ?>
						<td class="column_box">
<?php
	if($data_num > 1):
		$delCompareId ="";
		$tempId = explode("_", $setParam['compareId']);
		foreach($tempId as $key => $value){
			if($value != $get_meta[$i]->post_id){
				$delCompareId .= $value . "_";
			}
		}
		$delCompareId = substr($delCompareId, 0, -1);
?>
							<a href="<?php echo esc_url(home_url());?>/compare?cmpid=<?php echo $delCompareId; ?>">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/delete.png" alt="消去" />
							</a>
<?php endif; ?>
						</td>
<?php endfor; ?>
					</tr>
					<tr>
						<th scope="row">所在地</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td class="location"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/america.png" /><?php echo $engp_master['country'][$get_meta[$i]->country]; ?></td>
<?php } ?>
					</tr>
					<tr>
						<th scope="row">学校名</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td class="school"><a href="<?php echo esc_url(home_url());?>/?school=<?php echo $get_meta[$i]->post_id; ?>" target="_blank"><?php echo $get_meta[$i]->school_jp_name; ?></a></td>
<?php } ?>
					</tr>
					<tr>
						<th scope="row"></th>
<?php
	for($i=0; $i<$data_num; $i++):
		$imagePostId = get_post_meta($get_meta[$i]->post_id, 'my_upload_images', true );
		if(!empty($imagePostId[0])):
			$schoolImage = wp_get_attachment_image_src($imagePostId[0], array(64, 64));
?>
						<td><a><img style="width: 64px; height: 64px;" src="<?php echo $schoolImage[0]; ?>" alt="学校の画像" /></a></td>
<?php else: ?>
						<td><a><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/compare_nophoto.jpg" alt="学校の画像" /></a></td>
<?php
		endif;
	endfor;
?>
					</tr>
					<tr id="actr" class="school_bar">
<!-- 						<th scope="row">学費(半日制)</th> -->
						<th scope="row">学費/コース名</th>						
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td style="font-weight:700;"><?php echo $get_meta[$i]->course_name_pt;?></td>
<?php } ?>
					</tr>


					<tr class="sltr">
						<th scope="row" class="school_bar">4週間<span class="mgnR16"></span>
<?php if($setParam['week'] == "4w" && $setParam['dir'] == "desc"): ?>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '4w', 'asc');">
								<img class="mgnR4" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_low.png" title="最安値に並べ替え" />
							</a>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '', '');">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/delete.png" title="並び替えを中止する" />
							</a>
<?php elseif($setParam['week'] == "4w" && $setParam['dir'] == "asc"): ?>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '4w', 'desc');">
								<img class="mgnR4" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_high.png" title="最高値に並べ替え" />
							</a>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '', '');">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/delete.png" title="並び替えを中止する" />
							</a>
<?php else: ?>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '4w', 'asc');">
								<img class="mgnR4" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_low.png" title="最安値に並べ替え" />
							</a>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '4w', 'desc');">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_high.png" title="最高値に並べ替え" />
							</a>
<?php endif; ?>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td class="tuition">
<?php
		if($get_meta[$i]->viewtype_yen == 0){
			$moneyHead = "$";
		}else{
			$moneyHead = "&yen;";
		}

// 		if(!empty($get_meta[$i]->tuition_4w_pt) && !empty($get_meta[$i]->tuition_4w_ft)){
// 			echo $moneyHead . number_format($get_meta[$i]->tuition_4w_pt) . " 〜 " . $moneyHead . number_format($get_meta[$i]->tuition_4w_ft) . PHP_EOL;
// 		}else if(!empty($get_meta[$i]->tuition_4w_pt) && empty($get_meta[$i]->tuition_4w_ft)){
// 			echo $moneyHead . number_format($get_meta[$i]->tuition_4w_pt) . " 〜" . PHP_EOL;
		if(!empty($get_meta[$i]->tuition_4w_pt)){
			echo $moneyHead . number_format($get_meta[$i]->tuition_4w_pt) . " 〜" . PHP_EOL;
		}else{
			echo "-" . PHP_EOL;
		}
?>
						</td>
<?php } ?>
					</tr>

					<tr class="sltr">
						<th scope="row" class="school_bar">12週間<span class="mgnR8"></span>
<?php if($setParam['week'] == "12w" && $setParam['dir'] == "desc"): ?>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '12w', 'asc');">
								<img class="mgnR4" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_low.png" title="最安値に並べ替え" />
							</a>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '', '');">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/delete.png" title="並び替えを中止する" />
							</a>
<?php elseif($setParam['week'] == "12w" && $setParam['dir'] == "asc"): ?>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '12w', 'desc');">
								<img class="mgnR4" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_high.png" title="最高値に並べ替え" />
							</a>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '', '');">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/delete.png" title="並び替えを中止する" />
							</a>
<?php else: ?>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '12w', 'asc');">
								<img class="mgnR4" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_low.png" title="最安値に並べ替え" />
							</a>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '12w', 'desc');">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_high.png" title="最高値に並べ替え" />
							</a>
<?php endif; ?>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td class="tuition">
<?php
		if($get_meta[$i]->viewtype_yen == 0){
			$moneyHead = "$";
		}else{
			$moneyHead = "&yen;";
		}

// 		if(!empty($get_meta[$i]->tuition_12w_pt) && !empty($get_meta[$i]->tuition_12w_ft)){
// 			echo $moneyHead . number_format($get_meta[$i]->tuition_12w_pt) . " 〜 " . $moneyHead . number_format($get_meta[$i]->tuition_12w_ft) . PHP_EOL;
// 		}else if(!empty($get_meta[$i]->tuition_12w_pt) && empty($get_meta[$i]->tuition_12w_ft)){
// 			echo $moneyHead . number_format($get_meta[$i]->tuition_12w_pt) . " 〜" . PHP_EOL;
// 		}else{
// 			echo "-" . PHP_EOL;
// 		}
	if(!empty($get_meta[$i]->tuition_12w_pt)){
		echo $moneyHead . number_format($get_meta[$i]->tuition_12w_pt) . " 〜" . PHP_EOL;
	}else{
		echo "-" . PHP_EOL;
	}

?>
						</td>
<?php } ?>
					</tr>

					<tr class="sltr">
						<th scope="row" class="school_bar">24週間<span class="mgnR8"></span>
<?php if($setParam['week'] == "24w" && $setParam['dir'] == "desc"): ?>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '24w', 'asc');">
								<img class="mgnR4" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_low.png" title="最安値に並べ替え" />
							</a>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '', '');">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/delete.png" title="並び替えを中止する" />
							</a>
<?php elseif($setParam['week'] == "24w" && $setParam['dir'] == "asc"): ?>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '24w', 'desc');">
								<img class="mgnR4" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_high.png" title="最高値に並べ替え" />
							</a>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '', '');">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/delete.png" title="並び替えを中止する" />
							</a>
<?php else: ?>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '24w', 'asc');">
								<img class="mgnR4" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_low.png" title="最安値に並べ替え" />
							</a>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '24w', 'desc');">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_high.png" title="最高値に並べ替え" />
							</a>
<?php endif; ?>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td class="tuition">
<?php
		if($get_meta[$i]->viewtype_yen == 0){
			$moneyHead = "$";
		}else{
			$moneyHead = "&yen;";
		}

// 		if(!empty($get_meta[$i]->tuition_24w_pt) && !empty($get_meta[$i]->tuition_24w_ft)){
// 			echo $moneyHead . number_format($get_meta[$i]->tuition_24w_pt) . " 〜 " . $moneyHead . number_format($get_meta[$i]->tuition_24w_ft) . PHP_EOL;
// 		}else if(!empty($get_meta[$i]->tuition_24w_pt) && empty($get_meta[$i]->tuition_24w_ft)){
// 			echo $moneyHead . number_format($get_meta[$i]->tuition_24w_pt) . " 〜" . PHP_EOL;
// 		}else{
// 			echo "-" . PHP_EOL;
// 		}
	if(!empty($get_meta[$i]->tuition_24w_pt)){
		echo $moneyHead . number_format($get_meta[$i]->tuition_24w_pt) . " 〜" . PHP_EOL;
	}else{
		echo "-" . PHP_EOL;
	}

?>
						</td>
<?php } ?>
					</tr>

					<tr class="sltr">
						<th scope="row" class="school_bar">48週間<span class="mgnR8"></span>
<?php if($setParam['week'] == "48w" && $setParam['dir'] == "desc"): ?>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '48w', 'asc');">
								<img class="mgnR4" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_low.png" title="最安値に並べ替え" />
							</a>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '', '');">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/delete.png" title="並び替えを中止する" />
							</a>
<?php elseif($setParam['week'] == "48w" && $setParam['dir'] == "asc"): ?>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '48w', 'desc');">
								<img class="mgnR4" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_high.png" title="最高値に並べ替え" />
							</a>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '', '');">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/delete.png" title="並び替えを中止する" />
							</a>
<?php else: ?>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '48w', 'asc');">
								<img class="mgnR4" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_low.png" title="最安値に並べ替え" />
							</a>
							<a href="javascript:void(0);" onclick="javascript:sortTuition('<?php echo $setParam['compareId']; ?>', '48w', 'desc');">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_cost_high.png" title="最高値に並べ替え" />
							</a>
<?php endif; ?>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td class="tuition">
<?php
		if($get_meta[$i]->viewtype_yen == 0){
			$moneyHead = "$";
		}else{
			$moneyHead = "&yen;";
		}

// 		if(!empty($get_meta[$i]->tuition_48w_pt) && !empty($get_meta[$i]->tuition_48w_ft)){
// 			echo $moneyHead . number_format($get_meta[$i]->tuition_48w_pt) . " 〜 " . $moneyHead . number_format($get_meta[$i]->tuition_48w_ft) . PHP_EOL;
// 		}else if(!empty($get_meta[$i]->tuition_48w_pt) && empty($get_meta[$i]->tuition_48w_ft)){
// 			echo $moneyHead . number_format($get_meta[$i]->tuition_48w_pt) . " 〜" . PHP_EOL;
// 		}else{
// 			echo "-" . PHP_EOL;
// 		}
	if(!empty($get_meta[$i]->tuition_48w_pt)){
		echo $moneyHead . number_format($get_meta[$i]->tuition_48w_pt) . " 〜" . PHP_EOL;
	}else{
		echo "-" . PHP_EOL;
	}

?>
						</td>
<?php } ?>
					</tr>
					<tr class="sltr">
						<th scope="row" class="school_bar">
							<div class="popup">スペシャルオファー(割引)
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">スペシャルオファー(割引)とは、留学の長期割引です。<br>通常の留学とは異なり、入学日が定められています。</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td class="tuition">
<?php
		if($get_meta[$i]->target_so){
			echo "有" . PHP_EOL;
		}else{
			echo "-" . PHP_EOL;
		}
?>
						</td>
<?php } ?>
					</tr>					
					<tr id="actr2" class="school_bar">
					
						<th scope="row">学校情報</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td></td>
<?php } ?>
					</tr>
					
					<tr class="sltr2">
						<th scope="row" class="school_bar">EPスコア</th>
<?php for($i=0; $i<$data_num; $i++):?>
						<td class="staff">
							<?php if($get_meta[$i]->staff_evaluation):?>
								<img class="staff_eval" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_staff<?php echo $get_meta[$i]->staff_evaluation;?>.png">
							<?php else:?>
								<img class="staff_eval" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_staff99.png">							
							<?php endif;?>
						</td>
<?php endfor;?>
					</tr>
					
					
					<tr class="sltr2">
						<th scope="row" class="school_bar">留学生の満足度</th>
<?php
	for($i=0; $i<$data_num; $i++):
		$review_data = engp_get_review_star($get_meta[$i]->post_id, STAR_SMALL);
		if($review_data['review_sum'] == 0):
?>
						<td class="review">レビューの数 -<br />
							<!-- <img src="<?php // echo esc_url(get_template_directory_uri()); ?>/images/<?php // echo $review_data['img_file'] ?>" >  -->
							<br />
							<a>　</a>
						</td>
<?php else:?>
						<td class="review">レビューの数&nbsp;<?php echo $review_data['review_sum'] ?><br />
							<!-- <img src="<?php // echo esc_url(get_template_directory_uri()); ?>/images/<?php // echo $review_data['img_file'] ?>" >  -->
							<p class="eval"><?php echo round($review_data['review_ave'],1)?> / 5</p>							
							<a href="<?php echo home_url(); ?>?school=<?php echo $get_meta[$i]->post_id; ?>&review">評価を見る</a>
						</td>
<?php
		endif;
	endfor;
?>
					</tr>
					
					<tr class="sltr2">
						<th scope="row" class="school_bar">
							<div class="popup">ロケーション
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">交通の便の良さや、街の利便性</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php echo $engp_master['location'][$get_meta[$i]->location]; ?></td>
<?php } ?>
					</tr>
					<tr class="sltr2">
						<th scope="row" class="school_bar">
							<div class="popup">治安
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">学校周辺の治安の良さ</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php echo $engp_master['security'][$get_meta[$i]->security]; ?></td>
<?php } ?>
					</tr>
					<tr class="sltr2">
						<th scope="row" class="school_bar">
							<div class="popup">国籍バランス
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">通学する学生の人種の豊富さや日本人比率の低さ</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php echo $engp_master['nationality'][$get_meta[$i]->nationality]; ?></td>
<?php } ?>
					</tr>
					<tr class="sltr2">
						<th scope="row" class="school_bar">
							<div class="popup">学校の規模
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">学校の規模はアクティビティーの多さやコースの数に起因します</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php echo $get_meta[$i]->school_size; ?></td>
<?php } ?>
					</tr>
					<tr class="sltr2">
						<th scope="row" class="school_bar">
							<div class="popup">レベル数
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">ESLコースのレベルの数です。多いほど自分の英語力にあった授業が受けられることでしょう</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php echo $get_meta[$i]->levels . "レベル"; ?></td>
<?php } ?>
					</tr>
					<tr class="sltr2">
						<th scope="row" class="school_bar">
							<div class="popup">平均クラスサイズ
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">1クラスあたりの生徒数</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php echo $get_meta[$i]->avg_classsize . "人"; ?></td>
<?php } ?>
					</tr>
					<tr class="sltr2">
						<th scope="row" class="school_bar">
							<div class="popup">主な交通手段
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">生徒の主な通学手段</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php echo $engp_master['how_to_go'][$get_meta[$i]->how_to_go]; ?></td>
<?php } ?>
					</tr>
					<tr class="sltr2">
						<th scope="row" class="school_bar">
							<div class="popup">日本人スタッフ
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">日本人スタッフの有無</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php echo $engp_master['local_staff'][$get_meta[$i]->local_staff]; ?></td>
<?php } ?>
					</tr>
					<tr class="sltr2">
						<th scope="row" class="school_bar">
							<div class="popup">入学時期
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">毎週月曜日に入稿できるか、または開講日が決まっているか</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php echo $get_meta[$i]->enrollment; ?></td>
<?php } ?>
					</tr>
					<tr class="sltr2">
						<th scope="row" class="school_bar">
							<div class="popup">駐車場
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">学校が駐車場を所有しているか</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php echo $engp_master['parking'][$get_meta[$i]->parking]; ?></td>
<?php } ?>
					</tr>

					<tr id="actr3" class="school_bar">
						<th scope="row">コースの有無</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td></td>
<?php } ?>
					</tr>
					<tr class="sltr3">
						<th scope="row" class="school_bar">
							<div class="popup">ESL
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">日常の中で英語を使えるようになることをゴールにするコース</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php if($get_meta[$i]->target_ESL){ echo "◯";} else {echo "-";} ?></td>
<?php } ?>
					</tr>
					<tr class="sltr3">
						<th scope="row" class="school_bar">
							<div class="popup">TOEFL
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">アメリカ大学の入学条件に最も活用されているテスト。スコアアップがゴール。</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php if($get_meta[$i]->target_TOEFL){ echo "◯";} else {echo "-";} ?></td>
<?php } ?>
					</tr>
					<tr class="sltr3">
						<th scope="row" class="school_bar">
							<div class="popup">TOEIC
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">ビジネスで活用できる英語力を測るテスト。スコアアップがゴール</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php if($get_meta[$i]->target_TOEIC){ echo "◯";} else {echo "-";} ?></td>
<?php } ?>
					</tr>
					<tr class="sltr3">
						<th scope="row" class="school_bar">
							<div class="popup">大学進学コース
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">アメリカの大学に進学する方向けのコース</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php if($get_meta[$i]->target_advance){ echo "◯";} else {echo "-";} ?></td>
<?php } ?>
					</tr>
					<tr class="sltr3">
						<th scope="row" class="school_bar">
							<div class="popup">ビジネス
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">英語でビジネスを出来るようになることがゴールのコース</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php if($get_meta[$i]->target_business){ echo "◯";} else {echo "-";} ?></td>
<?php } ?>
					</tr>
					<tr class="sltr3">
						<th scope="row" class="school_bar">
							<div class="popup">子供向けコース
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">18歳未満の子供を対象としたコース</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php if($get_meta[$i]->target_child){ echo "◯";} else {echo "-";} ?></td>
<?php } ?>
					</tr>
					<tr class="sltr3">
						<th scope="row" class="school_bar">
							<div class="popup">大人向けコース<br />(30歳以上、シニアなど)
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">大人のみを対象とした年齢制限のあるコース</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php if($get_meta[$i]->target_adult){ echo "◯";} else {echo "-";} ?></td>
<?php } ?>
					</tr>
					<tr class="sltr3">
						<th scope="row" class="school_bar">
							<div class="popup">IELTS
								<a>
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />
									<span class="popup_mes">海外留学や海外移住に最適な英語能力判定テスト。レベル合格がゴール。</span>
								</a>
							</div>
						</th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td><?php if($get_meta[$i]->target_ILETS){ echo "◯";} else {echo "-";} ?></td>
<?php } ?>
					</tr>
<!-- 					<tr class="sltr3"> -->
<!-- 						<th scope="row" class="school_bar"> -->
<!-- 							<div class="popup">その他 -->
<!-- 								<a> -->
<!-- 									<img src="<?php // echo esc_url(get_template_directory_uri()); ?>/images/icon_question.png" />  -->
<!-- 									<span class="popup_mes">ダンスや美容コースなど、その他学校が有している特別なコースの有無</span> -->
<!-- 								</a> -->
<!-- 							</div> -->
<!-- 						</th> -->
 <?php // for($i=0; $i<$data_num; $i++){ ?>
						<!-- <td><?php // echo $get_meta[$i]->target_other; ?></td>  -->
<?php // } ?>
<!-- 					</tr> -->

					<tr class="sltr">
						<th scope="row"></th>
<?php for($i=0; $i<$data_num; $i++){ ?>
						<td>
						<!-- Start: favorite -->
							<input id="hiddenID" type="hidden" value="<?php echo $get_meta[$i]->post_id ?>" />
							<input id="hiddenUserID" type="hidden" value="<?php echo $ID ?>" />
							<input id="hiddenShape" type="hidden" value="circle" />
							<span class="sear_ico_favorite">
								<div id ="favorite<?php echo $get_meta[$i]->post_id ?>">
<?php if(empty($ID)){ ?>
									<div id="modal-content">
										<p class="f_right"><a id="modal-close"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/delete.png" alt="閉じる"></a></p>
										<p class="modal_title">ユーザー登録(無料)をしてください！</p>
										<a href="<?php echo home_url(); ?>/regist"><img class="mgnB8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/modal_regist.png" alt="ユーザー登録"></a>
										<p class="modal_login">登録済の方は<a href="<?php echo home_url(); ?>/login">ログイン</a>して下さい。</p>
										<p class="modal_text">ユーザー登録をするとお気に入りの学校を保存しておくことができます！</p>
									</div>
									<p><a id="modal-open" class="button-link"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/favorite_add_circle.png" alt="お気に入り"></a></p>
<?php }
	else{
		if($get_meta[$i]->favorite=='1'){
?>
									<a href='javascript:void(0)' onclick='javaScript:favorite(2,<?php echo $get_meta[$i]->post_id ?>)'><img src="<?php echo esc_url(get_template_directory_uri());?>/images/favorite_remove_circle.png" alt="お気に入り解除"></a>
<?php }else { ?>
									<a href='javascript:void(0)' onclick='javaScript:favorite(1,<?php echo $get_meta[$i]->post_id ?>)'><img src="<?php echo esc_url(get_template_directory_uri());?>/images/favorite_add_circle.png" alt="お気に入り解除"></a>
<?php
 		}
	}
?>
								</div>
							</span>
												<!-- End: favorite  -->

							<a href="<?php echo esc_url(home_url());?>/estimate?estid=<?php echo $get_meta[$i]->post_id; ?>"><img class="mgnT8" style="width:120px;" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_estimate.png" /></a><br />
							<a href="<?php echo esc_url(home_url());?>/inquiry"><img class="mgnT8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/contact.png" /></a><br />
							<a href="<?php echo esc_url(home_url());?>/apply?aplid=<?php echo $get_meta[$i]->post_id; ?>"><img class="mgnT8 mgnB8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/btn_entry_com.png" /></a><br />
						</td>
<?php } ?>
					</tr>
				</table>
			</div>
			<!-- End: table_box -->
			<div class="clear"></div>
			<div class="content">
			<?php include(get_theme_root() . '/' . get_template() . "/inc/common-inquiry.php");?>
			</div>
		</div>
	</div><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); ?>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/compare.js" type="text/javascript"></script>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/modal.js" type="text/javascript"></script>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
