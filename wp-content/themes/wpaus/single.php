<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

	<div id="maincontentcontainer">
		<?php	do_action( 'maddisondesigns_before_woocommerce' ); ?>
		<div id="primary" class="site-content row" role="main">

				<div class="col grid_8_of_12">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', get_post_format() ); ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) {
							comments_template( '', true );
						}
						?>

						<?php //maddisondesigns_content_nav( 'nav-below' ); ?>

					<?php endwhile; // end of the loop. ?>

				</div> <!-- /.col.grid_8_of_12 -->
				<?php get_sidebar(); ?>

		</div> <!-- /#primary.site-content.row -->
		<?php	do_action( 'maddisondesigns_after_woocommerce' ); ?>
	</div> <!-- /#maincontentcontainer -->
	<div class="postnavigationcontainer">
		<div class="site-content row post-navigation">
			<?php maddisondesigns_content_nav( 'nav-below' ); ?>
		</div> <!-- /.site-content.row -->
	</div>

<?php get_footer(); ?>
