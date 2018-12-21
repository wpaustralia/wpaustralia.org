<?php get_header(); ?>

<div id="maincontentcontainer">
	<div class="contentheadercontainer">
		<div class="content-header row">
			<div class="col grid_12_of_12">
				<header class="entry-header archive-header">
					<h1 class="archive-title"><?php
					if ( is_author() ) {
						the_post();
						printf( __( 'Author Archives: %s', 'wpaus' ), '<span class="vcard">' . get_the_author() . '</span>' );
					} elseif ( is_category() ) {
						printf( __( 'Category Archives: %s', 'wpaus' ), '<span class="cat-archive">' . single_cat_title( '', false ) . '</span>' );
					} elseif ( is_tag() ) {
						printf( __( 'Tag Archives: %s', 'wpaus' ), '<span>' . single_tag_title( '', false ) . '</span>' );
					} else {
						_e( 'Archives', 'wpaus' );
					}
					?></h1>

					<?php
					if ( is_author() ) {
						if ( get_the_author_meta( 'description' ) ) {
							get_template_part( 'author-bio' );
						}
						rewind_posts();
					} elseif ( is_category() ) {
						if ( category_description() ) {
							echo '<div class="archive-meta">', category_description(), '</div>';
						}
					} elseif ( is_tag() ) {
						if ( tag_description() ) {
							echo '<div class="archive-meta">', tag_description(), '</div>';
						}
					}
					?>
				</header>
			</div> <!-- /.col.grid_12_of_12 -->
		</div><!-- /.content-header.row -->
	</div>
	<div id="primary" class="site-content row" role="main">

		<div class="col grid_8_of_12">

		<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'content' );
				}

				wpaus_content_nav( 'nav-below' );
			} else {
				get_template_part( 'no-results' );
			}
		?>

		</div> <!-- /.col.grid_8_of_12 -->
		<?php get_sidebar(); ?>

	</div> <!-- /#primary.site-content.row -->
</div> <!-- /#maincontentcontainer -->

<?php get_footer(); ?>
