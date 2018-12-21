<?php
/**
 * The template for displaying an archive page for Tags.
 */

get_header(); ?>

	<div id="maincontentcontainer">
		<?php	do_action( 'maddisondesigns_before_woocommerce' ); ?>
		<div class="contentheadercontainer">
			<div class="content-header row">
				<div class="col grid_12_of_12">
					<?php if ( !is_front_page() ) { ?>
						<header class="entry-header">
							<h1 class="archive-title"><?php printf( esc_html__( 'Tag Archives: %s', 'maddisondesigns' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>
							<?php if ( tag_description() ) { // Show an optional tag description ?>
								<div class="archive-meta"><?php echo tag_description(); ?></div>
							<?php } ?>
						</header>
					<?php } ?>
				</div> <!-- /.col.grid_12_of_12 -->
			</div><!-- /.content-header.row -->
		</div>
		<div id="primary" class="site-content row" role="main">

			<div class="col grid_12_of_12">

				<?php if ( have_posts() ) : ?>

					<?php // Start the Loop ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>

					<?php maddisondesigns_content_nav( 'nav-below' ); ?>

				<?php else : ?>

					<?php get_template_part( 'no-results' ); // Include the template that displays a message that posts cannot be found ?>

				<?php endif; // end have_posts() check ?>

			</div> <!-- /.col.grid_12_of_12 -->

		</div> <!-- /#primary.site-content.row -->
		<?php	do_action( 'maddisondesigns_after_woocommerce' ); ?>
	</div> <!-- /#maincontentcontainer -->

<?php get_footer(); ?>
