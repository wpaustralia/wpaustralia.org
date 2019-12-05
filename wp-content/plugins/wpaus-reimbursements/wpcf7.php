<?php
namespace WPAustralia\Reimbursements\CF7;

/**
 * Filter out the extra file fields when not in use.
 */
function wpcf7_posted_data( $data ) {
	foreach ( [ '-one', '-two', '-three', '-four', '-five' ] as $field_suffix ) {
		$matching_fields = [];
		foreach ( $data as $field => $field_data ) {
			if ( substr( $field, -1*strlen( $field_suffix ) ) === $field_suffix ) {
				$matching_fields[ $field ] = $field_data;
			}
		}

		// If all are empty. unset.
		$empty = array_filter( $matching_fields, function( $item ) {
			return !empty( $item ) && $item !== '0.00';
		} );
		if ( ! $empty ) {
			foreach ( array_keys( $matching_fields ) as $k ) {
				unset( $data[ $k ] );
			}
		}
	}

	return $data;
}
add_filter( 'wpcf7_posted_data', __NAMESPACE__ . '\wpcf7_posted_data' );

/**
 * CF7 deletes the files shortly after this action..
 * Store them for later use.
 */
function wpcf7_mail_sent( $contact_form ) {
	// "Copy" any uploaded files to tmp
	$uploaded_files = \WPCF7_Submission::get_instance()->uploaded_files();

	// ie. Put it back in $_FILES after move_uploaded_file() stole it.
	foreach ( $uploaded_files as $form_field => $file ) {
		$tmp_file = tempnam( sys_get_temp_dir(), 'reimbursement-' );

		if ( copy( $file, $tmp_file ) ) {
			$_FILES[ $form_field ]['tmp_name'] = $tmp_file;
		}
	}
}
add_action( 'wpcf7_mail_sent', __NAMESPACE__ . '\wpcf7_mail_sent' );


/**
 * Attach files to the Flamingo message.
 */
function wpcf7_after_flamingo( $result ) {
	if ( empty( $result['flamingo_inbound_id'] ) ) {
		return;
	}

	$stored_message = new \Flamingo_Inbound_Message( $result['flamingo_inbound_id'] );
	$uploaded_files = \WPCF7_Submission::get_instance()->uploaded_files();

	if ( $uploaded_files ) {
		$upload_dir         = wp_upload_dir();
		$reimbursements_dir = $upload_dir['basedir'] . '/reimbursements';
		$reimbursements_url = $upload_dir['baseurl'] . '/reimbursements';

		wp_mkdir_p( $reimbursements_dir );
		if ( ! file_exists( "{$reimbursements_dir}/index.html" ) ) {
			@touch( "{$reimbursements_dir}/index.html" );
		}

		foreach ( $uploaded_files as $form_field => $file ) {
			$name = sprintf( "%s-%s-%s",
				gmdate( 'Ymd' ),
				wp_generate_password( 8, false ),
				wp_basename( $file )
			);
			$name = wp_unique_filename( $reimbursements_dir, $name );

			if ( rename( $_FILES[ $form_field ]['tmp_name'], "{$reimbursements_dir}/{$name}" ) ) {
				@chmod( "{$reimbursements_dir}/{$name}", 0666 );

				$stored_message->fields[ $form_field ] = "{$reimbursements_url}/{$name}";
			}
		}

		$stored_message->save();
	}

}
add_action( 'wpcf7_after_flamingo', __NAMESPACE__ . '\wpcf7_after_flamingo' );
