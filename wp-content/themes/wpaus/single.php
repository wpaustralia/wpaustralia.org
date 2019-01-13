<?php get_header(); ?>

<div id="maincontentcontainer">
	<div id="primary" class="site-content row" role="main">

		<div class="col grid_8_of_12">

		<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content' );

				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) {
					comments_template( '', true );
				}
			}
		?>

		</div> <!-- /.col.grid_8_of_12 -->
		<?php get_sidebar(); ?>

	</div> <!-- /#primary.site-content.row -->
</div> <!-- /#maincontentcontainer -->
<div class="postnavigationcontainer">
	<div class="site-content row post-navigation">
		<?php wpaus_content_nav( 'nav-below' ); ?>
	</div> <!-- /.site-content.row -->
</div>

<?php get_footer(); ?>
