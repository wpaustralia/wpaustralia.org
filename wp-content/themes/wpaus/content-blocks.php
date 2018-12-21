<?php

/* check if the ACF Flexible Content Field has rows of data */
if( have_rows( 'content' ) ) {

	/* loop through the rows of ACF data */
	while ( have_rows( 'content' ) ) {
		the_row();
		if( get_row_layout() == 'call_to_action' ) { ?>
			<!-- Call To Action -->
			<?php
			$styleStr = "";
			$image = get_sub_field( 'cta_background_image' );
			if( !empty( $image ) ) {
				$styleStr = "background:url(" . $image['url'] . ") no-repeat center top;";
			} else {
				$styleStr = "background-color:" . get_sub_field( 'cta_background_color' ) . ";";
			}
			?>
			<div class="fullwidthcontainer calltoaction" style="<?php echo $styleStr; ?>">
				<div class="site-content row">
					<div class="col grid_12_of_12">
						<?php
						$animateStyle .= ( get_sub_field( 'cta_button_animation' ) <> 'none' ? 'data-animation="' . get_sub_field( 'cta_button_animation' ) . '"': '' );
						$animateDelay .= ( $animateStyle <> '' ? 'data-animation-delay="' . get_sub_field( 'cta_button_animation_delay' ) . '"': '' );
						$colorClasses .= ( get_sub_field( 'cta_content_color' ) === 'content-light' ? 'content-light' : '' );
						?>
						<h3<?php echo ( $colorClasses <> '' ? ' class="' . $colorClasses . '"' : '' ) ?>><?php the_sub_field( 'cta_text' ); ?></h3>
						<a class="btn<?php echo ( $animateStyle <> '' ? ' animate' : '' ) . ( $colorClasses <> '' ? ' ' . $colorClasses : '' ); ?>" role="button" href="<?php the_sub_field( 'cta_button_url' ); ?>"<?php echo ( $animateStyle <> '' ? ' ' . $animateStyle . ' ' . $animateDelay : '' ); ?>><?php the_sub_field( 'cta_button_text' ); ?></a>
					</div>
				</div>
			</div>
		<?php }
		elseif( get_row_layout() == 'blurbs' ) { ?>
			<!-- Blurbs -->
			<div class="fullwidthcontainer blurb" style="background-color:<?php echo ( get_sub_field( 'blurb_background_color' ) ) ?>">
				<div class="site-content row">
					<?php if( have_rows( 'blurb_content' ) ) {
						$columns = "";
						$columnCount = 0;
						// loop through the rows of data
						while ( have_rows( 'blurb_content' ) ) {
							the_row();
							$columnCount++;
							$animateStyle = ( get_sub_field( 'blurb_animation' ) <> 'none' ? 'data-animation="' . get_sub_field( 'blurb_animation' ) . '"': '' );
							$columns .= '<div class="col grid_[cols]_of_12"><div class="blurb-container">';
							$columns .= '<a href="' . get_sub_field( 'blurb_link' ) . '" title="' . get_sub_field( 'blurb_title' ) . '">';
							$columns .= '<i class="fa ' . get_sub_field( 'blurb_icon' ) . ( $animateStyle <> '' ? ' animate' : '' ) . '"' . ( $animateStyle <> '' ? ' ' . $animateStyle : '' ) . '></i>';
							$columns .= '</a>';
							$columns .= '<h4><a href="' . get_sub_field( 'blurb_link' ) . '" title="' . get_sub_field( 'blurb_title' ) . '">'. get_sub_field( 'blurb_title' ) . '</a></h4>';
							$columns .= get_sub_field( 'blurb_text_content' );
							$columns .= '</div></div>';
						}
						$columns = str_replace( '[cols]', intval( 12/$columnCount ), $columns );
						echo $columns;
					} ?>
				</div>
			</div>
		<?php }

	}

}
?>
