<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package MaddisonDesigns
 * @since MaddisonDesigns 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( !is_front_page() ) { ?>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
	<?php } ?>
	<div class="entry-content">
		<?php the_content(); ?>

		<h2><?php esc_html_e( 'Archives by Category', 'maddisondesigns' ); ?></h2>
		<ul class="content-archives-by-category">
			<?php wp_list_categories( array(
				'showcount' => 'true',
				'title_li' => '',
				'show_count' => 'true'
			) ); ?>
		</ul>

		<h2><?php esc_html_e( 'Archives by Month', 'maddisondesigns' ); ?></h2>
		<ul class="content-archives-by-month">
			<?php wp_get_archives( 'type=monthly' ); ?>
		</ul>

		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'maddisondesigns' ), 'after' => '</div>' ) ); ?>
	</div><!-- /.entry-content -->
</article><!-- /#post -->
