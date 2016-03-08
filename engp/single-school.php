<?php
/**
 * The Template for displaying all single posts.
 *
 * @package englishpedia
 */

get_header();
?>

	<div id="primary" class="content-area">
		<div id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
			<?php  get_template_part( 'content', 'school' ); ?>
		<?php endwhile; // end of the loop. ?>

		<?php if(function_exists("echo_ald_wherego")) echo_ald_wherego(); ?>

		</div><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/content-school.js"></script>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/favorite.js"></script>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/modal.js"></script>
<script type="text/javascript">
<!--
$(document).ready(function(){
	favorite(0);
});
-->
</script>
<?php include(get_theme_root() . '/' . get_template() . "/inc/common-htmlclose.php");?>
