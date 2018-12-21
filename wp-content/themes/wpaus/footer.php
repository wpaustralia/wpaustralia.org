	<div id="footercontainer">

		<footer class="site-footer row" role="contentinfo">

			<?php
			// Count how many footer sidebars are active so we can work out how many containers we need
			$footerSidebars = 0;
			for ( $x=1; $x<=4; $x++ ) {
				if ( is_active_sidebar( 'sidebar-footer' . $x ) ) {
					$footerSidebars++;
				}
			}

			// If there's one or more one active sidebars, create a row and add them
			if ( $footerSidebars > 0 ) { ?>
				<?php
				// Work out the container class name based on the number of active footer sidebars
				$containerClass = "grid_" . 12 / $footerSidebars . "_of_12";

				// Display the active footer sidebars
				for ( $x=1; $x<=4; $x++ ) {
					if ( is_active_sidebar( 'sidebar-footer'. $x ) ) { ?>
						<div class="col <?php echo $containerClass?>">
							<div class="widget-area" role="complementary">
								<?php dynamic_sidebar( 'sidebar-footer'. $x ); ?>
							</div>
						</div> <!-- /.col.<?php echo $containerClass?> -->
					<?php }
				} ?>

			<?php } ?>

		</footer> <!-- /.site-footer.row -->

	</div> <!-- /.footercontainer -->
	<div class="creditscontainer">
		<div class="smallprint row">
			<div class="col grid_6_of_12 sitecopyright">
				<?php if ( of_get_option( 'footer_content', wpaus_get_credits() ) ) {
					echo apply_filters( 'the_content', wp_kses_post( of_get_option( 'footer_content', wpaus_get_credits() ) ) );
				} ?>
			</div> <!-- /.col.grid_6_of_12.sitecopyright -->
			<div class="col grid_6_of_12 credits">
				<div class="social-media-icons">
					<?php echo wpaus_get_social_media(); ?>
				</div>
			</div> <!-- /.col.grid_6_of_12.credits -->
		</div> <!-- /.smallprint.row -->
	</div> <!-- /.creditscontainer -->

</div> <!-- /.#wrapper.hfeed.site -->

<div class="sb-slidebar sb-right sb-style-push">
	<!-- Your right Slidebar content. -->
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="sidebar-nav-logo" rel="home">
		<?php $inverted = true; require( 'logo.php' ); ?>
	</a>
	<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'menu-mobile-nav', 'menu_class' => 'side-nav-menu' ) ); ?>
</div>

<?php wp_footer(); ?>
</body>

</html>
