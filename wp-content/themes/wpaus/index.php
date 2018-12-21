<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

// If someone tries to access our index.php file directly, redirect them to the homepage
if ( function_exists( 'get_header' ) ) {
	get_header();
} else {
	/* Redirect browser */
	header( "Location: http://" . $_SERVER['HTTP_HOST'] );
	exit;
}
?>

	<div id="maincontentcontainer">
		<?php	do_action( 'maddisondesigns_before_woocommerce' ); ?>
		<div id="primary" class="site-content row" role="main">

			<?php if( is_home() ) { ?>
				<div class="col grid_12_of_12">
			<?php } else { ?>
				<div class="col grid_8_of_12">
			<?php } ?>

				<?php if ( have_posts() ) : ?>

					<?php // Start the Loop ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); // Include the Post-Format-specific template for the content ?>
					<?php endwhile; ?>

					<?php maddisondesigns_content_nav( 'nav-below' ); ?>

				<?php else : ?>

					<?php get_template_part( 'no-results' ); // Include the template that displays a message that posts cannot be found ?>

				<?php endif; // end have_posts() check ?>

			</div> <!-- /.col -->
			<?php if( !is_home() ) {
				get_sidebar();
			} ?>

		</div> <!-- /#primary.site-content.row -->
		<?php	do_action( 'maddisondesigns_after_woocommerce' ); ?>
	</div> <!-- /#maincontentcontainer -->

<?php get_footer(); ?>
