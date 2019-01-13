<?php

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 */

function optionsframework_options() {
	$options = array();

	$options[] = array(
		'name' => 'Site Settings',
		'type' => 'heading'
	);

	$options[] = array(
		'name' => 'Logo Colour',
		'desc' => 'The Ascent colour for the Logo.',
		'id' => 'logo_color_bright',
		'std' => '#8cc63f',
		'type' => 'color'
	);

	$options[] = array(
		'name' => 'Logo Dark Colour',
		'desc' => 'The Dark colour for the Logo.',
		'id' => 'logo_color_dark',
		'std' => '#70a025',
		'type' => 'color'
	);

	$options[] = array(
		'name' => 'Use a Dark header',
		'desc' => 'Enable this to use #4d4d4d as the header background colour, useful for the home page.',
		'id' => 'header_dark',
		'std' => '0',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => 'Meetup URL',
		'desc' => 'The URL to the meetup.com group, for example: https://www.meetup.com/WordPress-Brisbane/',
		'id' => 'meetup_url',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __( 'Basic Settings', 'wpaus' ),
		'type' => 'heading'
	);

	$options[] = array(
		'name' => __( 'Social Media Settings', 'wpaus' ),
		'desc' => __( 'Enter the URLs for your Social Media platforms. You can also optionally specify whether you want these links opened in a new browser tab/window.', 'wpaus' ),
		'type' => 'info'
	);

	$options[] = array(
		'name' => __( 'Twitter', 'wpaus' ),
		'desc' => __( 'Enter your Twitter URL.', 'wpaus' ),
		'id' => 'social_twitter',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __( 'Facebook', 'wpaus' ),
		'desc' => __( 'Enter your Facebook URL.', 'wpaus' ),
		'id' => 'social_facebook',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __( 'SlideShare', 'wpaus' ),
		'desc' => __( 'Enter your SlideShare URL.', 'wpaus' ),
		'id' => 'social_slideshare',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __( 'GitHub', 'wpaus' ),
		'desc' => __( 'Enter your GitHub URL.', 'wpaus' ),
		'id' => 'social_github',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __( 'YouTube', 'wpaus' ),
		'desc' => __( 'Enter your YouTube URL.', 'wpaus' ),
		'id' => 'social_youtube',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __( 'Advanced settings', 'wpaus' ),
		'type' => 'heading'
	);

	$options[] = array(
		'name' =>  __( 'Banner Background', 'wpaus' ),
		'desc' => __( 'Select an image and background color for the homepage banner.', 'wpaus' ),
		'id' => 'banner_background',
		'std' => array(
		'color' => '#222222',
			'image' => trailingslashit( get_template_directory_uri() ) . 'images/dark-noise.jpg',
			'repeat' => 'repeat',
			'position' => 'top left',
			'attachment'=>'scroll'
		),
		'type' => 'background'
	);

	$options[] = array(
		'name' => __( 'Footer Background Color', 'wpaus' ),
		'desc' => __( 'Select the background color for the footer.', 'wpaus' ),
		'id' => 'footer_color',
		'std' => '#222222',
		'type' => 'color'
	);

	$options[] = array(
		'name' => __( 'Footer Content', 'wpaus' ),
		'desc' => __( 'Enter the text you&lsquo;d like to display in the footer. This content will be displayed just below the footer widgets. It&lsquo;s ideal for displaying your copyright message or credits.', 'wpaus' ),
		'id' => 'footer_content',
		'std' => wpaus_get_credits(),
		'type' => 'editor',
		'settings' => array(
			'wpautop' => true, // Default
			'textarea_rows' => 5,
			'tinymce' => array( 'plugins' => 'wordpress' )
		)
	);

	$options[] = array(
		'name' => __( 'Footer Content Position', 'wpaus' ),
		'desc' => __( 'Select what position you would like the footer content aligned to.', 'wpaus' ),
		'id' => 'footer_position',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini',
		'options' => array(
			'left' => __( 'Left aligned', 'wpaus' ),
			'center' => __( 'Center aligned', 'wpaus' ),
			'right' => __( 'Right aligned', 'wpaus' )
		)
	);


	return $options;
}
