<?php
/**
 * The template for displaying posts in the Quote post format
 *
 * @package MaddisonDesigns
 * @since MaddisonDesigns 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php maddisondesigns_posted_on(); ?>
	</header> <!-- /.entry-header -->
	<div class="entry-content">
		<blockquote>
			<?php the_content( wp_kses( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'maddisondesigns' ), array( 
				'span' => array( 
					'class' => array() )
				) ) ); ?>
			<cite><?php the_title(); ?></cite>
		</blockquote>
		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'maddisondesigns' ),
			'after' => '</div>',
			'link_before' => '<span class="page-numbers">',
			'link_after' => '</span>'
		) ); ?>
	</div> <!-- /.entry-content -->

	<footer class="entry-meta">
		<?php if ( is_singular() ) {
			// Only show the tags on the Single Post page
			maddisondesigns_entry_meta();
		} ?>
	</footer> <!-- /.entry-meta -->
</article> <!-- /#post -->
