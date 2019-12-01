<?php
namespace WPAustralia\Reimbursements\Flamingo;

// Linkify links in flamingo lists.
add_filter( 'flamingo_htmlize', 'make_clickable' );

/**
 * Add custom Statuses.
 */
function register_post_statuses() {
	register_post_status( 'paid', array(
		'post_type' => \Flamingo_Inbound_Message::post_type,
		'label' => 'Paid',
		'public' => true,
		'show_in_admin_all_list' => true,
		'show_in_admin_status_list' => true,
	) );

	register_post_status( 'approved', array(
		'post_type' => \Flamingo_Inbound_Message::post_type,
		'label' => 'Approved',
		'public' => true,
		'show_in_admin_all_list' => true,
		'show_in_admin_status_list' => true,
	) );

	register_post_status( 'declined', array(
		'post_type' => \Flamingo_Inbound_Message::post_type,
		'label' => 'Declined',
		'public' => true,
		'show_in_admin_all_list' => true,
		'show_in_admin_status_list' => true,
	) );
}
add_action( 'flamingo_init', __NAMESPACE__ . '\register_post_statuses');

/**
 * Add the Approved/Declined/Paid statuses to the table filter.
 */
add_filter( 'views_flamingo_page_flamingo_inbound', function( $views ) {

	// Overide the Inbox item to override the current class.
	$count = \Flamingo_Inbound_Message::count([ 'post_status' => 'publish' ]);
	$text = sprintf(
		_nx(
			'Inbox <span class="count">(%s)</span>',
			'Inbox <span class="count">(%s)</span>',
			$count, 'posts', 'wpaus'
		),
		number_format_i18n( $count )
	);
	$views['inbox'] = sprintf(
		'<a href="%1$s"%2$s>%3$s</a>',
		menu_page_url( 'flamingo_inbound', false ),
		( ! isset( $_REQUEST['post_status'] ) ) ? ' class="current"' : '',
		$text
	);

	$count = \Flamingo_Inbound_Message::count([ 'post_status' => 'approved' ]);
	$text = sprintf(
		_nx(
			'Approved <span class="count">(%s)</span>',
			'Approved <span class="count">(%s)</span>',
			$count, 'posts', 'wpaus'
		),
		number_format_i18n( $count )
	);
	$views['approved'] = sprintf(
		'<a href="%1$s"%2$s>%3$s</a>',
		add_query_arg( ['post_status' => 'approved'], menu_page_url( 'flamingo_inbound', false ) ),
		( isset( $_REQUEST['post_status'] ) && 'approved' === $_REQUEST['post_status'] ) ? ' class="current"' : '',
		$text
	);

	$count = \Flamingo_Inbound_Message::count([ 'post_status' => 'paid' ]);
	$text = sprintf(
		_nx(
			'Paid <span class="count">(%s)</span>',
			'Paid <span class="count">(%s)</span>',
			$count, 'posts', 'wpaus'
		),
		number_format_i18n( $count )
	);
	$views['paid'] = sprintf(
		'<a href="%1$s"%2$s>%3$s</a>',
		add_query_arg( ['post_status' => 'paid'], menu_page_url( 'flamingo_inbound', false ) ),
		( isset( $_REQUEST['post_status'] ) && 'paid' === $_REQUEST['post_status'] ) ? ' class="current"' : '',
		$text
	);

	$count = \Flamingo_Inbound_Message::count([ 'post_status' => 'declined' ]);
	$text = sprintf(
		_nx(
			'Declined <span class="count">(%s)</span>',
			'Declined <span class="count">(%s)</span>',
			$count, 'posts', 'wpaus'
		),
		number_format_i18n( $count )
	);
	$views['declined'] = sprintf(
		'<a href="%1$s"%2$s>%3$s</a>',
		add_query_arg( ['post_status' => 'declined'], menu_page_url( 'flamingo_inbound', false ) ),
		( isset( $_REQUEST['post_status'] ) && 'declined' === $_REQUEST['post_status'] ) ? ' class="current"' : '',
		$text
	);

	return $views;
});

/**
 * Allow filtering to approved/declined/paid
 */
add_filter( 'pre_get_posts', function( $query ) {
	if (
		is_admin() &&
		isset( $_GET['page'] ) && 'flamingo_inbound' === $_GET['page'] &&
		( empty( $query->query['post_status'] ) || 'any' === $query->query['post_status'] )
	) {
		if ( \Flamingo_Inbound_Message::post_type === $query->query['post_type'] ) {
			$query->query['post_status'] = $query->query_vars['post_status'] = $_REQUEST['post_status'] ?? 'publish';
		}
	}
});

/**
 * Save additional approved/declined/paid statuses.
 */
add_action( 'load-flamingo_page_flamingo_inbound', function() {
	if (
		'save' == flamingo_current_action() &&
		! empty( $_REQUEST['post'] ) &&
		! empty( $_POST['inbound']['status'] )
	) {
		$post = get_post( $_REQUEST['post'] );

		if ( ! $post )
			return;

		if ( ! current_user_can( 'flamingo_edit_inbound_message', $post->ID ) )
			wp_die( __( 'You are not allowed to edit this item.', 'flamingo' ) );

		check_admin_referer( 'flamingo-update-inbound_' . $post->ID );

		$status = $_POST['inbound']['status'];

		if ( $status != get_post_status( $post->ID ) ) {
			wp_update_post([
				'ID' => $post->ID,
				'post_status' => $status
			]);
		}
	}
}, 9 );

/**
 * Add the extra statuses to the Submit box.
 */
add_action( 'load-flamingo_page_flamingo_inbound', function() {
	if ( 'edit' == flamingo_current_action() ) {
		add_meta_box(
			'submitdiv', __( 'Status', 'flamingo' ),
			function( $post ) {
				ob_start();
				\flamingo_inbound_submit_meta_box( $post );
				$output = ob_get_clean();

				$statuses = [];
				$status   = get_post_status( $post->id );
				if ( 'publish' === $status ) {
					$status = 'ham';
				}

				// The statuses we need.
				foreach ( [
					'ham' => 'Inbox',
					'approved' => 'Approved',
					'declined' => 'Declined',
					'paid' => 'Paid',
					'spam' => 'Spam'
				] as $value => $text ) {
					$statuses[] = '<label><input type="radio" ' . checked( $status, $value, false ) . ' name="inbound[status]" value="' . $value . '">' . $text . '</label>';
				}

				echo preg_replace(
					'!(<fieldset.+?>).+(</fieldset>)!is',
					'$1' . implode( '<br>', $statuses ) . '$2',
					$output
				);
			},
			null, 'side', 'core'
		);
	}
});
