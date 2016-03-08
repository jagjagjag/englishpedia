<?php
/**
 Template Name: お役立ち情報
 */
wp_head();
the_post();
get_header();
?>
<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/post.css' ); ?>"/>
<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/post_ryugaku.css' ); ?>"/>

<?php /**
	//if( (strpos($_SERVER['HTTP_USER_AGENT'], "iPhone")) == false and
	//	(strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) == false and
	if ( (strpos($_SERVER['HTTP_USER_AGENT'], "iPad")) == true ) {
	//	(strpos($_SERVER['HTTP_USER_AGENT'], "Android")) == false )  {
	$padding80 = 'style="padding-left: 80px !important"'; 
	} else { $padding80 = ''; }
 **/ ?>

<!-- Start: contents -->
	<div class="container">
		<div class ="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <img src="https://www.englishpedia.jp/wordpress/wp-content/themes/engp/images/tit_posts.jpg" style="width: 100%;" class="post_title_l">
            <p class="post_title_s">知らなきゃ損する留学の豆知識</p>
            </div>
        </div>
		<div class ="row">
			<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<!--<div class="post_title"><?php the_title(); ?></div>-->
					<!--<div class="posttitle_hr"></div> -->
					<div class="post-content">
						<?php the_content(); ?>
					</div>			
			</div>
			<div id="sidebar_area" class="sidebar col-lg-3 col-md-3 col-sm-4 col-xs-12">
				<?php get_sidebar(2); ?>			
			</div>
		</div>
		<div class ="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
					<!-- Start: バナー -->										
					<div class="other_bn">
		            <a href="//nes-ryugaku.com/event_seminar2_all.php"><img class="hidden-xs" src="<?php echo esc_url( get_template_directory_uri()); ?>/images/bn_seminar_long.png" alt="アメリカ現地留学説明会"></a>
					<a href="//nes-ryugaku.com/event_seminar2_all.php"><img class="hidden-md hidden-sm hidden-lg" src="<?php echo esc_url( get_template_directory_uri()); ?>/images/bn_seminar_mob.png" alt="アメリカ現地留学説明会"></a>
					</div>
					<!-- End: バナー -->
		
					<!-- Start: お問い合わせください -->
					<div class="row" id="contact_box">
					<strong><p style="font-size: 20px; color:#114D9C; text-align:center; line-height: 1.3em">イングリッシュペディアは語学学校の専門サイト<br>
					情報収集・料金の自動見積り・申込みが出来ます！</p></strong>	
						<div class="col-md-6 col-sm-6 col-xs-12" id="contact_box_fff" style="margin:0px; padding:10px;">
							<p>「留学はしたいが具体的なプランが決まっていない」「留学に行きたい気持ちはあるが…」まだ留学のプランがおぼろげでも、お気軽にお問い合わせください。<br> 経験豊富なカウンセラーが親身になってお答えいたします。</p>
					<strong><p style="font-size: 18px;">まずはお気軽にお問い合わせください！</p></strong>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/contact_byphone02.png" alt="お電話でのお問い合わせはこちらから" class="bud_margintop"/>
							<div class="btndeco3"><a href="<?php echo esc_url(home_url());?>/counseling/">無料留学カウンセリングに申し込む</a></div>
						</div>
		            </div>
					<!-- End: お問い合わせください -->
			</div>
		</div>
	</div>
	<!-- .post-content -->
	<footer class="post-meta">
		<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .post-meta -->
	</article><!-- #post -->
	
</div>
<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>