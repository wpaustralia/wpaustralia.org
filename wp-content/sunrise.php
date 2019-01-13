<?php

// Redirect non-matched domains (foobar.wpaustralia.org) to the front-page.
add_action(
	'ms_site_not_found',
	function() {
		header( 'Location: https://wpaustralia.org/', true, 302 );
		exit;
	}
);

// This line intentionally not used.
