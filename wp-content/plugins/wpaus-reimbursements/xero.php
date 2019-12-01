<?php
namespace WPAustralia\Reimbursements\Xero;

/**
 * Add the Import to Xero metabox.
 */
add_action( 'load-flamingo_page_flamingo_inbound', function() {
	if ( 'edit' != flamingo_current_action() ) {
		return;
	}

	add_meta_box( 'xerodiv', __( 'Xero', 'flamingo' ), __NAMESPACE__ . '\meta_box', null, 'side', 'core' );
} );

function meta_box( $post ) {
	echo 'Work In Progress. Not implemented.<br>';
	echo '<button>Import to Xero</button>';

// Xero OAuth2
// WPAUS_XERO_CLIENTID
// WPAUS_XERO_SECRET

}

