<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta http-equiv="cleartype" content="on">

	<!-- Responsive and mobile friendly stuff -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="headercontainer" class="sb-slide <?php if ( of_get_option('header_dark') ) { echo 'dark'; } ?>">

	<header id="masthead" class="site-header row" role="banner">
		<div class="col grid_5_of_12 site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home">
				<?php $inverted = of_get_option('header_dark'); require( 'logo.php' ); ?>
			</a>
		</div> <!-- /.col.grid_5_of_12 -->

		<div class="col grid_7_of_12 site-nav">
			<nav id="mobile-site-navigation" class="mobile-navigation" role="navigation">
				<div class="sb-toggle-right navbar-right">
					<div class="navicon-line"></div>
					<div class="navicon-line"></div>
					<div class="navicon-line"></div>
					<div class="navicon-line"></div>
					<div class="navicon-title">MENU</div>
				</div>
			</nav> <!-- /#mobile-site-navigation.mobile-navigation -->
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'wpaus' ); ?>"><?php _e( 'Skip to content', 'maddisondesigns' ); ?></a></div>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
			</nav> <!-- /#site-navigation.main-navigation -->
		</div> <!-- /.col.grid_7_of_12 -->
	</header> <!-- /#masthead.site-header.row -->

</div> <!-- /#headercontainer -->

<div id="wrapper" class="hfeed site">

	<div class="visuallyhidden skip-link"><a href="#primary" title="<?php esc_attr_e( 'Skip to main content', 'wpaus' ); ?>"><?php _e( 'Skip to main content', 'wpaus' ); ?></a></div>
