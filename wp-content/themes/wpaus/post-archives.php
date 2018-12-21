<?php
/**
 * Template Name: Posts Archive Template
 *
 * Description: Displays an archive of posts, ordered by date.
 */

get_header(); ?>

	<div id="maincontentcontainer">
		<?php	do_action( 'maddisondesigns_before_woocommerce' ); ?>
		<div id="primary" class="site-content row" role="main">

			<div class="col grid_8_of_12">

				<?php if ( have_posts() ) : ?>

					<?php // Start the Loop ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'postarchives' ); ?>
					<?php endwhile; ?>

				<?php else : ?>

					<?php get_template_part( 'no-results' ); // Include the template that displays a message that posts cannot be found ?>

				<?php endif; // end have_posts() check ?>

			</div> <!-- /.col.grid_8_of_12 -->
			<?php get_sidebar(); ?>

		</div> <!-- /#primary.site-content.row -->
		<?php	do_action( 'maddisondesigns_after_woocommerce' ); ?>
	</div> <!-- /#maincontentcontainer -->

<?php get_footer(); ?>
