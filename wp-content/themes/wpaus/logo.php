<?php

$theme_colour      = '#8cc63f';
$theme_dark_colour = '#70a025';
$inverted          = $inverted ?? false; // Can be set prior to inclusion, if used on dark background.
$logo_text         = 'WP Australia';

if ( defined( 'ABSPATH' ) ) {
	$theme_colour      = of_get_option( 'logo_color_bright', $theme_colour )    ?: $theme_colour;
	$theme_dark_colour = of_get_option( 'logo_color_dark', $theme_dark_colour ) ?: $theme_dark_colour;
	$logo_text         = get_bloginfo( 'title' );
} else {
	// For testing purposes when requesting logo.php directly.
	if ( ! headers_sent() ) {
		header( 'Content-Type: image/svg+xml' );
	}
	foreach ( [ 'theme_colour', 'theme_dark_colour', 'logo_text', 'inverted' ] as $_field ) {
		if ( !empty( $_GET[$_field] ) ) {
			$$_field = preg_replace( '/[^A-Za-z#0-9 ]/', '', urldecode( $_GET[$_field] ) ) ?: $$_field;
		}
	}
}

$text_one = false !== stripos( $logo_text, 'WP' ) ? 'WP' : 'WordPress';
$text_two = trim( str_ireplace( ['WordPress', 'WP', 'Meetup'], '', $logo_text ) );

$text_one_class = $inverted ? 'color-white' : 'color-dark';

?><svg class="logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 450 125">
	<defs>
		<style>
		.color-theme { fill: <?php echo $theme_colour ?>;}
		.color-theme-dark { fill: <?php echo $theme_dark_colour ?>;}
		.color-white {fill:#fff;}
		.color-dark {fill: #4e4e4e;}
		text { font: 2em 'Montserrat', sans-serif; text-transform: uppercase; font-weight: bold; }
		</style>
	</defs>
	<title>wpaus-logo</title>
	<rect class="color-theme" x="24.29" width="98.66" height="124.78"/>
	<polygon class="color-theme-dark" points="78.28 109.99 112.78 45.16 88.52 45.16 54.02 109.99 78.28 109.99"/>
	<polygon class="color-theme-dark" points="123.01 109.99 123.02 64.46 98.74 109.99 123.01 109.99"/>
	<polygon class="color-theme-dark" points="34.04 109.99 68.54 45.16 44.27 45.16 24.3 82.7 24.3 109.99 34.04 109.99"/>
	<polygon class="color-white" points="34.5 109.99 0 45.16 24.26 45.16 58.76 109.99 34.5 109.99"/>
	<polygon class="color-white" points="78.74 109.99 44.24 45.16 68.51 45.16 103 109.99 78.74 109.99"/>
	<polygon class="color-white" points="122.98 109.99 88.49 45.16 112.75 45.16 147.25 109.99 122.98 109.99"/>
	<text class="<?php echo $text_one_class ?>" x="150" y="75"><?php echo $text_one ?></text>
	<text class="color-theme" x="150" y="110"><?php echo $text_two; ?></text>
</svg>
<?php

unset( $logo_text, $text_one, $text_one_class, $text_two, $theme_colour, $theme_dark_colour, $_field, $inverted );