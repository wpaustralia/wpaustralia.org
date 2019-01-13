<?php get_header(); ?>

<div id="maincontentcontainer">
	<div id="primary" class="site-content row" role="main">

		<div class="col grid_12_of_12">

			<article id="post-0" class="post error404 no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><i class="fa fa-frown-o fa-lg"></i> <?php _e( 'Uh Oh! This is somewhat embarrassing!', 'wpaus' ); ?></h1>
				</header>
				<div class="entry-content">
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'wpaus' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- /.entry-content -->
			</article><!-- /#post -->

		</div> <!-- /.col.grid_12_of_12 -->

	</div> <!-- /#primary.site-content.row -->
</div> <!-- /#maincontentcontainer -->

<?php get_footer(); ?>
