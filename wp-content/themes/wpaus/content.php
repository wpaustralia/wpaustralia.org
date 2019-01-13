<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( is_sticky() && is_home() && ! is_paged() ) { ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'wpaus' ); ?>
		</div>
	<?php } ?>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() && !is_search() ) { ?>
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wpaus' ), the_title_attribute( 'echo=0' ) ) ); ?>">
				<?php the_post_thumbnail( 'post_feature_full_width' ); ?>
			</a>
		<?php } ?>
		<?php if ( is_singular() ) { ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php } else { ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wpaus' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
		<?php } // is_single() ?>
		<?php wpaus_posted_on(); ?>
	</header> <!-- /.entry-header -->

	<?php if ( is_search() ) { // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div> <!-- /.entry-summary -->
	<?php }
	else { ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav"><i class="fa fa-angle-right"></i></span>', 'wpaus' ) ); ?>
			<?php wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'wpaus' ),
				'after' => '</div>',
				'link_before' => '<span class="page-numbers">',
				'link_after' => '</span>'
			) ); ?>
		</div> <!-- /.entry-content -->
	<?php } ?>

	<footer class="entry-meta">
		<?php if ( is_singular() ) {
			// Only show the tags on the Single Post page
			if ( get_the_tag_list() ) {
				$tag_list = get_the_tag_list( '<span class="post-tags">', __( ', ', 'wpaus' ), '</span>' );
				if ( $tag_list ) {
					printf( __( '<i class="fa fa-tag"></i> %1$s', 'wpaus' ), $tag_list );
				}
			}
		} ?>
		<?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) {
			// If a user has filled out their description and this is a multi-author blog, show their bio
			get_template_part( 'author-bio' );
		} ?>
	</footer> <!-- /.entry-meta -->
</article> <!-- /#post -->
