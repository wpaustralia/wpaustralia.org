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

get_header(); ?>
<?php
	if( function_exists( 'et_pb_is_pagebuilder_used' ) ) {
		$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );
	}
?>

<?php if ( ! $is_page_builder_used ) { ?>

	<div id="maincontentcontainer">
		<?php	do_action( 'maddisondesigns_before_woocommerce' ); ?>
		<div id="primary" class="site-content row" role="main">

			<div class="col grid_8_of_12">

				<?php if ( have_posts() ) : ?>

					<?php // Start the Loop ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'page' ); ?>
					<?php endwhile; ?>

				<?php endif; // end have_posts() check ?>

			</div> <!-- /.col.grid_8_of_12 -->
			<?php get_sidebar(); ?>

		</div> <!-- /#primary.site-content.row -->
		<?php	do_action( 'maddisondesigns_after_woocommerce' ); ?>
	</div> <!-- /#maincontentcontainer -->

<?php } else { ?>

	<div id="maincontentcontainer">
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'builderfullwidth' ); ?>
			<?php endwhile; // end of the loop. ?>

		<?php endif; // end have_posts() check ?>
	</div> <!-- /#maincontentcontainer -->

<?php } ?>

<?php get_footer(); ?>
