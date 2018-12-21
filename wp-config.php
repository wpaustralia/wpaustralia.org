<?php

// WARNING: This file is public.

// This setting was defined by the Plesk WordPress Toolkit to prevent WordPress auto-updates. Do not change it to avoid conflicts with the WordPress Toolkit auto-updates feature.
define('WP_AUTO_UPDATE_CORE', false);

// Include the Database Credentials, Salts and keys, etc
@include( __DIR__ . '/wp-config-private.php' );
if ( ! defined( 'DB_PASSWORD' ) ) {
	die( "Please create a `wp-config-private.php` file with all the regular secrets WordPress needs." );
}

// As we've got WordPress installed in a subdirectory, lets include our own wp-content directory at the root.
define( 'WP_CONTENT_DIR', __DIR__ . '/wp-content' );
defined( 'WP_CONTENT_URL' ) || define( 'WP_CONTENT_URL', 'https://' . $_SERVER['SERVER_NAME'] . '/wp-content' );

// For Local Development you can define the `WP_CONTENT_URL` in `wp-config-private.php` such as:
// define( 'WP_CONTENT_URL', 'http://localhost/wpaustralia.org/wp-content' );


define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', true );
define( 'DOMAIN_CURRENT_SITE', 'wpaustralia.org' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );
define( 'SUNRISE', true );

// define( 'NOBLOGREDIRECT', 'https://wpaustralia.org/' );

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/wordpress/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

