<?php
/**
 * The template used for displaying page content in page.php
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( !is_front_page() ) { ?>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php if ( has_post_thumbnail() && !is_search() && !post_password_required() ) { ?>
				<?php the_post_thumbnail( 'post_feature_full_width' ); ?>
			<?php } ?>
		</header>
	<?php } ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'wpaus' ),
			'after' => '</div>',
			'link_before' => '<span class="page-numbers">',
			'link_after' => '</span>'
		) ); ?>
	</div><!-- /.entry-content -->
</article><!-- /#post -->
