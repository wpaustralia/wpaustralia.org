<?php
namespace WPAustralia\Reimbursements\Xero;

include __DIR__ . '/xero-functions.php';

/**
 * Add the Import to Xero metabox.
 */
add_action( 'load-flamingo_page_flamingo_inbound', function() {
	if ( 'edit' != flamingo_current_action() ) {
		return;
	}

	add_meta_box( 'xerodiv', __( 'Xero', 'flamingo' ), __NAMESPACE__ . '\meta_box', null, 'side', 'core' );
} );

/**
 * The Metabox template.
 */
function meta_box( $post ) {
	$token = get_token();

	$invoices = get_post_meta( $post->id, '_xero_invoice', true );

	if ( $token ) {
		foreach ( $token['organisations'] as $org ) {
			echo '<h3>' . esc_html( $org['name'] ) . '</h3>';

			if ( isset( $invoices[ $org['id'] ] ) ) {
				printf(
					'<p><strong>Xero Invoice:</strong> <a href="%s">%s</a></p>',
					'https://go.xero.com/AccountsPayable/Edit.aspx?InvoiceID=' . $invoices[ $org['id'] ],
					$invoices[ $org['id'] ]
				);
			} else {
				// Import it?
				$import_url = wp_nonce_url(
					add_query_arg(
						[
							'action'    => 'xero_create_bill',
							'post_id'   => $post->id,
							'tenant_id' => $org['id'],
						],
						admin_url( 'admin-ajax.php' )
					),
					'xero_bill'
				);
				printf(
					'<p><a href="%s" class="button">%s</a></p>',
					esc_url( $import_url ),
					sprintf(
						'Create draft Bill on %s',
						esc_html( $org['name'] )
					)
				);
			}
		}
	} else if ( $invoices ) {
		// This is shitty UX..
		foreach ( $invoices as $tenant => $invoice ) {
			printf(
				'<h3>%s</h3><p><strong>Xero Invoice:</strong> <a href="%s">%s</a></p>',
				esc_html( $invoice['org'] ),
				esc_url( 'https://go.xero.com/AccountsPayable/Edit.aspx?InvoiceID=' . $invoice['id'] ),
				esc_html( $invoice['id'] )
			);
		}
	}

	echo '<h3>Manage Connection</h3>';
	if ( $token ) {
		echo '<p><a href="' . esc_url( get_oauth_link() ) . '" class="button button-secondary">reConnect to Xero</a></p>';
		echo '<p><a href="' . esc_url( wp_nonce_url( admin_url( 'admin-ajax.php?action=xero_forget' ), 'xero_forget' ) ) . '" class="button button-secondary">Forget Connection</a></p>';
	} else {
		echo '<p><a href="' . esc_url( get_oauth_link() ) . '" class="button">Connect to Xero</a></p>';
	}
	echo '<p><a href="https://apps.xero.com/au/connected" class="button button-secondary">Manage Connected Apps</a></p>';
}

/**
 * "Forget" the locally stored details.
 */
function forget_me() {
	check_admin_referer( 'xero_forget' );

	delete_user_meta( get_current_user_id(), '_wpaus_xero' );

	header( 'Content-Type: text/html' );
	_default_wp_die_handler(
		'<h1>Your Xero details have been removed.</h1>' .
		'<p>You should now disconnect the WP Australia app from your Xero Account.<p>' .
		'<p><a href="https://apps.xero.com/au/connected" class="button button-secondary">Manage Connected Apps</a></p>'
	);
}
add_action( 'wp_ajax_xero_forget', __NAMESPACE__ . '\forget_me' );

/**
 * Create the Bill in Xero.
 */
function create_bill() {
	if ( ! isset( $_GET['_wpnonce'], $_GET['post_id'], $_GET['tenant_id'] ) ) {
		wp_die( "Invalid Request." );
	}

	check_admin_referer( 'xero_bill' );

	$token   = get_token();
	$tenant  = $_GET['tenant_id'];
	$message = new \Flamingo_Inbound_Message( $_GET['post_id'] );
	if ( ! $token || ! $tenant || ! $message ) {
		wp_die( "Something is MIA." );
	}

	// First word of the meetup group.
	$meetup = preg_replace( '!^(\S+).*$!', '$1', $message->fields['meetup'] );
	if ( 'WP-' != substr( $meetup, 0, 3 ) ) {
		$meetup = "WP-{$meetup}";
	}
	$tracking = [
		[ 'Name' => 'Area', 'Option' => 'WP-Aust' ],
		[ 'Name' => 'SubArea', 'Option' => $meetup ]
	];

	// Build the Bill. 
	$payload = [
		'Type'    => 'ACCPAY',
		'Contact' => [
			'Name' => $message->from_name,
			'EmailAddress' => $message->from_email,
		],
		'Date' => gmdate( 'Y-m-d', strtotime( $message->fields['date'] ) ?: time() ),
		'DueDate' => gmdate( 'Y-m-d', strtotime( '+3 weeks' ) ),
		'LineAmountTypes' => 'Inclusive',
		'Status' => 'DRAFT',
		'LineItems' => []
	];

	$files_to_upload = array();
	foreach ( [ '-one', '-two', '-three', '-four', '-five' ] as $field_suffix ) {
		// Empty ones were stripped out already.
		$fields = [];
		foreach ( $message->fields as $field => $field_data ) {
			if ( substr( $field, -1*strlen( $field_suffix ) ) === $field_suffix ) {
				$fields[ substr( $field, 0, -1*strlen( $field_suffix ) ) ] = $field_data;
			}
		}
		if ( ! $fields ) continue;

		// Track files..
		$files_to_upload[] = $fields['file'];

		$payload['LineItems'][] = [
			'Description' => sprintf(
				"%s meetup - %s - %s",
				$message->fields['meetup'],
				date( 'j M Y', strtotime( $message->fields['date'] ) ),
				$fields['vendor']
			),
			'Quantity' => 1,
			'UnitAmount' => round( $fields['cost'], 2 ),
			'AccountCode' => preg_replace( '!^(\S+).*$!', '$1', $fields['category'] ),
			'Tracking' => $tracking,
		];
	}

	$json = xero_api_t( $tenant, 'Invoices', json_encode( $payload ) );

	if ( $json ) {
		$invoice_id = $json->Invoices[0]->InvoiceID;

		$meta = get_post_meta( $message->id, '_xero_invoice', true ) ?: [];
		$meta[ $tenant ] = [
			'id'  => $invoice_id,
			'org' => get_token()['organisations'][$tenant]['name']
		];
		update_post_meta( $message->id, '_xero_invoice', $meta );

		xero_api_t(
			$tenant,
			'Invoices/' . $invoice_id . '/History',
			json_encode([
				"HistoryRecords" => [
					[
						"Details" => sprintf(
							"Processed by %s, Submitted by %s via %s from %s on %s",
							wp_get_current_user()->display_name,
							$message->from,
							$message->meta['url'],
							$message->meta['remote_ip'],
							$message->meta['date'] . ' ' . $message->meta['time']
						)
					]
				]
			])
		);

		// Upload files..
		$upload_details = wp_upload_dir();
		foreach ( $files_to_upload as $file_url ) {
			$file_name = str_replace( $upload_details['baseurl'], $upload_details['basedir'], $file_url );

			$upload_name = wp_basename( $file_name );
			// Remove the Month/secret token from the filename.
			if ( preg_match( '!^\d{8}-.{8}-!', $upload_name ) ) {
				$upload_name = substr( $upload_name, 18 );
			}

			$resp = xero_api_t(
				$tenant,
				'Invoices/' . $invoice_id . '/Attachments/' . $upload_name,
				file_get_contents( $file_name ),
				[ 'Content-Type'  => $mime = mime_content_type( $file_name )  ]
			);
		}

	} else {
		wp_die( "Invoice Creation Failed." );
	}

	wp_safe_redirect( $_SERVER['HTTP_REFERER'] );
	die();
};
add_action( 'wp_ajax_xero_create_bill', __NAMESPACE__ . '\create_bill' );

/**
 * The oAuth callback flow.
 * 
 * This has lots of doubled up HTTP queries, but it "works".
 */
function oAuth_callback() {
	if (
		! isset( $_GET['state'] ) ||
		( ! isset( $_GET['code'] ) && ! isset( $_GET['error'] ) )
	) {
		wp_die( "Invalid Request." );
	}

	$state_data = json_decode( wp_unslash( $_GET['state'] ) );

	// nonce verify.
	if ( ! wp_verify_nonce( $state_data->nonce, 'xero' ) ) {
		wp_die( 'Expired link.' );
	}

	if ( isset( $_GET['error'] ) ) {
		if ( !empty( $state_data->back_to ) ) {
			wp_safe_redirect( $state_data->back_to );
		} else {
			wp_safe_redirect( admin_url( 'admin.php?page=flamingo_inbound' ) );
		}

		die();
	}

	// Exchange for a token
	$json = xero_api(
		'connect/token',
		[
			'grant_type'   => 'authorization_code',
			'code'         => $_GET['code'],
			'redirect_uri' => admin_url( 'admin-ajax.php?action=xero_oauth_callback' )
		]
	);

	$token = false;
	if ( $json ) {
		$token = [
			'access_token'  => $json->access_token,
			'token_type'    => $json->token_type,
			'expiration'    => time() + $json->expires_in,
			'refresh_token' => $json->refresh_token,
		];

		// Update the tokens now, so it's available for xero_api() below.
		update_user_meta( get_current_user_id(), '_wpaus_xero', $token );
	}

	if ( ! empty( $token['access_token'] ) ) {
		$json = xero_api( 'connections' );
		if ( $json ) {
			foreach ( $json as $connection ) {
				$org_json = xero_api( 'organisation' );
				if ( $org_json ) {
					// Name, LegalName, OrganisationID (Tenant ID from above)
					$token['organisations'] ??= [];
					foreach ( $org_json->Organisations as $o ) {
						$token['organisations'][ $o->OrganisationID ] = array(
							'id'    => $o->OrganisationID,
							'name'  => $o->Name,
							'legal' => $o->LegalName,
						);
					}
				}
			}

			update_user_meta( get_current_user_id(), '_wpaus_xero', $token );
		}
	}

	if ( !empty( $state_data->back_to ) ) {
		wp_safe_redirect( $state_data->back_to );
	} else {
		wp_safe_redirect( admin_url( 'admin.php?page=flamingo_inbound' ) );
	}
	die();
}
add_action( 'wp_ajax_xero_oauth_callback', __NAMESPACE__ . '\oAuth_callback' );
