<?php
/**
 * @package englishpedia
 */
$engp_master = engp_get_master();
$search_param = engp_set_return_search_param();
$rate_time = engp_get_rate_time();
$get_meta = engp_school_detail($post->ID);
$get_evaluation = engp_get_review_average($post->ID);
$get_sidebar_review =engp_school_review_sidebar($post->ID);
$ID = engp_get_id($_COOKIE['gu_id']);
?>
<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/css/detail-style.css' ); ?>"/>
<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/css/modal.css' ); ?>"/>

	<div id="hr"></div>
	<input id="hiddenID" type="hidden" value="<?php echo $post->ID; ?>" />
	<div class="container">
		<div class="row mgnT10_mob">
			<div class="col-md-4">
				<p class="f_left link_search open" onclick="OnOff1(shcool_search);"><a href="javascript:void(0)">もう一度検索する</a></p>
				<p class="f_left link_sankaku_school mgnT8 mgnB0"><a href="<?php echo home_url(); ?>/?s=<?php echo $search_param; ?>">検索結果にもどる</a></p>
			</div>
		</div>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-search.php");?>
	</div>

	<!-- Start: shcool_search -->
	<div class="container">
		<div class="row mob_center" style="background: #f4f9ff; margin:8px 0 8px 0">
			<div class="col-md-2" style="display:block; vartical-align:middle;">
				<div class="nationalFlag mob_none tab_none">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/detail_america.png" alt="アメリカ合衆国" class="school_flagimg">
					<p class="c_school_country">アメリカ合衆国<br /><?php echo $get_meta->city?></p>
				</div>
			</div>
			<div class="col-md-8">
				<h1 id="c_school_name" class="mgnB5"><?php the_title(); ?></h1>
				<p id="c_school_namejp"><?php echo $get_meta->school_jp_name?></p>
					<?php if($get_meta->staff_evaluation != "0"):?>
						<img class="staff_eval" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_staff<?php echo $get_meta->staff_evaluation;?>.png">
					<?php else:?>
						<img class="staff_eval" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_staff99.png">					
					<?php endif;?>
				<p class="mgnB5"><?php echo $get_meta->address; ?>　<a href="https://www.google.co.jp/maps/place/<?php echo $get_meta->address;?>" target="_brank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/school_map.png" style="width:66px; height:16px;" alt="googlemapで地図を見る"></a></p>
<?php
	$outputHtml = '';
	if($get_meta->target_ESL){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_esl.png" alt="ESL">';
	}
	if($get_meta->target_TOEFL){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_toefl.png" alt="TOEFL">';
	}
	if($get_meta->target_TOEIC){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_toeic.png" alt="TOEIC">';
	}
	if($get_meta->target_advance){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_advance.png" alt="advance">';
	}
	if($get_meta->target_business){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_business.png" alt="business">';
	}
	if($get_meta->target_child){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_child.png" alt="child">';
	}
	if($get_meta->target_adult){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_adult.png" alt="adult">';
	}
	if($get_meta->target_ILETS){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_ilets.png" alt="IELTS">';
	}
	if($get_meta->target_so){
		$outputHtml .= '<img class="category_img2" src="'.get_template_directory_uri().'/images/category_sp_offer.png" alt="sp_offer">';
	}
	echo $outputHtml;
?>
			</div>
			<div class="col-md-2">
				<div class="title_review">
					<!-- Start: reviewyes -->
					<div id="reviewyes">
						<!-- Start: reviewno -->
						<div id="reviewno_school">
							<a href="<?php echo esc_url(home_url());?>/review?revid=<?php echo $get_meta->post_id; ?>"><img class="writeReview" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/school_review2.png" style="width:120px; height: 48px;" alt="レビューを書く"></a>
						</div>
						<!-- End: favorite review -->

<?php
	$review_data = engp_get_review_star($get_meta->post_id);
	if($review_data['review_sum'] == 0):
?>
						<h4 class="c_school_rev">レビューの数 <span class="result_color">-</span></h4>
<!-- 					<p class="c_school_satis mgnB3">満足度 <img src="<?php // echo esc_url(get_template_directory_uri()); ?>/images/<?php // echo $review_data['img_file'] ?>" ></p>  -->
						<p class="link_sankaku_school mob_none tab_none"><a id="review_content" href="javascript:void(0);">評価を見る</a></p>
<?php else:?>
						<h4 class="c_school_rev mob_none">レビューの数 <span class="result_color"><?php echo $review_data['review_sum'] ?></span></h4>
<!-- 					<p class="c_school_satis mgnB3">満足度 <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/<?php echo $review_data['img_file'] ?>" ></p>  -->
						<p class="c_school_satis mob_none mgnB3">満足度 <span><?php echo round($review_data['review_ave'],1)?> / 5</span></p>	
						<p class="link_sankaku_school mob_none tab_none"><a id="review_content" href="javascript:void(0);">評価を見る</a></p>
<?php endif; ?>
					</div>
					<!-- End: reviewyes -->

					<!-- Start: favorite review -->
					<input id="hiddenUserID" type="hidden" value="<?php echo $ID ?>" />
					<input id="hiddenShape" type="hidden" value="rectangle" />
<?php if(empty($ID)){ ?>
						<div id="modal-content">
							<p class="f_right"><a id="modal-close"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/delete.png" style="width:15px!important;" alt="閉じる"></a></p>
							<p class="modal_title">ユーザー登録(無料)をしてください！</p>
							<a href="<?php echo home_url(); ?>/regist"><img class="mgnB8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/modal_regist.png" alt="ユーザー登録"></a>
							<p class="modal_login">登録済の方は<a href="<?php echo home_url(); ?>/login">ログイン</a>して下さい。</p>
							<p class="modal_text">ユーザー登録をするとお気に入りの学校を保存しておくことができます！</p>
						</div>
						<div><a id="modal-open" class="button-link"><img class="fav_btn" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/favorite_add_rectangle.png" style="width:120px; height:24px;" alt="お気に入り"></a></div>
<?php } else {?>
					<div class="fav_btn" id = "favorite<?php echo $get_meta->post_id; ?>"></div>
<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php if($get_evaluation['evaluation_flg']==1):?>
	<div class="container">
		<div id="review_evaluation" class="row">
			<div class="col-lg-3 col-md-12 col-sm-12">
				<!-- <h4 class="eval_review">レビューの数 <span class="result_color"><?php echo $review_data['review_sum'] ?></span><span class="eval_satis">　満足度 <img class="eval_satis_star" src="<?php // echo esc_url(get_template_directory_uri()); ?>/images/<?php echo $review_data['img_file'] ?>" ></span></h4> -->
				<h4 class="eval_review">レビューの数 <span class="result_color"><?php echo $review_data['review_sum'] ?></span>　満足度 <span class="eval_satis"><?php echo round($review_data['review_ave'],1)?> / 5</span></h4>				
			</div>
			<div class="col-lg-9 col-md-12 col-sm-12">
					<ul style="list-style:none;">
						<li>学校周辺の治安：<span class="number"><?php echo $get_evaluation['secuirty'];?></span></li><li class="separate">｜</li>
						<li>交通の便：<span class="number"><?php echo $get_evaluation['traffic'];?></span></li class="separate"><li>｜</li>
						<li>綺麗さ：<span class="number"><?php echo $get_evaluation['clean'];?></span></li class="separate"><li>｜</li>
						<li>学校スタッフの対応：<span class="number"><?php echo $get_evaluation['staff'];?></span></li class="separate"><li>｜</li>
						<li>授業内容：<span class="number"><?php echo $get_evaluation['lesson'];?></span></li class="separate"><li>｜</li>
						<li>周りの学生の真剣さ：<span class="number"><?php echo $get_evaluation['student'];?></span></li>
					</ul>
			</div>
		</div>
	</div>
<?php endif;?>
	<div class="container">
		<div class="row">
			<!-- left side -->
			<div class="col-md-3">
				<!-- Start: conditions_search_title -->
<?php if(!empty($get_meta->youtube_url)): ?>
					<div id="youtube_title" class="mob_none tab_none">
						<h1 class="mgnT8 mgnB8">学校紹介動画</h1>
					</div>
					<div class="mgnB20 mob_none tab_none">
						<iframe class="youtube_iframe" src="//<?php echo $get_meta->youtube_url; ?>" frameborder="0" allowfullscreen></iframe>
					</div>
<?php endif; ?>
					<div id="map_title" class="mob_none tab_none">
						<h1 class="mgnT8 mgnB8">学校周辺地図</h1>
					</div>
					<div class="mgnB20 mob_none tab_none">
						<div class="mgnB20" style="margin-top:0px; text-align:center;">
							<?php $school_address = urlencode(mb_convert_encoding($get_meta->address,'UTF-8'));?>
							<iframe width="100%" height="220" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.jp/?q=<?php echo $school_address; ?>&hl=ja&amp;ie=UTF8&amp;z=15&amp;brcurrent=3,0x34674e0fd77f192f:0xf54275d47c665244,1&amp;output=embed"></iframe>
						</div>
					</div>

				<!-- End: conditions_search_title -->
				<!-- Start: conditions_search_title -->
				<div class="row pc_tab_none">
					<div class="col-md-12 hidden-sm hidden-xs">
						<div style="border-left:4px solid #ededed; border-right:4px solid #ededed;" >
							<div id="conditions_search_title">
								<h1 class="f_left mgnT8">学費</h1>
								<h3 class="f_right mgnT8">日本円換算<br>（<?php echo $rate_time; ?>時現在）</h3>
								<div class="clear"></div>
							</div>
							
					<!-- End: conditions_search_title -->
<?php if($get_meta->viewtype_yen == 0): ?>
						<!-- Start: conditions_search -->
						<div id="conditions_search">
							<table id="dolltable">
								<?php $even_flag = true; ?>
								<tr class="title">
									<th scope="row" colspan="3" class="title"><?php echo $get_meta->course_name_pt;?></th>
								</tr>
								<?php // if (!empty($get_meta->tuition_2w_pt)): ?>
<!-- 								<tr class="<?php // echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">  -->
<!-- 									<th scope="row">2週間</th> -->
<!-- 								<td id='cost_2w_min_usd' class="dollar">$<?php // echo number_format($get_meta->tuition_2w_pt); ?></td>  -->	
<!-- 									<td id='cost_2w_min_jpy'>-</td> -->
<!-- 								</tr> -->
								<?php // endif ?>
								<?php if (!empty($get_meta->tuition_4w_pt)): ?>
								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">4週間</th>
									<td id='cost_4w_min_usd' class="dollar">$<?php echo number_format($get_meta->tuition_4w_pt); ?></td>
									<td id='cost_4w_min_jpy'>-</td>
								</tr>
								<?php endif ?>
								<?php if (!empty($get_meta->tuition_8w_pt)): ?>
								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">8週間</th>
									<td id='cost_8w_min_usd' class="dollar">$<?php echo number_format($get_meta->tuition_8w_pt); ?></td>
									<td id='cost_8w_min_jpy'>-</td>
								</tr>
								<?php endif ?>
								<?php if (!empty($get_meta->tuition_12w_pt)): ?>
								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">12週間</th>
									<td id='cost_12w_min_usd' class="dollar">$<?php echo number_format($get_meta->tuition_12w_pt); ?></td>
									<td id='cost_12w_min_jpy'>-</td>
								</tr>
								<?php endif ?>
								<?php if (!empty($get_meta->tuition_16w_pt)): ?>
								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">16週間</th>
									<td id='cost_16w_min_usd' class="dollar">$<?php echo number_format($get_meta->tuition_16w_pt); ?></td>
									<td id='cost_16w_min_jpy'>-</td>
								</tr>
								<?php endif ?>
								<?php if (!empty($get_meta->tuition_24w_pt)): ?>
								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">24週間</th>
									<td id='cost_24w_min_usd' class="dollar">$<?php echo number_format($get_meta->tuition_24w_pt); ?></td>
									<td id='cost_24w_min_jpy'>-</td>
								</tr>
								<?php endif ?>
								<?php if (!empty($get_meta->tuition_36w_pt)): ?>
								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">36週間</th>
									<td id='cost_36w_min_usd' class="dollar">$<?php echo number_format($get_meta->tuition_36w_pt); ?></td>
									<td id='cost_36w_min_jpy'>-</td>
								</tr>
								<?php endif ?>
								<?php if (!empty($get_meta->tuition_48w_pt)): ?>
								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">48週間</th>
									<td id='cost_48w_min_usd' class="dollar">$<?php echo number_format($get_meta->tuition_48w_pt); ?></td>
									<td id='cost_48w_min_jpy'>-</td>
								</tr>
								<?php endif ?>								
								<tr class="title">
									<th scope="row" colspan="3" class="title"><?php echo $get_meta->course_name_ft;?></th>
								</tr>
								<?php // if (!empty($get_meta->tuition_2w_ft)): ?>
<!-- 								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">2週間</th>
									<td id='cost_2w_ft_min_usd' class="dollar">$<?php // echo number_format($get_meta->tuition_2w_ft); ?></td>
									<td id='cost_2w_ft_min_jpy'>-</td>
								</tr> -->
								<?php // endif ?>
								<?php if (!empty($get_meta->tuition_4w_ft)): ?>
								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">4週間</th>
									<td id='cost_4w_ft_min_usd' class="dollar">$<?php echo number_format($get_meta->tuition_4w_ft); ?></td>
									<td id='cost_4w_ft_min_jpy'>-</td>
								</tr>
								<?php endif ?>
								<?php if (!empty($get_meta->tuition_8w_ft)): ?>
								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">8週間</th>
									<td id='cost_8w_ft_min_usd' class="dollar">$<?php echo number_format($get_meta->tuition_8w_ft); ?></td>
									<td id='cost_8w_ft_min_jpy'>-</td>
								</tr>
								<?php endif ?>
								<?php if (!empty($get_meta->tuition_12w_ft)): ?>
								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">12週間</th>
									<td id='cost_12w_ft_min_usd' class="dollar">$<?php echo number_format($get_meta->tuition_12w_ft); ?></td>
									<td id='cost_12w_ft_min_jpy'>-</td>
								</tr>
								<?php endif ?>
								<?php if (!empty($get_meta->tuition_16w_ft)): ?>
								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">16週間</th>
									<td id='cost_16w_ft_min_usd' class="dollar">$<?php echo number_format($get_meta->tuition_16w_ft); ?></td>
									<td id='cost_16w_ft_min_jpy'>-</td>
								</tr>
								<?php endif ?>
								<?php if (!empty($get_meta->tuition_24w_ft)): ?>
								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">24週間</th>
									<td id='cost_24w_ft_min_usd' class="dollar">$<?php echo number_format($get_meta->tuition_24w_ft); ?></td>
									<td id='cost_24w_ft_min_jpy'>-</td>
								</tr>
								<?php endif ?>
								<?php if (!empty($get_meta->tuition_36w_ft)): ?>
								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">36週間</th>
									<td id='cost_36w_ft_min_usd' class="dollar">$<?php echo number_format($get_meta->tuition_36w_ft); ?></td>
									<td id='cost_36w_ft_min_jpy'>-</td>
								</tr>
								<?php endif ?>
								<?php if (!empty($get_meta->tuition_48w_ft)): ?>
								<tr class="<?php echo $even_flag?"even":"";$even_flag=!$even_flag; ?>">
									<th scope="row">48週間</th>
									<td id='cost_48w_ft_min_usd' class="dollar">$<?php echo number_format($get_meta->tuition_48w_ft); ?></td>
									<td id='cost_48w_ft_min_jpy'>-</td>
								</tr>
								<?php endif ?>								
							</table>
						</div>
						<!-- End: conditions_search -->
<?php endif; ?>
						<!-- Start: conditions_search_title -->
						<div id="conditions_search_bottum">
							<p class="link_sankaku_school f_right mgnR16" style="margin-bottom:0px;"><a href="<?php echo home_url(); ?>/estimate?estid=<?php echo $get_meta->post_id; ?>">留学費用を自動見積もり</a></p>
							<div class="clear"></div>
						</div>
					</div>
				</div>
				</div>

					<!-- End: conditions_search_title -->

			<!-- Start: review -->
<?php if($get_sidebar_review): ?>
				<div id="conditions_review_title" class="mob_none tab_none">
					<h1 class="mgnT8 mgnB8">この学校のレビュー</h1>
				</div>
<?php foreach ($get_sidebar_review as $data): ?>

				<div class="mgnB20 mob_none tab_none conditions_review_box">
<?php switch ($data->satisfaction_evaluation){
	case "1":?>
				<img width="80px" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_s10.png" alt="評価" >
	<?php break;?>
	<?php case "2": ?>
				<img width="80px" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_s20.png" alt="評価" >
	<?php break;?>
	<?php case "3": ?>
				<img width="80px" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_s30.png" alt="評価" >
	<?php break;?>
	<?php case "4": ?>
				<img width="80px" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_s40.png" alt="評価" >
	<?php break;?>
	<?php case "5": ?>
				<img width="80px" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_s50.png" alt="評価" >
	<?php break;
	}?>

                <p class="conditions_review_name"><?php echo esc_html($data->open_name); ?></p>
				<p>
<?php
	if($data->selected_comment == null){
		if(mb_strlen($data->comment,'SJIS') > 163){
			$short_comment = mb_strimwidth($data->comment, 0, 163, '...');
			$short_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $short_comment);
			echo nl2br(esc_html($short_comment));
		}else{
			$change_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $data->comment);
			echo nl2br(esc_html($change_comment));
		};
	}else{
		if(mb_strlen($data->selected_comment,'SJIS') > 163){
			$short_selected_comment = mb_strimwidth($data->selected_comment, 0, 163, '...');
			$short_selected_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $short_selected_comment);
			echo nl2br(esc_html($short_selected_comment));
		}else{
			$change_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $data->selected_comment);
			echo nl2br(esc_html($change_comment));
		};
	}
?>
				</p>
			</div>
<?php endforeach; ?>
				<div id="conditions_review_bottom" class="mob_none tab_none">
				<p class="link_sankaku_school f_right mgnR16"><a id="review_sidebar" href="javascript:void(0);">もっと見る</a></p>
				</div>
<?php endif;?>
				<a href="<?php echo esc_url(home_url());?>/review?revid=<?php echo $get_meta->post_id; ?>"><img class="mob_none review_banner" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner07.png" alt="この学校のレビュー・写真を投稿する"></a>
			<!-- End: review -->



				<!-- HistoryModule -->
				<div class="row">
					<div class="col-md-12 hidden-sm hidden-xs pc_tab_none">
						<?php include(get_theme_root() . '/' . get_template() . "/inc/common-history.php");?>
					</div>
					<div class="col-md-12 hidden-sm hidden-xs">
				<!-- HistoryModule -->
						<a href="<?php echo esc_url(home_url());?>/introduction/"><img class="mgnT16" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner01.png" alt="EnglishPediaの使い方"></a><br />
						<a href="<?php echo esc_url(home_url());?>/posts_info/"><img class="mgnT16" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner02.png" alt="留学情報まとめ" ></a><br />
						<a href="<?php echo esc_url(home_url());?>/inquiry/"><img class="mgnT16" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner03.png" alt="留学費用の相場" ></a><br />
						<a href="<?php echo esc_url(home_url());?>/city/"><img class="mgnT16" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner04.png" alt="各都市の詳細" ></a><br />
						<a href="<?php echo home_url(); ?>/langageschool"><img class="mgnT16" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner05.png" alt="学校関係者の方へ"></a>
					</div>
				</div>
			</div>

			<!-- right side -->
			<div class="col-md-9">
<?php
	$imagePostId = get_post_meta($get_meta->post_id, 'my_upload_images', true);
	$imageTotal = count($imagePostId);

	if(!empty($imagePostId) && $imageTotal > 0):
		$top_image = wp_get_attachment_image_src($imagePostId[0], full);
?>
				<div class="row">
					<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12 d_tablecell" align="center">
						<div id="bigimage">
							<div class="bigimage_img"><img class="school_photo" id="MainPhoto" src="<?php echo $top_image[0]; ?>"></div>
						</div>
					</div>
				</div>
				<div id="samimg"><strong>学校提供写真</strong>
					<ul>
<?php for($i=0; ($i<$imageTotal && $i<30); $i++):
			$thumbnailImageSrc = wp_get_attachment_image_src($imagePostId[$i], array(49,49));
			$linkImageSrc = wp_get_attachment_image_src($imagePostId[$i], full);
			if(($i==15 || $i==30 || $i==$imageTotal)):
?>
						<li class="liend"><a href="javascript:void(0);"><img style="width: 49px; height: 49px;" src="<?php echo $thumbnailImageSrc[0]; ?>" data-src="<?php echo $linkImageSrc[0]; ?>" alt="サムネイル" class="ChangePhoto"></a></li>
<?php 		else: ?>
						<li><a href="javascript:void(0);"><img style="width: 49px; height: 49px;" src="<?php echo $thumbnailImageSrc[0]; ?>" data-src="<?php echo $linkImageSrc[0]; ?>" alt="サムネイル" class="ChangePhoto"></a></li>
<?php
			endif;
	endfor;
?>
					</ul>
				</div>
<?php else: ?>
				<div class="mob_none tab_none">
					<div class="row">
					<div class="col-md-offset-1 col-md-10 col-sm-12 col-xs-12 d_tablecell" align="center">
							<div id="bigimage">
								<div class="bigimage_img"><img class="school_photo" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/nophoto_461x26.jpg" id="MainPhoto"></div>
							</div>
						</div>
					</div>
					<div id="samimg"><strong>学校提供写真</strong>
						<ul>
							<li class="liend"><a><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/nophoto_49x49.jpg" alt="サムネイル"></a></li>
						</ul>
					</div>
				</div><br>
<?php endif; ?>


<?php
	$approved_dir = PHOTO_DIR.$get_meta -> post_id.'/approved/';
	$approved_url = PHOTO_URL.$get_meta -> post_id.'/approved/';
	exec ('ls -t -1 '.$approved_dir, $output);
	$postImageTotal = count($output);
	if($output):
?>
				<div class="clear"></div>
				<div id="postimg"><strong>ユーザー投稿写真</strong>
					<ul>
<?php
		for($j=0; ($j<$postImageTotal && $j<15); $j++):
			if(($j==15 || $j==$postImageTotal)):
?>
			<li class="liend"><a href="javascript:void(0);"><img style="width: 49px; height: 49px;" src="<?php echo $approved_url.$output[$j]; ?>" data-src="<?php echo $approved_url.$output[$j]; ?>" alt="サムネイル" class="ChangePhoto"></a></li>
<?php 	else: ?>
			<li><a href="javascript:void(0);"><img style="width: 49px; height: 49px;" src="<?php echo $approved_url.$output[$j]; ?>" data-src="<?php echo $approved_url.$output[$j]; ?>" alt="サムネイル" class="ChangePhoto"></a></li>
<?php
			endif;
		endfor;
?>
					</ul>
				</div>
<?php
		if($postImageTotal > 15)://モーダル用
?>
			<div class='clear'></div>

			<div id="modal-photo-content">
				<p class="f_right"><a id="modal-photo-close"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/delete.png" alt="閉じる"></a></p>
				<p class="modal_title">ユーザー投稿写真</p>
				<div class="row">
					<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12 d_tablecell" align="center">
						<div id="modal_bigimage">
							<div class="modal_bigimage_img"><img class="school_photo" id="ModalMainPhoto" src="<?php echo $approved_url.$output[0]; ?>"></div>
						</div>
					</div>
				</div>
				<!--サムネイル（ページャー）用スライダー Start-->
				<div class="slider">
				    <div class="controlWrap">
			            <ul id="bx-pager" class="bxslider02">
<?php	//サムネイル作成
		for($j=0; ($j<$postImageTotal); $j++):
?>
	            			<li><a data-slide-index="<?php echo $j; ?>" href="javascript:void(0);"><img src="<?php echo $approved_url.$output[$j]; ?>" data-src="<?php echo $approved_url.$output[$j]; ?>" style="width: 49px; height: 49px;" alt="<?php echo 'thumb'.$j; ?>" class="ChangeModalPhoto"></a></li>
<?php
		endfor;
?>
            			</ul>
				        <p id="PrevIcon"></p>
				        <p id="NextIcon"></p>
				    </div>
				</div>
				<!--サムネイル（ページャー）用スライダー End-->
				</div>
			<div><p class="f_right link_sankaku_school mgnT8"><a id="modal-photo-open" class="button-photo-link" href="javascript:void(0);">もっと見る</a></p></div>
<?php
		endif;
	endif;
?>
						<div class="clear"></div>

<?php if(!empty($get_meta->youtube_url)): ?>
				<div class="row">
					<div class="hidden-lg hidden-md col-ms-12 col-xs-12">
						<div id="youtube_title" style="margin-top:16px;">
							<h1 class="mgnT8 mgnB8">学校紹介動画</h1>
						</div>
					</div>
					<div class="hidden-lg hidden-md col-ms-12 col-xs-12">
						<div class="mgnB20" style="margin-top:16px; text-align:center;position:relative;padding-bottom:56.25%;overflow:hidden;">
							<iframe width="100%" height="100%" style="position:absolute;top:0;left:0;" src="//<?php echo $get_meta->youtube_url; ?>" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
				</div>
<?php endif; ?>

				<p class="info_text">
					<?php echo $get_meta->outline?>
				</p>

<?php if($get_meta->so1_pt_offer || $get_meta->so2_pt_offer || $get_meta->so3_pt_offer || $get_meta->so4_pt_offer ||
		$get_meta->so1_ft_offer || $get_meta->so2_ft_offer || $get_meta->so3_ft_offer || $get_meta->so4_ft_offer):
?>
				<div id="sp_offer" class="d_table" style="width: 100%;">
					<div id="sp_offer_left" class="d_tablecell">
						<p class="d_tablecell sp_offer_p">スペシャルオファー(割引)<span class="color_yes">有り</span></p>
						<p class="d_tablecell link_sankaku_school padL16 mob_none"><a id="spoffer_detail" href="javascript:void(0);">詳細</a></p>
					</div>
					<div id="sp_offer_right" class="d_tablecell">
						<p>スペシャルオファー(割引)とは、留学の長期割引です。<br>通常の留学とは異なり、入学日が定められています。</p>
					</div>
				</div>
<?php endif; ?>
				<div id="detail_link">
					<div class="row">
						<a href="<?php echo home_url(); ?>/estimate?estid=<?php echo $get_meta->post_id; ?>">
							<div class="col-md-4 col-sm-4 col-xs-12 detail_btn">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/detail_link06.png" alt="この学校の留学費用を自動見積もり" class="detail_btnimg"><br/>留学費用を自動で見積もる
							</div>
						</a>
						<a href="<?php echo esc_url(home_url());?>/inquiry">
							<div class="col-md-4 col-sm-4 col-xs-12 detail_btn">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/detail_link07.png" alt="この学校について問い合わせる" class="detail_btnimg"><br/>この学校について問い合わせる
							</div>
						</a>
						<a href="<?php echo esc_url(home_url());?>/apply?aplid=<?php echo $get_meta->post_id; ?>">
							<div class="col-md-4 col-sm-4 col-xs-12 detail_btn2">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/detail_link08.png" alt="この学校に申し込む" class="detail_btnimg"><br/>この学校に申し込む
							</div>
						</a>
					</div>
				</div>

				<h1 class="detailtitle_h1"><?php echo $get_meta->school_name ?></h1>

				<!-- Start: tabs -->
				<div id="tabs" class="row">
					<div id="side_tabs">
						<a class="tab_button" onclick="ChangeTab('details_tab'); return false;" href="#"><div id="details_tab_button" class="col-md-4 col-sm-4 col-xs-6 mgnR8"></div></a>
						<a class="tab_button" onclick="ChangeTab('review_tab'); return false;" href="#"><div id="review_tab_button" class="col-md-4 col-sm-4 col-xs-6 mgnR8"></div></a>
					</div>
				</div>
				<!-- End: tabs -->

				<div id="details_tab" class="tab">
					<!-- Start: table_box -->
					<div id="table_box" class="d_table">
						<h4 class="d_tablecell odd">基本情報<br /><img class="mgnT8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/farst.png" /></h4>

						<table class="f_left">
							<!-- PC、タブレット -->
							<tr class="mob_none mob_small_none">
								<th scope="row">名前</th>
								<td><?php echo $get_meta->school_name ?></td>
							</tr>
							<!-- モバイル -->
							<tr class="pc_none tab_none">
								<th scope="row">名前</th>
								<td></td>
							</tr>
							<tr class="pc_none tab_none">
								<td colspan="2" style="padding-left:20px;"><?php echo $get_meta->school_name ?></td>
							</tr>

							<!-- PC、タブレット -->
							<tr class="mob_none mob_small_none">
								<th scope="row">アドレス</th>
								<td><?php echo $get_meta->address ?>　<a href="https://www.google.co.jp/maps/place/<?php echo $get_meta->address;?>" target="_brank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/school_map.png" style="width:66px; height:16px;" alt="googlemapで地図を見る"></a></td>
							</tr>
							<!-- モバイル -->
							<tr class="pc_none tab_none">
								<th scope="row">アドレス</th>
								<td></td>
							</tr>
							<tr class="pc_none tab_none">
								<td colspan="2" style="padding-left:20px;"><?php echo $get_meta->address ?>　<a href="https://www.google.co.jp/maps/place/<?php echo $get_meta->address;?>" target="_brank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/school_map.png" style="width:66px; height:16px;" alt="googlemapで地図を見る"></a></td>
							</tr>


							<tr class="endtr">
								<th scope="row">電話番号</th>
								<td><?php echo $get_meta->phone ?></td>
							</tr>
						</table>
					</div>
					<!-- End: table_box -->

					<!-- Start: table_box -->
					<div id="table_box" class="d_table">
						<h4 class="d_tablecell even">学校情報<br /><img class="mgnT8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/school.png" /></h4>
						<table class="f_left">
							<tr>
								<th scope="row">大学敷地内</th>
								<td colspan="2">
									<?php echo $engp_master['location_type'][$get_meta->location_type] ?>
								</td>
							</tr>
							<tr>
								<th scope="row">ロケーション</th>
								<td colspan="2">
									<?php echo $engp_master['location'][$get_meta->location] ?>
								</td>
							</tr>
<?php if($get_meta->how_to_go == 1): ?>
							<tr>
								<th scope="row">通学手段</th>
								<td><img class="mgnR8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/bus.png" style="width:32px; height:14px;"/>バス</td>
							</tr>
<?php elseif($get_meta->how_to_go == 2): ?>
							<tr>
								<th scope="row">通学手段</th>
								<td><img class="mgnR8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/car.png" style="width:26px; height:14px;"/>車</td>
							</tr>
<?php elseif($get_meta->how_to_go == 3): ?>
							<tr>
								<th scope="row">通学手段</th>
								<td><img class="mgnR8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/train.png" style="width:32px; height:19px;"/>電車</td>
							</tr>
<?php elseif($get_meta->how_to_go == 4): ?>
							<tr>
								<th rowspan="2" scope="row">通学手段</th>
								<td><img class="mgnR8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/bus.png" style="width:32px; height:14px;"/>バス</td>
							</tr>
							<tr>
								<td><img class="mgnR8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/car.png" style="width:26px; height:14px;"/>車</td>
							</tr>
<?php elseif($get_meta->how_to_go == 5): ?>
							<tr>
								<th rowspan="2" scope="row">通学手段</th>
								<td><img class="mgnR8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/bus.png" style="width:32px; height:14px;"/>バス</td>
							</tr>
							<tr>
								<td><img class="mgnR8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/train.png" style="width:32px; height:19px;"/>電車</td>
							</tr>
<?php elseif($get_meta->how_to_go == 6): ?>
							<tr>
								<th rowspan="2" scope="row">通学手段</th>
								<td><img class="mgnR8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/car.png" style="width:26px; height:14px;"/>車</td>
							</tr>
							<tr>
								<td><img class="mgnR8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/train.png" style="width:32px; height:19px;"/>電車</td>
							</tr>
<?php else: ?>
							<tr>
								<th rowspan="3" scope="row">通学手段</th>
								<td><img class="mgnR8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/bus.png" style="width:32px; height:14px;"/>バス</td>
							</tr>
							<tr>
								<td><img class="mgnR8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/car.png" style="width:26px; height:14px;"/>車</td>
							</tr>
							<tr>
								<td><img class="mgnR8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/train.png" style="width:32px; height:19px;"/>電車</td>
							</tr>
<?php endif; ?>
							<tr>
								<th scope="row">治安</th>
								<td colspan="2">
									<?php echo $engp_master['security'][$get_meta->security] ?>（５段階評価中）
								</td>
							</tr>
							<tr>
								<th scope="row">駐車場</th>
								<td colspan="2">
									<?php echo $engp_master['parking'][$get_meta->parking] ?>
								</td>
							</tr>


							<!-- PC、タブレット -->
							<tr class="mob_none mob_small_none">
								<th scope="row">学校設備</th>
								<td colspan="2"><?php echo $get_meta->options; ?></td>
							</tr>
							<!-- モバイル -->
							<tr class="pc_none tab_none">
								<th scope="row">学校設備</th>
								<td></td>
							</tr>
							<tr class="pc_none tab_none">
								<td colspan="2" style="padding-left:20px;"><?php echo $get_meta->options; ?></td>
							</tr>

							<!-- PC、タブレット -->
							<tr class="endtr mob_none mob_small_none">
								<th scope="row">オプション</th>
								<td colspan="2"><?php echo $get_meta->facilities; ?></td>
							</tr>
							<tr class="pc_none tab_none">
								<th scope="row">オプション</th>
								<td></td>
							</tr>
							<tr class="pc_none tab_none endtr">
								<td colspan="2" style="padding-left:20px;"><?php echo $get_meta->facilities; ?></td>
							</tr>
						</table>
					</div>
					<!-- End: table_box -->

					<!-- Start: table_box -->
					<div id="table_box" class="d_table">
						<h4 class="d_tablecell odd">入学情報<br /><img class="mgnT8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/entrance.png" /></h4>
						<table class="f_left admission">
							<tr>
								<th scope="row">入学時期</th>
								<td><?php echo $get_meta->enrollment ?></td>
							</tr>
							<tr>
								<th scope="row">スクールサイズ</th>
								<td><?php echo $get_meta->school_size ?></td>
							</tr>
							<tr>
								<th scope="row">レベル数</th>
								<td><?php echo $get_meta->levels ?></td>
							</tr>
							<tr>
								<th scope="row">平均クラスサイズ</th>
								<td><?php echo $get_meta->avg_classsize ?></td>
							</tr>
							<tr class="endtr">
								<th scope="row">ナショナリティ</th>
								<td><?php echo $engp_master['nationality'][$get_meta->nationality] ?></td>
							</tr>
						</table>
					</div>
					<!-- End: table_box -->
<?php
	if($get_meta->viewtype_yen == 0){
		$moneyHead = "$";
	}else{
		$moneyHead = "&yen;";
	}
?>
					<div id="feesbox"></div>
					<!-- Start: table_box -->
					<div id="table_box" class="d_table">
						<h4 class="d_tablecell even">学費<br><?php echo $get_meta->course_name_pt;?><br><img class="mgnT8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/fees_g.png" /></h4>
						<table class="f_left fee_half">
<!-- 							<tr> -->
<!-- 								<th scope="row">2週間</th> -->
<!-- 								<td><?php // echo empty($get_meta->tuition_2w_pt) ? "-" : $moneyHead.number_format($get_meta->tuition_2w_pt); ?></td>  -->
<!-- 							</tr> -->
							<tr>
								<th scope="row">4週間</th>
								<td><?php echo empty($get_meta->tuition_4w_pt) ? "-" : $moneyHead.number_format($get_meta->tuition_4w_pt); ?></td>
							</tr>
							<tr>
								<th scope="row">8週間</th>
								<td><?php echo empty($get_meta->tuition_8w_pt) ? "-" : $moneyHead.number_format($get_meta->tuition_8w_pt); ?></td>
							</tr>
							<tr>
								<th scope="row">12週間</th>
								<td><?php echo empty($get_meta->tuition_12w_pt) ? "-" : $moneyHead.number_format($get_meta->tuition_12w_pt); ?></td>
							</tr>
							<tr>
								<th scope="row">24週間</th>
								<td><?php echo empty($get_meta->tuition_24w_pt) ? "-" : $moneyHead.number_format($get_meta->tuition_24w_pt); ?></td>
							</tr>
							<tr>
								<th scope="row">36週間</th>
								<td><?php echo empty($get_meta->tuition_36w_pt) ? "-" : $moneyHead.number_format($get_meta->tuition_36w_pt); ?></td>
							</tr>
							<tr class="endtr">
								<th scope="row">48週間</th>
								<td><?php echo empty($get_meta->tuition_48w_pt) ? "-" : $moneyHead.number_format($get_meta->tuition_48w_pt); ?></td>
							</tr>
						</table>
					</div>
					<!-- End: table_box -->

					<!-- Start: table_box -->
					<div id="table_box" class="d_table">
						<h4 class="d_tablecell odd">学費<br><?php echo $get_meta->course_name_ft;?><br><img class="mgnT8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/fees.png" /></h4>
						<table class="f_left fee_full">
<!-- 							<tr>
								<th scope="row">2週間</th>
								<td><?php // echo empty($get_meta->tuition_2w_ft) ? "-" : $moneyHead.number_format($get_meta->tuition_2w_ft); ?></td>
							</tr>
 -->						
							<tr>
								<th scope="row">4週間</th>
								<td><?php echo empty($get_meta->tuition_4w_ft) ? "-" : $moneyHead.number_format($get_meta->tuition_4w_ft); ?></td>
							</tr>
							<tr>
								<th scope="row">8週間</th>
								<td><?php echo empty($get_meta->tuition_8w_ft) ? "-" : $moneyHead.number_format($get_meta->tuition_8w_ft); ?></td>
							</tr>
							<tr>
								<th scope="row">12週間</th>
								<td><?php echo empty($get_meta->tuition_12w_ft) ? "-" : $moneyHead.number_format($get_meta->tuition_12w_ft); ?></td>
							</tr>
							<tr>
								<th scope="row">24週間</th>
								<td><?php echo empty($get_meta->tuition_24w_ft) ? "-" : $moneyHead.number_format($get_meta->tuition_24w_ft); ?></td>
							</tr>
							<tr>
								<th scope="row">36週間</th>
								<td><?php echo empty($get_meta->tuition_36w_ft) ? "-" : $moneyHead.number_format($get_meta->tuition_36w_ft); ?></td>
							</tr>
							<tr class="endtr">
								<th scope="row">48週間</th>
								<td><?php echo empty($get_meta->tuition_48w_ft) ? "-" : $moneyHead.number_format($get_meta->tuition_48w_ft); ?></td>
							</tr>
						</table>
					</div>
					<!-- End: table_box -->

<?php if($get_meta->target_so): ?>
					<div id="spfeesbox"></div>
					<!-- Start: table_box -->
					<div id="table_box" class="d_table">
<!-- 						<h4 class="d_tablecell sp_offer">スペシャル<br>オファー<br>(半日制)<br><img class="mgnT8" src="<?php // echo esc_url(get_template_directory_uri()); ?>/images/sp_offer.png" /></h4>  -->
 						<h4 class="d_tablecell sp_offer">スペシャル<br>オファー<br><img class="mgnT8" style="margin-bottom:15px;" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sp_offer.png" /></h4>					
						<table class="f_left">
<!-- 							<tr>
								<th scope="row">オファー 1</th>
								<td><?php // echo empty($get_meta->tuition_so1_pt) ? "-" : $moneyHead.number_format($get_meta->tuition_so1_pt); ?></td>
							</tr>
							<tr>
								<th scope="row">オファー 2</th>
								<td><?php // echo empty($get_meta->tuition_so2_pt) ? "-" : $moneyHead.number_format($get_meta->tuition_so2_pt); ?></td>
							</tr>
							<tr>
								<th scope="row">オファー 3</th>
								<td><?php // echo empty($get_meta->tuition_so3_pt) ? "-" : $moneyHead.number_format($get_meta->tuition_so3_pt); ?></td>
							</tr>
							<tr>
								<th scope="row">オファー 4</th>
								<td><?php // echo empty($get_meta->tuition_so4_pt) ? "-" : $moneyHead.number_format($get_meta->tuition_so4_pt); ?></td>
							</tr>
 -->
							<tr class="endtr">
								<td colspan="2" class="sp_offer">
									特別キャンペーンや長期申込のお客様に対し、割引を提供してくれる場合があります。<br>詳細の内容はカウンセリングでお問い合わせ下さい。
								</td>
							</tr>
						</table>
					</div>
<?php endif; ?>
					<!-- End: table_box -->

<?php // if($get_meta->so1_ft_offer || $get_meta->so2_ft_offer || $get_meta->so3_ft_offer || $get_meta->so4_ft_offer): ?>
<!-- 					<div id="spfeesbox"></div> -->
					<!-- Start: table_box -->
<!-- 					<div id="table_box" class="d_table">
						<h4 class="d_tablecell sp_offer">スペシャル<br>オファー<br>(全日制)<br><img class="mgnT8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sp_offer.png" /></h4>
						<table class="f_left">
							<tr>
								<th scope="row">オファー 1</th>
								<td><?php // echo empty($get_meta->tuition_so1_ft) ? "-" : $moneyHead.number_format($get_meta->tuition_so1_ft); ?></td>
							</tr>
							<tr>
								<th scope="row">オファー 2</th>
								<td><?php // echo empty($get_meta->tuition_so2_ft) ? "-" : $moneyHead.number_format($get_meta->tuition_so2_ft); ?></td>
							</tr>
							<tr>
								<th scope="row">オファー 3</th>
								<td><?php // echo empty($get_meta->tuition_so3_ft) ? "-" : $moneyHead.number_format($get_meta->tuition_so3_ft); ?></td>
							</tr>
							<tr>
								<th scope="row">オファー 4</th>
								<td><?php // echo empty($get_meta->tuition_so4_ft) ? "-" : $moneyHead.number_format($get_meta->tuition_so4_ft); ?></td>
							</tr>
							<tr class="endtr"><td colspan="2" class="sp_offer">特別キャンペーンや長期申込のお客様に対し、割引を提供してくれる場合があります。<br>詳細の内容はカウンセリングでお問い合わせ下さい。</td></tr>
						</table>
					</div>
 -->				 
					<!-- End: table_box -->


<?php
//	endif;

	$w_title_array = array();
	$w_val_array = array();
	if(!empty($get_meta->course_name_pt))	{ $w_title_array[] = $get_meta->course_name_pt;				$w_val_array[] = $get_meta->course_detail_pt;		}
	if(!empty($get_meta->course_name_ft))	{ $w_title_array[] = $get_meta->course_name_ft;			$w_val_array[] = $get_meta->course_detail_ft;	}
	if(!empty($get_meta->course_name_cs3))	{ $w_title_array[] = $get_meta->course_name_cs3;			$w_val_array[] = $get_meta->course_detail_cs3;	}
	if(!empty($get_meta->course_name_cs4)){ $w_title_array[] = $get_meta->course_name_cs4;			$w_val_array[] = $get_meta->course_detail_cs4;	}
	if(!empty($get_meta->course_name_cs5)){ $w_title_array[] = $get_meta->course_name_cs5;			$w_val_array[] = $get_meta->course_detail_cs5;	}
	if(!empty($get_meta->course_name_cs6))	{ $w_title_array[] = $get_meta->course_name_cs6;	$w_val_array[] = $get_meta->course_detail_cs6;	}
	if(!empty($get_meta->course_name_cs7))	{ $w_title_array[] = $get_meta->course_name_cs7;	$w_val_array[] = $get_meta->course_detail_cs7;	}
	
// 	if(!empty($get_meta->target_ESL))	{ $w_title_array[] = 'ESL';				$w_val_array[] = $get_meta->target_ESL;		}
// 	if(!empty($get_meta->target_TOEFL))	{ $w_title_array[] = 'TOEFL';			$w_val_array[] = $get_meta->target_TOEFL;	}
// 	if(!empty($get_meta->target_TOEIC))	{ $w_title_array[] = 'TOEIC';			$w_val_array[] = $get_meta->target_TOEIC;	}
// 	if(!empty($get_meta->target_advance)){ $w_title_array[] = '進学';			$w_val_array[] = $get_meta->target_advance;	}
// 	if(!empty($get_meta->target_busines)){ $w_title_array[] = 'ビジネス';			$w_val_array[] = $get_meta->target_busines;	}
// 	if(!empty($get_meta->target_child))	{ $w_title_array[] = '子供（U12, U15等)';	$w_val_array[] = $get_meta->target_child;	}
// 	if(!empty($get_meta->target_adult))	{ $w_title_array[] = 'アダルト（大人向け）';	$w_val_array[] = $get_meta->target_adult;	}
// 	if(!empty($get_meta->target_ILETS))	{ $w_title_array[] = 'ILETS';			$w_val_array[] = $get_meta->target_ILETS;	}
// 	if(!empty($get_meta->target_other))	{ $w_title_array[] = 'その他';			$w_val_array[] = $get_meta->target_other;	}
	
	
	
	if(count($w_title_array)>0):
?>
					<!-- Start: table_box -->
<?php if(!empty($get_meta->other)):?>
					<div id="table_box" class="d_table">
<?php else:?>
					<div id="table_box" class="d_table endline">
<?php endif;?>
						<h4 class="d_tablecell even">プログラム<br /><img class="mgnT8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/program.png" /></h4>

						<table class="f_left">
<!-- 							<tr> -->
<!-- 								<th scope="row">コース</th> -->
<!-- 								<td></td> -->
<!-- 							</tr> -->
<!-- 							<tr> -->
<!-- 								<td class="resson" colspan="2"><?php // echo implode(',',$w_title_array);?></td>  -->
<!-- 							</tr> -->
							<tr>
<!-- 								<th scope="row">コース詳細</th> -->
							<th scope="row">コース</th>							
								<td></td>
							</tr>
							<tr class="endtr">
								<td class="btr resson"><?php echo $w_title_array[0]; ?></td>
								<td class="btr"><?php echo $w_val_array[0]; ?></td>
							</tr>
<?php
		array_shift($w_title_array);
		array_shift($w_val_array);
		foreach($w_title_array as $key => $value):
?>
							<tr<?php echo end($w_title_array)===$value?' class="endtr"':''; ?>>
								<td class="a_c resson"><?php echo $value; ?></td>
								<td><?php echo $w_val_array[$key]; ?></td>
							</tr>
<?php endforeach; ?>
						</table>
					</div>
					<!-- End: table_box -->
<?php endif; ?>

<?php if(!empty($get_meta->other)):?>
					<!-- Start: table_box -->
					<div id="table_box" class="d_table endline">
						<h4 class="d_tablecell odd">その他<br /><img class="mgnT8" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/other.png" /></h4>
						<table class="f_left">
							<!-- PC、タブレット -->
							<tr class="endtr mob_none mob_small_none">
								<th scope="row" class="other">備考</th>
								<td><?php echo $get_meta->other ?></td>
							</tr>
							<!-- モバイル -->
							<tr class="pc_none tab_none">
								<th scope="row" class="other">備考</th>
								<td></td>
							<tr class="endtr pc_none tab_none">
								<td colspan="2"><?php echo $get_meta->other ?></td>
							</tr>

						</table>
					</div>
					<!-- End: table_box -->
<?php endif;?>
					<div id="detail_link" class="mgnT16">
					<div class="row">
						<a href="<?php echo home_url(); ?>/estimate?estid=<?php echo $get_meta->post_id; ?>">
							<div class="col-md-4 col-sm-4 col-xs-12 detail_btn">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/detail_link06.png" alt="この学校の留学費用を自動で見積もる" class="detail_btnimg"><br/>この学校の留学費用を自動で見積もる
							</div>
						</a>
						<a href="<?php echo esc_url(home_url());?>/inquiry">
							<div class="col-md-4 col-sm-4 col-xs-12 detail_btn">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/detail_link07.png" alt="この学校について問い合わせる" class="detail_btnimg"><br/>この学校について問い合わせる
							</div>
						</a>
						<a href="<?php echo esc_url(home_url());?>/apply?aplid=<?php echo $get_meta->post_id; ?>">
							<div class="col-md-4 col-sm-4 col-xs-12 detail_btn2">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/detail_link08.png" alt="この学校に申し込む" class="detail_btnimg"><br/>この学校に申し込む
							</div>
						</a>
					</div>
					</div>
				</div>

					<!--  ▲▲▲▲▲▲▲▲▲▲  --->
					<!-- 　　 タブきりかえ
					<!--  ▼▼▼▼▼▼▼▼▼▼  --->

				<div id="review_tab" class="tab"></div>
			</div>
		</div>
		<div class="clear"></div>
		<p class="f_right link_sankaku_school mgnT8"><a href="<?php echo home_url(); ?>/schoolreport?repoid=<?php echo $get_meta->post_id; ?>">学校情報の間違いを報告する</a></p>
		<div id="info_banner" style="padding-top:38px;">
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

</div>


	<div class="container">
		<?php include(get_theme_root() . '/' . get_template() . "/common-inquiry.php");?>
	</div>
