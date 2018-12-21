<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="maincontentcontainer">
 */
?><!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->


<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta http-equiv="cleartype" content="on">

	<!-- Responsive and mobile friendly stuff -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="google-site-verification" content="2S-KKmkWU6BO5_TmKdxSkM0ke-97U5vG7mesjhS_njk" />

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="headercontainer" class="sb-slide">

	<header id="masthead" class="site-header row" role="banner">
		<div class="col grid_5_of_12 site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home">
				<?php require( 'wpmelb-logo.php' ); ?>
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
				<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'maddisondesigns' ); ?>"><?php esc_html_e( 'Skip to content', 'maddisondesigns' ); ?></a></div>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
			</nav> <!-- /#site-navigation.main-navigation -->
		</div> <!-- /.col.grid_7_of_12 -->
	</header> <!-- /#masthead.site-header.row -->

</div> <!-- /#headercontainer -->

<div id="wrapper" class="hfeed site">

	<div class="visuallyhidden skip-link"><a href="#primary" title="<?php esc_attr_e( 'Skip to main content', 'maddisondesigns' ); ?>"><?php esc_html_e( 'Skip to main content', 'maddisondesigns' ); ?></a></div>
