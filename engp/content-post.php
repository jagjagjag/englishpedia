<?php
/**
 * The template used for displaying page content in page.php
 */
wp_head();
get_header();


?>
<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/post.css' ); ?>"/>
<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/post_ryugaku.css' ); ?>"/>

<!-- Start: contents -->
	<div class="container">
		<div class ="row">
			<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="post_title"><?php the_title(); ?></div>
					<div class="posttitle_hr"></div> 
					<div class="post-content">
						<?php the_content(); ?>
					</div>	
						<div id="menu_footer01">
							<ul class="snsb menu_foot1 mgnT16 clearfix">
								<li>
									<a href="https://b.hatena.ne.jp/entry/<?php echo home_url(); ?>" class="hatena-bookmark-button" data-hatena-bookmark-title="【EnglishPedia】語学留学学校比較サイト" data-hatena-bookmark-layout="standard-noballoon" data-hatena-bookmark-lang="en" title="このエントリーをはてなブックマークに追加">
										<img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" />
									</a>
								</li>
								<li>
									<g:plusone annotation="none" size="tall" href="<?php echo home_url(); ?>"></g:plusone>
								</li>
								<li>
									<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo home_url(); ?>" data-count="none">Tweet</a>
								</li>
								<li>
									<div class="fb-like" data-href="<?php echo home_url(); ?>" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>
								</li>
							</ul>
						</div>
			</div>
			<div id="sidebar_area" class="sidebar col-lg-3 col-md-3 col-sm-4 col-xs-12">
				<?php get_sidebar(); ?>			
			</div>
		</div>
		
<?php /** 	
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
			
					<?php if ( function_exists( 'wpsabox_author_box' ) ) echo wpsabox_author_box(); ?>
					
			</div>
		</div>		**/ ?>
		
		
		
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