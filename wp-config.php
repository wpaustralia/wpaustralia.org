<?php

// WARNING: This file is public.

// Include the Database Credentials, Salts and keys, etc
@include( __DIR__ . '/wp-config-private.php' );
if ( ! defined( 'DB_PASSWORD' ) ) {
	die( "Please create a `wp-config-private.php` file with all the regular secrets WordPress needs." );
}

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
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

