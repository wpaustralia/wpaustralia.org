<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace( "/\W/", "_", strtolower( $themename ) );
	return $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'maddisondesigns'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// If using image radio buttons, define a directory path
	$imagepath =  trailingslashit( get_template_directory_uri() ) . 'images/';

	// Background Defaults
	$background_defaults = array(
		'color' => '#222222',
		'image' => $imagepath . 'dark-noise.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' );

	// Editor settings
	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);

	// Footer Position settings
	$footer_position_settings = array(
		'left' => esc_html__( 'Left aligned', 'maddisondesigns' ),
		'center' => esc_html__( 'Center aligned', 'maddisondesigns' ),
		'right' => esc_html__( 'Right aligned', 'maddisondesigns' )
	);

	// Number of shop products
	$shop_products_settings = array(
		'4' => esc_html__( '4 Products', 'maddisondesigns' ),
		'8' => esc_html__( '8 Products', 'maddisondesigns' ),
		'12' => esc_html__( '12 Products', 'maddisondesigns' ),
		'16' => esc_html__( '16 Products', 'maddisondesigns' ),
		'20' => esc_html__( '20 Products', 'maddisondesigns' ),
		'24' => esc_html__( '24 Products', 'maddisondesigns' ),
		'28' => esc_html__( '28 Products', 'maddisondesigns' )
	);

	$options = array();

	$options[] = array(
		'name' => esc_html__( 'Basic Settings', 'maddisondesigns' ),
		'type' => 'heading' );

	$options[] = array(
		'name' => esc_html__( 'Background', 'maddisondesigns' ),
		'desc' => sprintf( wp_kses( __( 'If you&rsquo;d like to replace or remove the default background image, use the <a href="%1$s" title="Custom background">Appearance &gt; Background</a> menu option.', 'maddisondesigns' ), array(
			'a' => array(
				'href' => array(),
				'title' => array() )
			) ), admin_url( 'themes.php?page=custom-background' ) ),
		'type' => 'info' );

	$options[] = array(
		'name' => esc_html__( 'Logo', 'maddisondesigns' ),
		'desc' => sprintf( wp_kses( __( 'If you&rsquo;d like to replace or remove the default logo, use the <a href="%1$s" title="Custom header">Appearance &gt; Header</a> menu option.', 'maddisondesigns' ), array(
			'a' => array(
				'href' => array(),
				'title' => array() )
			) ), admin_url( 'themes.php?page=custom-header' ) ),
		'type' => 'info' );

	$options[] = array(
		'name' => esc_html__( 'Social Media Settings', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter the URLs for your Social Media platforms. You can also optionally specify whether you want these links opened in a new browser tab/window.', 'maddisondesigns' ),
		'type' => 'info' );

	$options[] = array(
		'name' => esc_html__('Open links in new Window/Tab', 'maddisondesigns'),
		'desc' => esc_html__('Open the social media links in a new browser tab/window', 'maddisondesigns'),
		'id' => 'social_newtab',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => esc_html__( 'Twitter', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your Twitter URL.', 'maddisondesigns' ),
		'id' => 'social_twitter',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'Facebook', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your Facebook URL.', 'maddisondesigns' ),
		'id' => 'social_facebook',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'Google+', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your Google+ URL.', 'maddisondesigns' ),
		'id' => 'social_googleplus',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'LinkedIn', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your LinkedIn URL.', 'maddisondesigns' ),
		'id' => 'social_linkedin',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'SlideShare', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your SlideShare URL.', 'maddisondesigns' ),
		'id' => 'social_slideshare',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'Dribbble', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your Dribbble URL.', 'maddisondesigns' ),
		'id' => 'social_dribbble',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'Tumblr', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your Tumblr URL.', 'maddisondesigns' ),
		'id' => 'social_tumblr',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'GitHub', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your GitHub URL.', 'maddisondesigns' ),
		'id' => 'social_github',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'Bitbucket', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your Bitbucket URL.', 'maddisondesigns' ),
		'id' => 'social_bitbucket',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'Foursquare', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your Foursquare URL.', 'maddisondesigns' ),
		'id' => 'social_foursquare',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'YouTube', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your YouTube URL.', 'maddisondesigns' ),
		'id' => 'social_youtube',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'Vimeo', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your Vimeo URL.', 'maddisondesigns' ),
		'id' => 'social_vimeo',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'Instagram', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your Instagram URL.', 'maddisondesigns' ),
		'id' => 'social_instagram',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'Vine', 'quark' ),
		'desc' => esc_html__( 'Enter your Vine URL.', 'quark' ),
		'id' => 'social_vine',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'Flickr', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your Flickr URL.', 'maddisondesigns' ),
		'id' => 'social_flickr',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'Pinterest', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your Pinterest URL.', 'maddisondesigns' ),
		'id' => 'social_pinterest',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'RSS', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter your RSS Feed URL.', 'maddisondesigns' ),
		'id' => 'social_rss',
		'std' => '',
		'type' => 'text' );

	$options[] = array(
		'name' => esc_html__( 'Advanced settings', 'maddisondesigns' ),
		'type' => 'heading' );

	$options[] = array(
		'name' =>  esc_html__( 'Banner Background', 'maddisondesigns' ),
		'desc' => esc_html__( 'Select an image and background color for the homepage banner.', 'maddisondesigns' ),
		'id' => 'banner_background',
		'std' => $background_defaults,
		'type' => 'background' );

	$options[] = array(
		'name' => esc_html__( 'Footer Background Color', 'maddisondesigns' ),
		'desc' => esc_html__( 'Select the background color for the footer.', 'maddisondesigns' ),
		'id' => 'footer_color',
		'std' => '#222222',
		'type' => 'color' );

	$options[] = array(
		'name' => esc_html__( 'Footer Content', 'maddisondesigns' ),
		'desc' => esc_html__( 'Enter the text you&lsquo;d like to display in the footer. This content will be displayed just below the footer widgets. It&lsquo;s ideal for displaying your copyright message or credits.', 'maddisondesigns' ),
		'id' => 'footer_content',
		'std' => maddisondesigns_get_credits(),
		'type' => 'editor',
		'settings' => $wp_editor_settings );

	$options[] = array(
		'name' => esc_html__( 'Footer Content Position', 'maddisondesigns' ),
		'desc' => esc_html__( 'Select what position you would like the footer content aligned to.', 'maddisondesigns' ),
		'id' => 'footer_position',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini',
		'options' => $footer_position_settings );

	if( maddisondesigns_is_woocommerce_active() ) {
		$options[] = array(
		'name' => esc_html__( 'WooCommerce settings', 'maddisondesigns' ),
		'type' => 'heading' );

		$options[] = array(
			'name' => esc_html__('Shop sidebar', 'maddisondesigns'),
			'desc' => esc_html__('Display the sidebar on the WooCommerce Shop page', 'maddisondesigns'),
			'id' => 'woocommerce_shopsidebar',
			'std' => '1',
			'type' => 'checkbox');

		$options[] = array(
			'name' => esc_html__('Products sidebar', 'maddisondesigns'),
			'desc' => esc_html__('Display the sidebar on the WooCommerce Single Product page', 'maddisondesigns'),
			'id' => 'woocommerce_productsidebar',
			'std' => '1',
			'type' => 'checkbox');

		$options[] = array(
			'name' => esc_html__( 'Cart, Checkout & My Account sidebars', 'maddisondesigns' ),
			'desc' => esc_html__( 'The &lsquo;Cart&rsquo;, &lsquo;Checkout&rsquo; and &lsquo;My Account&rsquo; pages are displayed using shortcodes. To remove the sidebar from these Pages, simply edit each Page and change the Template (in the Page Attributes Panel) to the &lsquo;Full-width Page Template&rsquo;.', 'maddisondesigns' ),
			'type' => 'info' );

		$options[] = array(
			'name' => esc_html__('Shop Breadcrumbs', 'maddisondesigns'),
			'desc' => esc_html__('Display the breadcrumbs on the WooCommerce pages', 'maddisondesigns'),
			'id' => 'woocommerce_breadcrumbs',
			'std' => '1',
			'type' => 'checkbox');

		$options[] = array(
			'name' => esc_html__( 'Shop Products', 'maddisondesigns' ),
			'desc' => esc_html__( 'Select the number of products to display on the shop page.', 'maddisondesigns' ),
			'id' => 'shop_products',
			'std' => '12',
			'type' => 'select',
			'class' => 'mini',
			'options' => $shop_products_settings );

	}

	return $options;
}
