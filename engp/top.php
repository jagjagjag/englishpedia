<?php
/*
 Template Name: トップ
*/
get_header();
$engp_master = engp_get_master();
$get_recommend = engp_school_recommend();
$rate_time = engp_get_rate_time();
$get_top_review = engp_school_review_top();
$get_epscore = engp_school_epscore();
?>

<div id="primary" class="content-area">
	<div id="main" class="site-main" role="main">

		<!-- Start: content_color -->
		<div class="content_color">
			<div class="container">
				<div class="row">
					<!-- Start: social_box -->
					<div class="col-md-12 col-xs-12" style="padding:0px; margin-bottom: 5px;">
						<div class="sns_box" align="right">
							<ul class="snsb mob_none" >
								<li class="mob_none"><a href="<?php echo home_url(); ?>/company"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/bn_guarantee.png' ); ?>" alt="業界最安値保証！" style="width:200px; height:25px;"></a></li>
								<li class="mob_none">
									<a
									href="https://b.hatena.ne.jp/entry/<?php echo home_url(); ?>"
									class="hatena-bookmark-button"
									data-hatena-bookmark-title="【語学留学学校比較サイト】EnglishPedia"
									data-hatena-bookmark-layout="standard-noballoon"
									data-hatena-bookmark-lang="en" title="このエントリーをはてなブックマークに追加">
									<img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png"
										alt="このエントリーをはてなブックマークに追加" width="20" height="20"
										style="border: none;" />
									</a>
								</li>
								<li class="mob_none"><g:plusone annotation="none" size="tall"
										href="<?php echo home_url(); ?>"></g:plusone>
								</li>
								<li class="mob_none"><a href="https://twitter.com/share"
									class="twitter-share-button"
									data-url="<?php echo home_url(); ?>"
									data-text="【語学留学のための学校情報比較サイト EnglishPedia】"
									data-count="none">Tweet</a>
								</li>
								<li class="mob_none">
									<div class="fb-like" data-href="<?php echo home_url(); ?>"
										data-layout="button" data-action="like"
										data-show-faces="false" data-share="true">
									</div>
								</li>
							</ul>
						</div>
						<!-- End: social_box -->
						<!-- モバイル用トップ画像、バナー -->
						<div id="mob_guide" class="col-xs-12 pc_none tab_none" style="padding:0px;">
							<a href="<?php echo esc_url(home_url());?>/company/"><img class="pc_none tab_none mgnB16 img-responsive mob_top_catchimg" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/mob_top_catch.png"></a>
						</div>
						<div class="hidden-lg hidden-md hidden-sm col-xs-6 mgnB16">
							<a href="<?php echo esc_url(home_url());?>/introduction/">
								<img width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/mob_banner01.png" alt="EnglishPediaの使い方" />
							</a>
						</div>
						<div class="hidden-lg hidden-md hidden-sm col-xs-6 mgnB16">
							<a href="<?php echo esc_url(home_url());?>/posts_info/">
								<img width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/mob_banner02.png" alt="留学情報まとめ" />
							</a>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-8">
						<!-- Start: map -->
						<div id="map" class="f_left row">
							<!-- Start: map_left -->
							<div id="map_left" class="f_left col-md-4 col-sm-12 col-xs-12">
								<div class="form-group" style="margin-bottom:0px;">
									<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
										<input type="hidden" name="s" id="s" placeholder="検索" />
										<input type="hidden" name="page" id="page" value="1" />

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

							<!-- Start: map_right -->
							<div id="map_right" class="col-md-8 col-sm-8 hidden-xs">

								<!-- ============= 世界地図 ============== -->
								<div id="dropmenu_seattle">
									<ul>
										<li><a href="<?php echo home_url(); ?>?s=&page=1&division=7">シアトル<span class="popup_top"><p class="map_popup_letter">スターバックス発祥の地。<br>涼しいエリアで勉強に集中！</p><p class="star_map">平均気温：11℃<br>都会度数　<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_map3.png" alt="都会度数3"></p></span></a></li>
									</ul>
								</div>
								<div id="dropmenu_chicago">
									<ul>
										<li><a href="<?php echo home_url(); ?>?s=&page=1&division=9">シカゴ<span class="popup_top"><p class="map_popup_letter">アメリカ第二の経済都市。<br>アジア人の少ない都会派にオススメ</p><p class="star_map">平均気温：9.5℃<br>都会度数　<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_map4.png" alt="都会度数4"></p></span></a></li>
									</ul>
								</div>
								<div id="dropmenu_boston">
									<ul>
										<li><a href="<?php echo home_url(); ?>?s=&page=1&division=4">ボストン<span class="popup_top"><p class="map_popup_letter">数多くの大学があり<br>教育の中心地としても<br>有名な都市</p><p class="star_map">平均気温：10.7℃<br>都会度数　<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_map3.png" alt="都会度数3"></p></span></a></li>
									</ul>
								</div>
								<div id="dropmenu_ny">
									<ul>
										<li><a href="<?php echo home_url(); ?>?s=&page=1&division=2">ニューヨーク<span class="popup_top"><p class="map_popup_letter">全米一の経済都市。<br>芸術・文化など<br>あらゆる分野で世界最高水準</p><p class="star_map">平均気温：12℃<br>都会度数　<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_map5.png" alt="都会度数5"></p></span></a></li>
									</ul>
								</div>

								<div id="dropmenu_sanfrancisco">
									<ul>
										<li><a href="<?php echo home_url(); ?>?s=&page=1&division=3">サンフランシスコ<span class="popup_top"><p class="map_popup_letter">西の玄関口。<br>港や公園、自然と文化に恵まれたオシャレな都市</p><p class="star_map">平均気温：13.9℃<br>都会度数　<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_map4.png" alt="都会度数4"></p></span></a></li>
									</ul>
								</div>
								<div id="dropmenu_other">
									<ul>
										<li><a href="<?php echo home_url(); ?>?s=&page=1&division=10">その他<span class="popup_top"><p class="map_popup_letter">イングリッシュペディアは<br>全米各地への留学をサポート！<br>お気軽にご相談ください。</p></span></a></li>
									</ul>
								</div>
								<div id="dropmenu_losangels">
									<ul>
										<li><a href="<?php echo home_url(); ?>?s=&page=1&division=1">ロサンゼルス<span class="popup_top"><p class="map_popup_letter">暖かい気候と<br>エンターテインメントに富み、<br>全米ナンバー1の人気都市！</p><p class="star_map">平均気温：18℃<br>都会度数　<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_map4.png" alt="都会度数4"></p></span></a></li
									></ul>
								</div>
								<div id="dropmenu_sandiego">
									<ul>
										<li><a href="<?php echo home_url(); ?>?s=&page=1&division=8">サンディエゴ<span class="popup_top"><p class="map_popup_letter">西海岸最南端の多民族都市</p><p class="star_map">平均気温：21℃<br>都会度数　<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_map3.png" alt="都会度数3"></p></span></a></li>
									</ul>
								</div>

								<div id="dropmenu_florida">
									<ul>
										<li><a href="<?php echo home_url(); ?>?s=&page=1&division=5">マイアミ<span class="popup_top"><p class="map_popup_letter">アジア人の少ないビーチサイドタウン。<br>バケーション目的の<br>現地人も集う都市</p><p class="star_map">平均気温：24.4℃<br>都会度数　<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_map3.png" alt="都会度数3"></p></span></a></li>
									</ul>
								</div>

								<div id="dropmenu_hawaii">
									<ul>
										<li><a href="<?php echo home_url(); ?>?s=&page=1&division=6">ハワイ<span class="popup_top"><p class="map_popup_letter">旅行だけじゃない！<br>留学地としても<br>人気のリゾートエリア</p><p class="star_map">平均気温：25℃<br>都会度数　<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_map2.png" alt="都会度数2"></p></span></a></li>
									</ul>
								</div>
								<div id="dropmenu_whichcity">
									<ul>
										<li><a href="<?php echo home_url(); ?>/city">各都市の詳細</a></li>
									</ul>
								</div>

							</div>
							<!-- End: map_right -->
						</div>
						<!-- End: map -->
					</div>

					<div class="col-md-4 hidden-sm hidden-xs" style="margin-bottom:16px">
						<!-- Start: facebookcomment -->
<?php
	if( (strpos($_SERVER['HTTP_USER_AGENT'], "iPhone")) !== false ||
		(strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) !== false ||
		(strpos($_SERVER['HTTP_USER_AGENT'], "iPad")) !== false ||
		(strpos($_SERVER['HTTP_USER_AGENT'], "Android")) !== false ) {
?>
						<a href="<?php echo home_url(); ?>/company"><img class="top_tab_banenr" src="<?php echo esc_url( get_template_directory_uri()); ?>/images/bn_sm_top01.png" alt="業界最安値保証"></a>
						<a href="<?php echo home_url(); ?>/inquiry"><img class="top_tab_banenr" src="<?php echo esc_url( get_template_directory_uri()); ?>/images/bn_sm_top02.png" alt="お問い合わせはこちらから"></a>

<?php }else{?>
<!--
						<div id="fbcom" class="f_left mgnB">
							<h1>ご利用者様の感想</h1>
							<dl>
								<div class="fb-comments" data-href="http://www.nes-ryugaku.com/"
									data-num-posts="1" data-width="100%" height="100%"
									order_by="reverse_time"></div>
							</dl>
						</div>
-->
						<div id="revcom_title" class="f_left">
							<h1 class="f_left">最新投稿レビュー</h1>

							<div id="revcom_body" class="f_left">
<?php
		foreach ($get_top_review as $key => &$val){
?>
<div id="revews">
				<p><b><?php echo(esc_html($val->open_name)); ?></b>さん(<?php echo(date( "Y年m月d日", strtotime($val->regist_date) ) ) ;?>)<br>
				<a href="<?php echo home_url(); ?>?school=<?php echo $val->post_id; ?>"><?php echo($val->school_name);?></a><br>
				<img width="70px" src="<?php echo(esc_url( get_template_directory_uri() ) . '/images/star_s' . $val->satisfaction_evaluation . '0.png');?>"><br>
<?php
			if($val->selected_comment == null){
				if(mb_strlen($val->comment,'SJIS') > 163){
					$short_comment = mb_strimwidth($val->comment, 0, 163, '...');
					$short_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $short_comment);
					echo nl2br(esc_html($short_comment));
				}else{
					$change_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $val->comment);
					echo nl2br(esc_html($change_comment));
				};
			}else{
				if(mb_strlen($val->selected_comment,'SJIS') > 163){
					$short_selected_comment = mb_strimwidth($val->selected_comment, 0, 163, '...');
					$short_selected_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $short_selected_comment);
					echo nl2br(esc_html($short_selected_comment));
				}else{
					$change_comment = preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "", $val->selected_comment);
					echo nl2br(esc_html($change_comment));
				};
			}
			echo "<br>";
			if($val->photo_name !== null){
				$files = $val -> photo_name;
				$file_list = explode(',',$files);
				array_pop($file_list);
				$approved_dir = PHOTO_URL.$val -> post_id.'/approved/';
				$result = "";
				foreach($file_list as $photo_file){
					$result .= '<a href='.$approved_dir.$photo_file.' onClick="window.open(this.href,\'pop\',\'location=no\');return false;">' . PHP_EOL;
					$result .= '<img border="0" src='.$approved_dir.$photo_file.' width="49" height="49" align="left">' . PHP_EOL;
					$result .= '</a>' . PHP_EOL;
				}
				echo $result;
			}
?>
</p></div>
<?php
		}
?>

							</div>
						</div>
<?php } ?>
						<!-- End: facebookcomment -->
						<!-- Start: excgabgeRate -->
						<div id="exchange_title" class="f_left">
							<h1 class="f_left">為替レート</h1>
							<h3 class="pc_tab_none"><?php echo $rate_time; ?>時現在の参考レートです</h3>
							<h3 class="pc_tab_exchange"><?php echo $rate_time; ?>時現在の<br>参考レートです</h3>

							<div id="exchange_body" class="f_left">
								<p id="exchange_rate"></p>
							</div>
						</div>
						<!-- End: excgabgeRate -->
					</div>
				</div>
			</div>
		</div>
		<!-- End: content_color -->

		<div class="container">
        <h1 class="mob_headline hidden-lg hidden-md hidden-sm">カテゴリーで探す</h1>
			<div class="row">
				<div id="mobile_search" class="col-md-4" style="margin-bottom:16px;">
				<div class="pc_none tab_none mgnT16 mgnB5" style="text-align:center;">

					<div class="hidden-lg hidden-md hidden-sm　col-xs-12 mobsearch">
						<a href="<?php echo home_url(); ?>/?s=&page=1&fee=1">格安の学校</a>
					</div>
					<div class="hidden-lg hidden-md hidden-sm　col-xs-12 mobsearch">
						<a href="<?php echo home_url(); ?>/?s=&page=1&nationality=1">国籍バランスのいい学校</a>
					</div>
					<div class="hidden-lg hidden-md hidden-sm　col-xs-12 mobsearch">
						<a href="<?php echo home_url(); ?>/?s=&page=1&location[]=1">都会にある学校</a>
					</div>
<!-- 					<div class="hidden-lg hidden-md hidden-sm　col-xs-12 mobsearch">
						<a href="<?php // echo home_url(); ?>/?s=&page=1&location[]=2">郊外にある学校</a>
						</div> -->

				</div>

					<div id="info_banner2">
						<div class="row">
							<div class="col-md-12 col-sm-6 hidden-xs mob_top_banner_right">
								<a href="<?php echo esc_url(home_url());?>/introduction/">
									<img class="mgnT20" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner01.png" alt="EnglishPediaの使い方" />
								</a>
							</div>
							<div class="col-md-12 col-sm-6 hidden-xs mob_top_banner_center">
								<a href="<?php echo esc_url(home_url());?>/posts_info/">
									<img class="mgnT20" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner02.png" alt="留学情報まとめ" />
								</a>
							</div>
							<div class="hidden-md hidden-sm col-xs-12">
								<a href="<?php echo esc_url(home_url());?>/inquiry/">
									<img class="mgnT20 pc_none tab_none" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/mob_banner06-2.png" alt="お問合せ" />
								</a>
							</div>

						</div>
					</div>
				</div>

				<div class="col-md-8" style="margin-top:7px;">

				  <div id="infomeeting" class="row tab_semi hidden-md">
						<div class="col-md-6 col-ms-6 col-ms-12" style="margin-top:7px;">
							<dl>
<?php
	if( (strpos($_SERVER['HTTP_USER_AGENT'], "iPhone")) !== false ||
		(strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) !== false ||
		(strpos($_SERVER['HTTP_USER_AGENT'], "iPad")) !== false ||
		(strpos($_SERVER['HTTP_USER_AGENT'], "Android")) !== false ) {
?>
								<a href="https://nes-ryugaku.com/event_seminar2_all.php" target="blank"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/img_seminar.png" class="pc_none seminer_img" alt="無料 アメリカ現地留学説明会" width="100%" ></a>
<?php }else{ ?>
								<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/img_seminar.png" class="mob_none seminer_img" alt="無料 アメリカ現地留学説明会" width="100%" >
								<a href="https://nes-ryugaku.com/event_seminar2_all.php" target="blank"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/img_seminar.png" class="pc_none tab_none seminer_img" alt="無料 アメリカ現地留学説明会" width="100%" ></a>
<?php } ?>
							</dl>
						</div>
						<div class="col-md-6 col-ms-6 hidden-xs" style="padding:0;">
							<dl>
								<div class="top_seminor top_seminor_box">
									<h1>無料留学説明会 <p class="top_seemore"><a href="http://nes-ryugaku.com/event_seminar2_all.php" target="_blank">詳しくはこちら</a></h1>
									<iframe src="http://nes-ryugaku.com/seminar/lste2_engp.php" name="in" width="99%" marginwidth="0" height="100%" marginheight="0" frameborder="0" id="in"></iframe>
								</div>
							</dl>
						</div>
				</div>


				<div id="infomeeting" class="f_left tab_semi hidden-xs hidden-lg hidden-sm">
						<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/img_seminar_long.png" class="mob_none tab_none seminer_img" alt="無料 アメリカ現地留学説明会" width="100%" >
						<a href="https://nes-ryugaku.com/event_seminar2_all.php" target="blank"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/img_seminar_long.png" class="pc_none seminer_img" alt="無料 アメリカ現地留学説明会" width="100%" ></a>
				</div>
			<!-- End: infomeeting -->
			</div>

			<div id="info_banner" class="hidden-xs">
				<div class="row row_ranking">
				<!-- s:人気学校ランキング修正箇所 -->
				<!-- <div class="col-md-7"> -->
				<!-- e:人気学校ランキング修正箇所 -->
									
					<div class="col-md-8 new_rank_box">
						<h4 class="new_rank_title"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/new_rank_title.png" style="width:33px;" > EnglishPedia学校ランキング</h4>
						<!-- Start: ranking -->
						<div class="row">
						<div id="ranking" class="f_left col-md-6 col-sm-6 r_border">
							<h1 class="student">留学生に人気</h1>

							<!-- Start: ranking_box -->
							<div id="ranking_box">
								<!-- Start: rankings -->
<?php
	$i=1;
	foreach ($get_recommend as $key => &$val):
?>
								<div id="rankings">
									<!-- Start: ranking_summary -->
									<div id="ranking_summary" class="f_left">
										<h2 class="f_left">
											<?php if($i <= 3):?>
												<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/rank_<?php echo $i;?>.png" style="width:30px; margin-top:-5px;">
											<?php else:?>
												<?php echo $i; ?>
											<?php endif;?>
										</h2>
										<?php $i++;?>
										<a href="<?php echo home_url(); ?>?school=<?php echo $val->post_id; ?>">
											<h4><?php echo $val->school_name; ?></h4>
										</a>

<?php
		$image_post_id = get_post_meta( $val->post_id, 'my_upload_images', true );
		if(!empty($image_post_id[0])):
			$rank_image = wp_get_attachment_image_src($image_post_id[0], array(90,90));
?>
										<img class="f_left ranking_photo" style="width: 90px; height: 90px;" src="<?php echo $rank_image[0]; ?>" alt="Photo">
<?php else: ?>
										<img class="f_left ranking_photo" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/nophoto_90x90.jpg" alt="Photo">
<?php endif; ?>
										<!-- Start: category -->
										<div id="category">
<?php $review_data = engp_get_review_star($val->post_id);?>
									<!-- s:スタッフ評価:星画像 -->
										<p class="epscore">EPスコア</p>									
										<img class="staff_eval" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_staff<?php echo $val->staff_evaluation;?>.png">
									<!-- e:スタッフ評価:星画像 -->																						
										<?php if($review_data['review_sum'] != 0):?>
											<p class="rev_ave">留学生の満足度:<span><?php echo round($review_data['review_ave'],1)?> / 5</span></p>
										<?php endif;?>
											<p>
												<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/america_info.png" alt="<?php echo $engp_master['country'][$val->country]; ?>">
												<?php echo $engp_master['division'][$val->division]; ?>
											</p>
<?php
// 	$outputHtml = '';
// 	if($val->target_ESL){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_esl.png" alt="ESL">';
// 	}
// 	if($val->target_TOEFL){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_toefl.png" alt="TOEFL">';
// 	}
// 	if($val->target_TOEIC){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_toeic.png" alt="TOEIC">';
// 	}
// 	if($val->target_advance){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_advance.png" alt="advance">';
// 	}
// 	if($val->target_business){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_business.png" alt="business">';
// 	}
// 	if($val->target_child){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_child.png" alt="child">';
// 	}
// 	if($val->target_adult){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_adult.png" alt="adult">';
// 	}
// 	if($val->target_ILETS){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_ilets.png" alt="ILETS">';
// 	}
// 	if($val->target_so){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_sp_offer.png" alt="sp_offer">';
// 	}
// 	echo $outputHtml;
?>
										</div>
										<!-- End: category -->
									</div>
									<!-- End: ranking_summary -->

									<!-- Start: ranking_info -->
									
<!-- s:人気学校ランキング修正箇所 -->									
<!-- 									<div id="ranking_info" class="f_left"> -->
<!-- 										<p> -->
<?php
// 	if(mb_strlen($val->outline,'SJIS') > 220){
// 		echo mb_strimwidth($val->outline, 0, 225, '...');
// 	}else{
// 		echo $val->outline ."　";
// 	}
// 	echo "<a href=". home_url() ."?school=". $val->post_id .">[詳細]</a>";
?>
<!-- 										</p> -->
<!-- 									</div> -->

<!-- e:人気学校ランキング修正箇所 -->
									<!-- End: ranking_info -->
								</div>
								<!-- End: rankings -->
<?php endforeach; ?>
							</div>
							<!-- End: ranking_box -->

							<!-- Start: infomeeting_link -->
							<div id="infomeeting_link">
								<p class="r_botton"></p>
							</div>
							<!-- End: infomeeting_link -->
						</div>
						<!-- End: ranking -->
<!-- 					</div> -->

<!-- s:人気学校ランキング修正箇所 -->																			
			
										<div class="col-md-6 col-sm-6">				
						<!-- Start: ranking -->
						<div id="ranking" class="f_left">
							<h1 class="staff">EPスコアが高い</h1>

							<!-- Start: ranking_box -->
							<div id="ranking_box">
								<!-- Start: rankings -->
<?php
	$i=1;
	foreach ($get_epscore as $key => &$val):
?>
								<div id="rankings">
									<!-- Start: ranking_summary -->
									<div id="ranking_summary" class="f_left">
										<h2 class="f_left">
											<?php if($i <= 3):?>
												<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/rank_<?php echo $i;?>.png" style="width:30px; margin-top:-5px;">
											<?php else:?>
												<?php echo $i; ?>
											<?php endif;?>
										</h2>
										<?php $i++;?>
										<a href="<?php echo home_url(); ?>?school=<?php echo $val->post_id; ?>">
											<h4><?php echo $val->school_name; ?></h4>
										</a>
<?php
		$image_post_id = get_post_meta( $val->post_id, 'my_upload_images', true );
		if(!empty($image_post_id[0])):
			$rank_image = wp_get_attachment_image_src($image_post_id[0], array(90,90));
?>
										<img class="f_left ranking_photo" style="width: 90px; height: 90px;" src="<?php echo $rank_image[0]; ?>" alt="Photo">
<?php else: ?>
										<img class="f_left ranking_photo" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/nophoto_90x90.jpg" alt="Photo">
<?php endif; ?>
										<!-- Start: category -->
										<div id="category">
<?php $review_data = engp_get_review_star($val->post_id);?>
									<!-- s:スタッフ評価:星画像 -->
										<p class="epscore">EPスコア</p>
										<img class="staff_eval" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/star_staff<?php echo $val->staff_evaluation;?>.png">
									<!-- e:スタッフ評価:星画像 -->																						
										<?php if($review_data['review_sum'] != 0):?>
											<p class="rev_ave">留学生の満足度:<span><?php echo round($review_data['review_ave'],1)?> / 5</span></p>
										<?php endif;?>
											<p>
												<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/america_info.png" alt="<?php echo $engp_master['country'][$val->country]; ?>">
												<?php echo $engp_master['division'][$val->division]; ?>
											</p>
<!-- s:コースアイコン -->											
<?php
// 	$outputHtml = '';
// 	if($val->target_ESL){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_esl.png" alt="ESL">';
// 	}
// 	if($val->target_TOEFL){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_toefl.png" alt="TOEFL">';
// 	}
// 	if($val->target_TOEIC){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_toeic.png" alt="TOEIC">';
// 	}
// 	if($val->target_advance){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_advance.png" alt="advance">';
// 	}
// 	if($val->target_business){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_business.png" alt="business">';
// 	}
// 	if($val->target_child){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_child.png" alt="child">';
// 	}
// 	if($val->target_adult){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_adult.png" alt="adult">';
// 	}
// 	if($val->target_ILETS){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_ilets.png" alt="ILETS">';
// 	}
// 	if($val->target_so){
// 		$outputHtml .= '<img class="category_img" src="'.get_template_directory_uri().'/images/category_sp_offer.png" alt="sp_offer">';
// 	}
// 	echo $outputHtml;
?>
<!-- e:コースアイコン -->											
										</div>
										<!-- End: category -->
									</div>
									<!-- End: ranking_summary -->
									<!-- End: ranking_info -->
								</div>
								<!-- End: rankings -->
<?php endforeach; ?>
							</div>
							<!-- End: ranking_box -->

							<!-- Start: infomeeting_link -->
							<div id="infomeeting_link">
								<p class="r_botton"></p>
							</div>
							<!-- End: infomeeting_link -->
						</div>
						<!-- End: ranking -->
					</div>
					</div></div>
									<!-- e:人気学校ランキング修正箇所 -->																			
					
<!-- s:人気学校ランキング修正箇所 -->														
<!-- 					<div class="col-md-5 hidden-xs"> -->
					<div class="col-md-4 hidden-xs">					
<!-- e:人気学校ランキング修正箇所 -->														
						<!-- Start: facebook -->
						<div id="facebook" class="f_right" style="width: 100%; padding:0px;">
							<div id="fb-root"></div>
<!-- 							<script>
								(function(d, s, id) {
									var js, fjs = d.getElementsByTagName(s)[0];
									if (d.getElementById(id))
										return;
									js = d.createElement(s);
									js.id = id;
									js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.0";
									fjs.parentNode.insertBefore(js, fjs);
								}(document, 'script', 'facebook-jssdk'));
							</script>
							<div class="fb-like-box"
								data-href="https://www.facebook.com/ryugaku1" data-width="456"
								data-height="706" data-colorscheme="light"
								data-show-faces="false" data-header="false" data-stream="true"
								data-show-border="false"></div>
							</div>
-->
							<div id="fb-root"></div>
							<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.4&appId=633193106697296";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));</script>
							<div class="fb-page" data-href="https://www.facebook.com/ryugaku1" data-width="500" data-height="807" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/ryugaku1"><a href="https://www.facebook.com/ryugaku1">留学</a></blockquote></div></div>							
						<!-- End: facebook -->
						</div>
					</div>
				</div>
			</div>
			<div id="info_banner">
				<div class="row">
					<div class="col-md-4 col-ms-4 col-xs-4 mob_top_banner_right">
						<a href="<?php echo home_url(); ?>/budget">
							<img class="mgnT20 mob_none" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner03.png" alt="留学費用の相場" />
							<img class="mgnT20 pc_none tab_none" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/mob_banner03.png" alt="留学費用の相場" />
						</a>
					</div>
					<div class="col-md-4 col-ms-4 col-xs-4 mob_top_banner_center" >
						<a href="<?php echo home_url(); ?>/city">
							<img class="mgnT20 mob_none" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner04.png" alt="各都市の詳細" />
							<img class="mgnT20 tab_none pc_none" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/mob_banner04.png" alt="各都市の詳細" />
						</a>
					</div>
					<div class="col-md-4 col-ms-4 col-xs-4 mob_top_banner_left" >
						<a href="<?php echo home_url(); ?>/langageschool">
							<img class="mgnT20 mob_none" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/banner05.png" alt="学校関係者の方へ" />
							<img class="mgnT20 tab_none pc_none" width="100%" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/mob_banner05.png" alt="学校関係者の方へ" />
						</a>
					</div>
				</div>
			</div>

<?php include(get_theme_root() . '/' . get_template() . "/inc/common-inquiry.php");?>

<!-- 		<div id="facebook_friend">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div id="fb-root" class="mgnT40"></div>
						<script>
							(function(d, s, id) {
								var js, fjs = d.getElementsByTagName(s)[0];
								if (d.getElementById(id)) return;
								js = d.createElement(s); js.id = id;
								js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.0";
								fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));
						</script>
						<div class="fb-like-box fb_iframe_widget"
							data-href="https://www.facebook.com/ryugaku1" data-width="1100"
							data-colorscheme="light" data-show-faces="true" data-header="false"
							data-stream="false" data-show-border="false"
							fb-xfbml-state="rendered"
							fb-iframe-plugin-query="app_id=&amp;color_scheme=light&amp;header=false&amp;href=https%3A%2F%2Fwww.facebook.com%2Fryugaku1&amp;locale=ja_JP&amp;sdk=joey&amp;show_border=false&amp;show_faces=true&amp;stream=false&amp;width=1080">
							<span style="vertical-align: bottom; width: 100%; height: 241px;">
								<iframe name="f102c0830" width="1100px" height="1000px"
									frameborder="0" allowtransparency="true" scrolling="no"
									title="fb:like_box Facebook Social Plugin"
									src="//www.facebook.com/v2.0/plugins/like_box.php?app_id=&amp;channel=http%3A%2F%2Fstatic.ak.facebook.com%2Fconnect%2Fxd_arbiter%2FKFZn1BJ0LYk.js%3Fversion%3D41%23cb%3Df1c43d86a8%26domain%3D153.121.51.162%26origin%3Dhttp%253A%252F%252F153.121.51.162%252Ff8ea23ad8%26relation%3Dparent.parent&amp;color_scheme=light&amp;header=false&amp;href=https%3A%2F%2Fwww.facebook.com%2Fryugaku1&amp;locale=ja_JP&amp;sdk=joey&amp;show_border=false&amp;show_faces=true&amp;stream=false&amp;width=1080"
									style="border: none; visibility: visible; width: 1080px; height: 241px;"
									class=""></iframe>
							</span>
						</div>
											</div>
				</div>
-->
			</div>
	</div>
	<!-- #main -->
</div>
<!-- #primary -->
<?php get_footer(); ?>
<script src="<?php echo esc_url( get_template_directory_uri() . '/js/top.js' ); ?>"></script>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
