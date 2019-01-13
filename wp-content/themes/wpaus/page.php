<?php get_header(); ?>

<div id="maincontentcontainer">
	<div id="primary" class="site-content row" role="main">

		<div class="col grid_8_of_12">
			<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'content', 'page' );
				}
			?>
		</div> <!-- /.col.grid_12_of_12 -->
		<?php get_sidebar(); ?>

	</div> <!-- /#primary.site-content.row -->
</div> <!-- /#maincontentcontainer -->

<?php
get_footer();
