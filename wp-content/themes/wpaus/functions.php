<?php
/**
 * WP Australia functions and definitions
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 900; /* Default the embedded content width to 900px */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
if ( ! function_exists( 'wpaus_setup' ) ) {
	function wpaus_setup() {
		global $content_width;

		// Enable support for Theme Options.
		// Rather than reinvent the wheel, we're using the Options Framework by Devin Price, so huge props to him!
		// http://wptheming.com/options-framework-theme/
		if ( ! function_exists( 'optionsframework_init' ) ) {
			define( 'OPTIONS_FRAMEWORK_DIRECTORY', trailingslashit( get_template_directory_uri() ) . 'inc/' );
			require_once trailingslashit( dirname( __FILE__ ) ) . 'inc/options-framework.php';

			// Loads options.php from child or parent theme
			$optionsfile = locate_template( 'options.php' );
			load_template( $optionsfile );
		}

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails
		add_theme_support( 'post-thumbnails' );

		// Create an extra image size for the Post featured image
		add_image_size( 'post_feature_full_width', 900, 400, true );

		// This theme uses wp_nav_menu() in one location
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'wpaus' )
		) );

		// Enable support for Custom Backgrounds
		add_theme_support( 'custom-background', array(
			// Background color default
			'default-color' => 'fff',
			// Background image default
			'default-image' => trailingslashit( get_template_directory_uri() ) . 'images/faint-squares.jpg'
		) );

		// Enable support for Custom Headers (or in our case, a custom logo)
		add_theme_support( 'custom-header', array(
			// Header image default
			'default-image' => trailingslashit( get_template_directory_uri() ) . 'logo.php',
			// Header text display default
			'header-text' => false,
			// Header text color default
			'default-text-color' => '000',
			// Flexible width
			'flex-width' => true,
			// Header image width (in pixels)
			'width' => 300,
			// Flexible height
			'flex-height' => true,
			// Header image height (in pixels)
			'height' => 80
		) );

		// Gutenberg colour schemes..
		add_theme_support(
			'editor-color-palette', array(
				array(
					'name'  => 'Theme Colour',
					'slug' => 'theme-light',
					'color' => of_get_option( 'logo_color_bright', '#8cc63f' ),
				),
				array(
					'name'  => 'Theme Dark Colour',
					'slug' => 'theme-dark',
					'color' => of_get_option( 'logo_color_dark', '#70a025' ),
				),
				array(
					'name'  => 'White',
					'slug' => 'white',
					'color' => '#fff',
				),
				array(
					'name'  => 'Black',
					'slug' => 'black',
					'color' => '#111',
				)
			)
		);

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

	}
}
add_action( 'after_setup_theme', 'wpaus_setup' );



/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Lato by default is localized. For languages that use characters not supported by the fonts, the fonts can be disabled.
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function wpaus_fonts_url() {
	$fonts_url = '';
	$subsets = 'latin';

	/* translators: If there are characters in your language that are not supported by Lato, translate this to 'off'.
	 * Do not translate into your own language.
	 */
	$lato = _x( 'on', 'Lato font: on or off', 'wpaus' );

	/* translators: To add an additional Lato character subset specific to your language, translate this to 'greek', 'cyrillic' or 'vietnamese'.
	 * Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Lato font: add new subset (cyrillic)', 'wpaus' );

	if ( 'cyrillic' == $subset )
		$subsets .= ',cyrillic';

	if ( 'off' !== $lato ) {
		$font_families = array();

		if ( 'off' !== $lato )
			$font_families[] = 'Lato:300,700';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => $subsets,
		);
		$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $fonts_url;
}


/**
 * Register widgetized areas
 *
 * @return void
 */
function wpaus_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'wpaus' ),
		'id' => 'sidebar-main',
		'description' => __( 'Appears in the sidebar on posts and pages except the optional Front Page template, which has its own widgets', 'wpaus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Blog Sidebar', 'wpaus' ),
		'id' => 'sidebar-blog',
		'description' => __( 'Appears in the sidebar on the blog and archive pages only', 'wpaus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Single Post Sidebar', 'wpaus' ),
		'id' => 'sidebar-single',
		'description' => __( 'Appears in the sidebar on single posts only', 'wpaus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Page Sidebar', 'wpaus' ),
		'id' => 'sidebar-page',
		'description' => __( 'Appears in the sidebar on pages only', 'wpaus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'wpaus' ),
		'id' => 'sidebar-footer1',
		'description' => __( 'Appears in the footer sidebar', 'wpaus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'wpaus' ),
		'id' => 'sidebar-footer2',
		'description' => __( 'Appears in the footer sidebar', 'wpaus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'wpaus' ),
		'id' => 'sidebar-footer3',
		'description' => __( 'Appears in the footer sidebar', 'wpaus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'wpaus' ),
		'id' => 'sidebar-footer4',
		'description' => __( 'Appears in the footer sidebar', 'wpaus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );
}
add_action( 'widgets_init', 'wpaus_widgets_init' );


/**
 * Enqueue scripts and styles
 *
 * @return void
 */
function wpaus_scripts_styles() {

	/**
	 * Register and enqueue our stylesheets
	 */

	// Start off with a clean base by using normalise. If you prefer to use a reset stylesheet or something else, simply replace this
	wp_register_style( 'normalize', trailingslashit( get_template_directory_uri() ) . 'css/normalize.css' , array(), '3.0.2', 'all' );
	wp_enqueue_style( 'normalize' );

	// Register and enqueue our icon font
	// We're using the awesome Font Awesome icon font. http://fortawesome.github.io/Font-Awesome
	wp_register_style( 'fontawesome', trailingslashit( get_template_directory_uri() ) . 'css/font-awesome.min.css' , array( 'normalize' ), '4.3.0', 'all' );
	wp_enqueue_style( 'fontawesome' );

	// Our styles for setting up the grid.
	// If you prefer to use a different grid system, simply replace this and perform a find/replace in the php for the relevant styles. I'm nice like that!
	wp_register_style( 'gridsystem', trailingslashit( get_template_directory_uri() ) . 'css/grid.css' , array( 'fontawesome' ), '1.0.0', 'all' );
	wp_enqueue_style( 'gridsystem' );

	// Enqueue our css for the slidebars responsive menu
	wp_register_style( 'sllidebarscss', trailingslashit( get_template_directory_uri() ) . 'css/slidebars.min.css' , array( 'normalize' ), '0.10.2', 'all' );
	wp_enqueue_style( 'sllidebarscss' );

	/*
	 * Load our Google Fonts.
	 *
	 * To disable in a child theme, use wp_dequeue_style()
	 * function mytheme_dequeue_fonts() {
	 *     wp_dequeue_style( 'MaddisonDesigns-fonts' );
	 * }
	 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
	 */
	$fonts_url = wpaus_fonts_url();
	if ( !empty( $fonts_url ) ) {
		wp_enqueue_style( 'wpaus-fonts', esc_url_raw( $fonts_url ), array(), null );
	}

	// If using a child theme, auto-load the parent theme style.
	// Props to Justin Tadlock for this recommendation - http://justintadlock.com/archives/2014/11/03/loading-parent-styles-for-child-themes
	if ( is_child_theme() ) {
		wp_enqueue_style( 'parent-style', trailingslashit( get_template_directory_uri() ) . 'style.css' );
	}

	// Enqueue the default WordPress stylesheet
	wp_enqueue_style( 'style', get_stylesheet_uri() );


	/**
	 * Register and enqueue our scripts
	 */

	// Load Modernizr at the top of the document, which enables HTML5 elements and feature detects
	wp_register_script( 'modernizr', trailingslashit( get_template_directory_uri() ) . 'js/modernizr-2.8.3-min.js', array(), '2.8.3', false );
	wp_enqueue_script( 'modernizr' );

	// Adds JavaScript to pages with the comment form to support sites with threaded comments (when in use)
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Load jQuery Validation as well as the initialiser to provide client side comment form validation
	// You can change the validation error messages below
	if ( is_singular() && comments_open() ) {
		wp_register_script( 'validate', trailingslashit( get_template_directory_uri() ) . 'js/jquery.validate.min.1.13.0.js', array( 'jquery' ), '1.13.0', true );
		wp_register_script( 'commentvalidate', trailingslashit( get_template_directory_uri() ) . 'js/comment-form-validation.js', array( 'jquery', 'validate' ), '1.13.0', true );

		wp_enqueue_script( 'commentvalidate' );
		wp_localize_script( 'commentvalidate', 'comments_object', array(
			'req' => get_option( 'require_name_email' ),
			'author'  => __( 'Please enter your name', 'wpaus' ),
			'email'  => __( 'Please enter a valid email address', 'wpaus' ),
			'comment' => __( 'Please add a comment', 'wpaus' ) )
		);
	}

	// Add a perty slide-in responsive menu
	wp_register_script( 'slidebars-menu', trailingslashit( get_template_directory_uri() ) . 'js/slidebars.min.js', array( 'jquery' ), '0.10.2', true );
	wp_enqueue_script( 'slidebars-menu' );

	// Enqueue our common scripts
	wp_register_script( 'commonjs', trailingslashit( get_template_directory_uri() ) . 'js/common.js', array( 'jquery', 'slidebars-menu' ), '0.10.2', true );
	wp_enqueue_script( 'commonjs' );
}
add_action( 'wp_enqueue_scripts', 'wpaus_scripts_styles' );


/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @param string html ID
 * @return void
 */
if ( ! function_exists( 'wpaus_content_nav' ) ) {
	function wpaus_content_nav( $nav_id ) {
		global $wp_query;
		$big = 999999999; // need an unlikely integer

		$nav_class = 'site-navigation paging-navigation';
		if ( is_single() ) {
			$nav_class = 'site-navigation post-navigation nav-single';
		}
		?>
		<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'wpaus' ); ?></h3>

			<?php if ( is_single() ) { // navigation links for single posts ?>

				<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '<i class="fa fa-angle-left"></i>', 'Previous post link', 'wpaus' ) . '</span> %title' ); ?>
				<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '<i class="fa fa-angle-right"></i>', 'Next post link', 'wpaus' ) . '</span>' ); ?>

			<?php }
			elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) { // navigation links for home, archive, and search pages ?>

				<?php echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var( 'paged' ) ),
					'total' => $wp_query->max_num_pages,
					'type' => 'list',
					'prev_text' => __( '<i class="fa fa-angle-left"></i> Previous', 'wpaus' ),
					'next_text' => __( 'Next <i class="fa fa-angle-right"></i>', 'wpaus' ),
				) ); ?>

			<?php } ?>

		</nav><!-- #<?php echo $nav_id; ?> -->
		<?php
	}
}


/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own wpaus_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 * (Note the lack of a trailing </li>. WordPress will add it itself once it's done listing any children and whatnot)
 *
 * @param array Comment
 * @param array Arguments
 * @param integer Comment depth
 * @return void
 */
if ( ! function_exists( 'wpaus_comment' ) ) {
	function wpaus_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) {
		case 'pingback' :
		case 'trackback' :
			// Display trackbacks differently than normal comments ?>
			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="pingback">
					<p><?php _e( 'Pingback:', 'wpaus' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'maddisondesigns' ), '<span class="edit-link">', '</span>' ); ?></p>
				</article> <!-- #comment-##.pingback -->
			<?php
			break;
		default :
			// Proceed with normal comments.
			global $post; ?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="comment">
					<header class="comment-meta comment-author vcard">
						<?php
						echo get_avatar( $comment, 44 );
						printf( '<cite class="fn">%1$s %2$s</cite>',
							get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
							( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'wpaus' ) . '</span>' : '' );
						printf( '<a href="%1$s" title="Posted %2$s"><time itemprop="datePublished" datetime="%3$s">%4$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							sprintf( __( '%1$s @ %2$s', 'wpaus' ), esc_html( get_comment_date() ), esc_attr( get_comment_time() ) ),
							get_comment_time( 'c' ),
							/* Translators: 1: date, 2: time */
							sprintf( __( '%1$s at %2$s', 'wpaus' ), get_comment_date(), get_comment_time() )
						);
						?>
					</header> <!-- .comment-meta -->

					<?php if ( '0' == $comment->comment_approved ) { ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'wpaus' ); ?></p>
					<?php } ?>

					<section class="comment-content comment">
						<?php comment_text(); ?>
					</section> <!-- .comment-content -->

					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'wpaus' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div> <!-- .reply -->
				</article> <!-- #comment-## -->
			<?php
			break;
		} // end comment_type check
	}
}


/**
 * Prints HTML with meta information for current post: author and date
 *
 * @return void
 */
if ( ! function_exists( 'wpaus_posted_on' ) ) {
	function wpaus_posted_on() {
		// Translators: 1: Icon 2: Publish date in ISO format 3: Post date
		$date = sprintf( '<time class="entry-date" datetime="%1$s" itemprop="datePublished">%2$s</time>',
			esc_attr( get_the_date( 'c' ) ),
			esc_html( wpaus_get_relative_date() )
		);

		// Translators: 1: Author
		$author = sprintf( '<address class="author vcard">%1$s</address>',
			get_the_author()
		);

		// Return the Categories as a list
		$categories_list = get_the_category_list( __( ', ', 'wpaus' ) );

		// Translators: 1: Permalink 2: Title 3: No. of Comments
		$comments = sprintf( '<span class="comments-link"><i class="fa fa-comment"></i> <a href="%1$s" title="%2$s">%3$s</a></span>',
			esc_url( get_comments_link() ),
			esc_attr( __( 'Comment on ' . the_title_attribute( 'echo=0' ) ) ),
			( get_comments_number() > 0 ? sprintf( _n( '%1$s Comment', '%1$s Comments', get_comments_number(), 'wpaus' ), get_comments_number() ) : __( 'No Comments', 'maddisondesigns' ) )
		);

		// Translators: 1: Date 2: Categories 3: Author
		printf( __( '<div class="header-meta"><i class="fa fa-calendar"></i> Posted in <span class="post-categories">%1$s</span> %2$s by %3$s</div>', 'wpaus' ),
			$categories_list,
			$date,
			$author
		);
	}
}


/**
 * If the post time is less than 59 days, return the relative date otherwise return the actual date
 *
 * @return string Post date or relative date
 */
function wpaus_get_relative_date() {
	$timeStr = "";
	$seconds = current_time('timestamp') - get_the_time('U');

	// If the post time is less than 59 days, return the relative date otherwise return the actual date
	if ( $seconds < 5097600 ) {
		$timeStr = esc_html( human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago' );
	} else {
		$timeStr = 'on ' . get_the_date();
	}

	return $timeStr;
}

/**
 * Adjusts content_width value for full-width templates and attachments
 *
 * @return void
 */
function wpaus_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() ) {
		global $content_width;
		$content_width = 1200;
	}
}
add_action( 'template_redirect', 'wpaus_content_width' );

/**
 * Add a filter for wp_nav_menu to add an extra class for menu items that have children (ie. sub menus)
 * This allows us to perform some nicer styling on our menu items that have multiple levels (eg. dropdown menu arrows)
 *
 * @param Menu items
 * @return array An extra css class is on menu items with children
 */
function wpaus_add_menu_parent_class( $items ) {

	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}

	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'menu-parent-item';
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'wpaus_add_menu_parent_class' );

/**
 * Return an unordered list of linked social media icons, based on the urls provided in the Theme Options
 *
 * @return string Unordered list of linked social media icons
 */
if ( ! function_exists( 'wpaus_get_social_media' ) ) {
	function wpaus_get_social_media() {
		$output = '';
		$icons = array(
			array( 'url' => of_get_option( 'social_twitter', '' ), 'icon' => 'fa-twitter', 'title' => __( 'Follow us on Twitter', 'wpaus' ) ),
			array( 'url' => of_get_option( 'social_facebook', '' ), 'icon' => 'fa-facebook', 'title' => __( 'Friend us on Facebook', 'wpaus' ) ),
			array( 'url' => of_get_option( 'social_slideshare', '' ), 'icon' => 'fa-slideshare', 'title' => __( 'Follow us on SlideShare', 'wpaus' ) ),
			array( 'url' => of_get_option( 'social_github', '' ), 'icon' => 'fa-github', 'title' => __( 'Fork us on GitHub', 'wpaus' ) ),
			array( 'url' => of_get_option( 'social_youtube', '' ), 'icon' => 'fa-youtube', 'title' => __( 'Subscribe to us on YouTube', 'wpaus' ) ),
		);

		foreach ( $icons as $key ) {
			$value = $key['url'];
			if ( !empty( $value ) ) {
				$output .= sprintf( '<li class="%1$s"><a href="%2$s" title="%3$s" target="_blank"><i class="fa %4$s"></i></a></li>',
					str_replace( 'fa-', 'social-', $key['icon'] ),
					esc_url( $value ),
					$key['title'],
					$key['icon']
				);
			}
		}

		if ( !empty( $output ) ) {
			$output = '<ul>' . $output . '</ul>';
		}

		return $output;
	}
}

/**
 * Return a string containing the footer credits & link
 *
 * @return string Footer credits & link
 */
if ( ! function_exists( 'wpaus_get_credits' ) ) {
	function wpaus_get_credits() {
		return sprintf( '%1$s <a href="%2$s" title="%3$s">%4$s</a>',
			__( 'Proudly powered by', 'wpaus' ),
			esc_url( __( 'https://wordpress.org/', 'wpaus' ) ),
			esc_attr( __( 'Semantic Personal Publishing Platform', 'wpaus' ) ),
			__( 'WordPress', 'wpaus' )
		);
	}
}


/**
 * Outputs the selected Theme Options inline into the <head>
 *
 * @return void
 */
function wpaus_theme_options_styles() {
	$output = '';
	$imagepath =  trailingslashit( get_template_directory_uri() ) . 'images/';
	$background_defaults = array(
		'color' => '#222222',
		'image' => $imagepath . 'dark-noise.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll'
	);

	$background = of_get_option( 'banner_background', $background_defaults );
	if ( $background ) {
		$bkgrnd_color = apply_filters( 'of_sanitize_color', $background['color'] );
		$output .= "#bannercontainer { ";
		$output .= "background: " . $bkgrnd_color . " url('" . esc_url( $background['image'] ) . "') " . $background['repeat'] . " " . $background['attachment'] . " " . $background['position'] . ";";
		$output .= " }";
	}

	$footerColour = apply_filters( 'of_sanitize_color', of_get_option( 'footer_color', '#222222' ) );
	if ( !empty( $footerColour ) ) {
		$output .= "\n#footercontainer { ";
		$output .= "background-color: " . $footerColour . ";";
		$output .= " }";
	}

	if ( of_get_option( 'footer_position', 'center' ) ) {
		$output .= "\n.smallprint { ";
		$output .= "text-align: " . sanitize_text_field( of_get_option( 'footer_position', 'center' ) ) . ";";
		$output .= " }";
	}

	if ( $output != '' ) {
		echo "\n<style>\n", $output, "\n</style>\n";
	}
}
add_action( 'wp_head', 'wpaus_theme_options_styles' );

/**
 * Create a shortcode to display a Font Awesome icon with link
 *
 * Usage: [wpaus_font_awesome icon="fa-twitter"]http://twitter.com[/wpaus_font_awesome]
 */
function wpaus_font_awesome( $atts, $content=null ) {
	$returnStr = "";

	extract( shortcode_atts( array(
		'icon' => '',
		'target' => '',
		'subtitle' => ''
	), $atts ) );

	if ( !empty( $target ) ) {
		$target = 'target="' . $target . '"';
	}
	if ( !empty($subtitle) ) {
		$class = "social-icon social-icon-title";
		$subtitle = '<span>' . $subtitle . '</span>';
	}
	else {
		$class = "social-icon";
	}
	$returnStr = '<a class="' . $class . '" href="' . $content . '" ' . $target . '><i class="fa ' . $icon . '"></i>' . $subtitle . '</a>';

	return $returnStr;
}
add_shortcode( 'wpaus_font_awesome', 'wpaus_font_awesome' );

/**
 * Grab the next meetup events
 */
function wpaus_get_meetup_events( $count, $skip, $description, $venue, $transient_name ) {
	$meetupEndpoint = "";

	$meetup_group = trim( trim( parse_url( of_get_option( 'meetup_url', '' ), PHP_URL_PATH ), '/' ) );

	if ( ! $meetup_group ) {
		return '<em><strong>Uh Oh!</strong> Please configure the Meetup URL in Theme Settings.</em>';
	}

	// Doco - http://www.meetup.com/meetup_api/docs/2/events/
	$page = $count + $skip;
	$meetupEndpoint = "https://api.meetup.com/2/events?&sign=true&photo-host=public&group_urlname={$meetup_group}&page={$page}";

	return wpaus_meetup_events( $skip, $description, $venue, $meetupEndpoint, $transient_name );
}

/**
 * Grab the meetup events and store in a transient
 */
function wpaus_meetup_events( $skip, $description, $venue, $endpoint, $transient_name ) {
	$returnStr = "";

	// Since the user can define the transient name, lets also append a default name
	$classStr = "wpaus_meetup_" . $transient_name . ' wpaus_meetup_' . $transient_name;
	$transient_name = "meetup_" . $transient_name . '_' . md5( $endpoint );

	// we store the response in a transient, lets try grab it
	$results = get_transient( $transient_name );

	// if the transient is empty, then grab the data again
	if ( false === $results ) {

		// get the response from the meetup api
		$response = wp_safe_remote_get( $endpoint );

		$results = false;
		if ( ! is_wp_error( $response ) ) {
			$results = json_decode( $response['body'], true );
		}

		// store the response for a period of time.
		set_transient( $transient_name, $results, $results ? 6 * HOUR_IN_SECONDS : 5 * MINUTE_IN_SECONDS );

	}

	if ( false !== $results ) {
		$collection_array = $results['results'];

		// set the number of events we want to skip
		$skipCounter = $skip;

		// start a counter
		$eventCounter = 0;

		if ( !empty( $collection_array ) ) {
			// start a list
			$returnStr = '<ul class="wpaus-meetups ' . $classStr . '">';

			// create a list item for each event
			foreach ( $collection_array as $collection_item ) {

				// event counter
				$eventCounter++;

				// Check if we need to skip any meetups
				if ( $eventCounter > $skipCounter ) {
					// grab the time stamp for this event
					$timestamp = $collection_item['time'] + $collection_item['utc_offset'];

					// trim the milliseconds, aint nobody got time for that
					$timestamp_trim = substr( $timestamp, 0, -3 );

					$event_name = $collection_item['name'];
					// Strip off any prefixed `[..]`'s.
					$event_name = preg_replace( '!^\[[^]]+\]!', '', $event_name );

					$classes = array( $event_name );
					if ( ! empty( $collection_item['venue']['city'] ) ) {
						$classes[] = $collection_item['venue']['city'];
					}
					if ( preg_match( '!^\[([^]]+)\]!', $collection_item['name'], $m ) ) {
						$classes[] = $m[1];
					}
					$classes = array_map( 'sanitize_title', $classes );
					$classes = array_unique( $classes );

					// format the timestamp into a usable date
					$date_time = new DateTime( "@$timestamp_trim", new DateTimeZone( get_option( 'timezone_string' ) ?: 'Australia/Sydney' ) );
					$date = '<span class="meetup-date">' . $date_time->format( 'l jS M Y' ) . '</span><span class="meetup-time">'. $date_time->format( 'g:i a' ) . '</span>';

					$returnStr .= '<li class="' . implode( ' ', $classes ) . '">';
					$returnStr .= '<h2><a class="meetup-name" href="' . $collection_item['event_url'] . '" target="_blank">' . $event_name. '</a></h2>';
					$returnStr .= '<span class="meetup-datetime"><i class="fa fa-calendar"></i>' . $date . '</span>';
					if ( $venue || $venue_full ) {
						$address = sprintf( '%s (%s)',
							$collection_item['venue']['name'],
							implode( ' ', array_filter( array_unique( array_map( 'trim',
								preg_split( '/[\s,]+/',
									($collection_item['venue']['address_1'] ?? '') . ' ' .
									($collection_item['venue']['address_2'] ?? '') . ' ' .
									($collection_item['venue']['city'] ?? '') . ' ' .
									($collection_item['venue']['state'] ?? '')
								)
							) ) ) )
						);
						$google_maps_url = 'https://www.google.com/maps/search/' . urlencode( $address );

						$returnStr .= '<span class="meetup-location"><i class="fa fa-map-marker"></i>' .
							'<a href="' . $google_maps_url . '">' .
							( 'with_address' === $venue ? $address : $collection_item['venue']['name'] ) .
							'</a></span>';
					}
					if ( $description ) {
						$returnStr .= '<div class="meetup-description">' . wp_kses_post( $collection_item['description'] ) . '</div>';
						$returnStr .= '<p><a class="meetup-link" href="' . esc_url( $collection_item['event_url'] ) . '" target="_blank">View & RSVP on meetup.com</a></p>';
					}
					$returnStr .= '</li>';
				}
			}

			// end list
			$returnStr .= '</ul>';
		}
	}
	else {
		$returnStr = '<h2>Uh Oh! Unable to get Response from Meetup.com</h2>';
	}
	return $returnStr;
}

/**
 * Create a shortcode to display a list of WP melbourne meetups
 *
 * Usage: [wpaus_display_meetups count="5" skip="1" description="show/hide" venue="show/hide"]
 */
function wpaus_display_meetups( $atts, $content=null ) {
	$returnStr = "";

	extract( shortcode_atts( array(
		'count' => 4,
		'skip' => 0,
		'name' => 'wpaus_meetups',
		'description' => false,
		'venue' => true
	), $atts ) );

	if ( strtolower( $description ) === 'show' ) {
		$description = true;
	} else {
		$description = false;
	}

	if ( strtolower( $venue ) === 'hide' ) {
		$venue = false;
	} elseif ( strtolower( $venue ) === 'with_address' ) {
		$venue = 'with_address';
	} else {
		$venue = true;
	}

	$returnStr = wpaus_get_meetup_events( $count, $skip, $description, $venue, 'wpaus_meetups' );
	if ( empty( $returnStr ) ) {
		$returnStr = '<p class="nomeetups">There are no meetups currently scheduled.</p>';
	}
	return $returnStr;
}
add_shortcode( 'display_meetups', 'wpaus_display_meetups' );

/**
 * Create a shortcode to display the next WP melbourne meetup
 *
 * Usage: [wpaus_display_next_meetup description="show/hide" venue="show/hide"]
 */
function wpaus_display_next_meetup( $atts, $content=null ) {
	$returnStr = "";

	extract( shortcode_atts( array(
		'description' => false,
		'venue' => 'show'
	), $atts ) );

	$description = ( strtolower( $description ) === 'show' );

	if ( strtolower( $venue ) === 'hide' ) {
		$venue = false;
	} elseif ( strtolower( $venue ) === 'with_address' ) {
		$venue = 'with_address';
	} else {
		$venue = true;
	}

	$returnStr = wpaus_get_meetup_events( 1, 0, $description, $venue, 'next_wpaus_meetup' );
	if ( empty( $returnStr ) ) {
		$returnStr = '<h3 class="nomeetups">There are no meetups currently scheduled.</h3>';
	}
	return $returnStr;
}
add_shortcode( 'display_next_meetup', 'wpaus_display_next_meetup' );


function wpaus_colourise_theme() {
	$light = of_get_option( 'logo_color_bright', '#8cc63f' ) ?: '#8cc63f';
	$dark  = of_get_option( 'logo_color_dark', '#70a025' ) ?: '#70a025';

	// Minify the CSS a little
	echo implode( '', array_map( 'trim', explode( "\n", "<style type='text/css' media='all'>
		#headercontainer { border-top-color: $light; }

		.has-text-color.has-white-color {
			color: #fff;
		}
		.has-text-color.has-black-color {
			color: #111;
		}
		.has-text-color.has-theme-light {
			color: $light;
		}
		.has-text-color.has-theme-dark {
			color: $dark;
		}

		.has-background.has-theme-dark-background-color {
			background-color: $dark;
		}
		.has-background.has-theme-light-background-color {
			background-color: $light;
		}

		a, a:focus, a:hover, a:visited, .share-buttons li a:hover {
			color: $dark;
		}
		.main-navigation .current-menu-item > a, .main-navigation .current-menu-ancestor > a, .main-navigation a, .main-navigation .current_page_item > a, .main-navigation .current_page_ancestor > a, .main-navigation .current_page_parent > a,
		.menu-toggle:hover, .btn:hover, input[type=\"submit\"]:hover, button:hover,
		.site-footer a:hover, .site-footer a:focus, .smallprint a:hover,
		li a:hover.prev, li a:hover.next {
			color: $light;
		}

		ins, .btn.content-light
		.main-navigation li:hover > a,
		.page-links a:hover .page-numbers, li a:hover.page-numbers,
		.side-nav-menu li a:hover,
		.main-navigation li:hover > a {
			background-color: $light;
		}

		.menu-toggle, .btn, input[type='submit'], button, .btn.content-light {
			border-color: $dark;
			background-color: $light;
		}

		.wpaus_meetup_wpaus_meetups li {
			background-color: $light;
		}
	</style>" ) ) );

}
add_action( 'wp_head', 'wpaus_colourise_theme', 100 );