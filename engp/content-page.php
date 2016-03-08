<?php
/**
 * The template used for displaying page content in page.php
 */
wp_head();
get_header();
?>
<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/css/default.css' ); ?>"/>

<!-- Start: contents -->
	<div class="container">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class ="container">
				<header class="entry-header">
					<h1 class="entry_title"><?php the_title(); ?></h1>
					<div class="entrytitle_hr"></div> 
				</header>
				<div class="entry-content">
					<?php the_content(); ?>
					<!-- Start: バナー -->										
					<div class="other_bn">
		            <a href="//nes-ryugaku.com/event_seminar2_all.php"><img class="hidden-xs" src="<?php echo esc_url( get_template_directory_uri()); ?>/images/bn_seminar_long.png" alt="アメリカ現地留学説明会"></a>
					<a href="//nes-ryugaku.com/event_seminar2_all.php"><img class="hidden-md hidden-sm hidden-lg" src="<?php echo esc_url( get_template_directory_uri()); ?>/images/bn_seminar_mob.png" alt="アメリカ現地留学説明会"></a>
					</div>
					<!-- End: バナー -->
		
					<!-- Start: お問い合わせください -->
					<div class="row" id="contact_box">
						<h3>まずはお気軽にお問い合わせください！</h3>
						<div class="col-md-6 col-sm-6 col-xs-12" id="contact_box_fff" style="margin:0px; padding:10px;">
							<p>「留学はしたいが具体的なプランが決まっていない」「留学に行きたい気持ちはあるが…」まだ留学のプランがおぼろげでも、お気軽にお問い合わせください。<br> 経験豊富なカウンセラーが親身になってお答えいたします。</p>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/contact_byphone02.png" alt="お電話でのお問い合わせはこちらから" class="bud_margintop"/>
							<div class="btndeco3"><a href="<?php echo esc_url(home_url());?>/counseling/">無料留学カウンセリングに申し込む</a></div>
						</div>
		            </div>
					<!-- End: お問い合わせください -->
					
				</div>
			</div><!-- .entry-content -->
			<footer class="entry-meta">
				<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-meta -->
		</article><!-- #post -->
	
	</div>
<?php get_footer(); ?>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>