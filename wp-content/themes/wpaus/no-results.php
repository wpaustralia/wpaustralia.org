<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */
?>

<article id="post-0" class="post no-results not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'maddisondesigns' ); ?></h1>
	</header><!-- /.entry-header -->

	<div class="entry-content">
		<?php if ( is_home() && current_user_can( 'edit_posts' ) ) { ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'maddisondesigns' ), array(
				'a' => array(
					'href' => array() )
				) ), admin_url( 'post-new.php' ) ); ?></p>

		<?php } elseif ( is_search() ) { ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'maddisondesigns' ); ?></p>
			<?php get_search_form(); ?>

		<?php } else { ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'maddisondesigns' ); ?></p>
			<?php get_search_form(); ?>

		<?php } ?>
	</div><!-- /.entry-content -->
</article><!-- /#post-0.post.no-results.not-found -->
