<?php
namespace WPAustralia\Reimbursements\Xero;

function get_oauth_link( $back_to = '' ) {
	if ( ! $back_to ) {
		$back_to = $_SERVER['REQUEST_URI'];
	}

	$url = 'https://login.xero.com/identity/connect/authorize?response_type=code' . 
		'&client_id=' . WPAUS_XERO_CLIENTID .
		'&redirect_uri=' . admin_url( 'admin-ajax.php?action=xero_oauth_callback' ) . 
		'&scope=' . implode( ' ', [
			'accounting.transactions',  // For invoice creation
			'accounting.attachments',   // ..to attach files to the invoice, not 'files'
			'accounting.settings.read', // To be able to read the Organisation name..
			'offline_access'            // To be able to refresh the access_token since Xero fails to unlink apps when it expires and has no re-auth flow. "Beta"
		] ) .
		'&state=' . urlencode( json_encode( [
			'nonce'   => wp_create_nonce( 'xero' ),
			'back_to' => $back_to, // Passing through state, as Xero requires the redirect_uri to match exactly.. no context?
		]) );

	return $url;
}

function get_token() {
	$token = get_user_meta( get_current_user_id(), '_wpaus_xero', true );
	if ( $token && $token['expiration'] > time() ) {
		return $token;
	}

	if ( $token && $token['refresh_token'] ) {
		return refresh_token( $token );
	}

	return false;
}

/**
* Since Xero doesn't handle oAuth2 apps access_tokens expiring
* (No really, it expires, but you have to manually disconnect to reconnect..)
*/
function refresh_token( $token ) {
	$json = xero_api( 'connect/token', [
		'grant_type'    => 'refresh_token',
		'refresh_token' => $token['refresh_token']
	] );

	if ( $json ) {
		$token['access_token']  = $json->access_token;
		$token['token_type']    = $json->token_type;
		$token['expiration']    = time() + $json->expires_in;
		$token['refresh_token'] = $json->refresh_token;

		update_user_meta( get_current_user_id(), '_wpaus_xero', $token );
	}

	return $token;
}


// Xero API as a specific Tenant ID.
function xero_api_t( $tenant, $endpoint, $payload = false, $headers = [], $method = null ) {
	return xero_api( $endpoint, $payload, $headers, $method, $tenant );
}

function xero_api( $endpoint, $payload = false, $headers = [], $method = null, $tenant = false ) {

	if ( is_null( $method ) ) {
		$method = $payload ? 'POST' : 'GET';
	}

	$base_url = 'https://api.xero.com/';

	if ( 'connections' === $endpoint ) {
		$tenant = false; // This endpoint returns the tenants
	} elseif ( 'connect/token' === $endpoint ) {
		// Different host
		$base_url = 'https://identity.xero.com/';
		// Needs Basic auth
		$auth = 'BASIC ' . base64_encode( WPAUS_XERO_CLIENTID . ':' . WPAUS_XERO_SECRET );
		// Without tenants specified.
		$tenant = false;
	} else {
		// Actual rest-api endpoint?
		$base_url .= 'api.xro/2.0/';
	}

	// Only fetch the token details when needed..
	if ( ! isset( $auth ) || ! isset( $tenant ) ) {
		$token = get_token();
		$auth = 'Bearer ' . $token['access_token'];
	
		// Fall back to the first we find.
		if ( ! isset( $tenant ) ) {
			$tenant = array_keys( $token['organisations'] )[0];
		}
	}

	$args = [
		'method'       => $method,
		'body'         => $payload,
		'redirection'  => 0,
		'headers'      => array_merge(
			[
				'Authorization' => $auth,
				'Accept'        => 'application/json',
			],
			'POST' === $method && ! isset( $headers['Content-Type' ] ) && is_string( $payload ) && '{' == substr( $payload, 0, 1 ) ? [ 'Content-Type' => 'application/json' ] : [],
			$tenant ? [ 'Xero-tenant-id' => $tenant ] : [],
			$headers
		),
	];

	$resp = wp_remote_request( $base_url . $endpoint, $args );

	$code = wp_remote_retrieve_response_code( $resp );
	if (
		$code >= 200 && $code < 300 &&
		( $json = json_decode( wp_remote_retrieve_body( $resp ) ) )
	) {
		return $json;
	}

	//var_dump( $args, $resp );
	wp_die( wp_remote_retrieve_body( $resp ) );

	return false;
}
