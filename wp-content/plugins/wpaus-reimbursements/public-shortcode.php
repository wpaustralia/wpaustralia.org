<?php
namespace WPAustralia\Reimbursements\PublicShortcode;

function reimbursement_listing_shortcode() {
	ob_start();

	$items = get_items();
	echo '<ol>';
	foreach ( $items as $item ) {
		printf(
			"<li>On <em>%s</em> <em>%s</em> requested <strong>$%s</strong> for the <em>%s</em> meetup held on <em>%s</em> for <em>%s</em> - <strong>%s</strong></li>",
			gmdate( 'j F Y', strtotime( $item->when ) ),
			$item->who,
			number_format_i18n( $item->cost, 2 ),
			$item->for[0],
			gmdate( 'j F Y', strtotime( $item->for[1] ) ),
			implode( ', ', array_map( function( $text ) {
				// Remove any account prefixes, ie. 'FOOD - ', we only want descriptions.
				return preg_replace( '!^[A-Z-]+ - (.+)$!', '$1', $text );
			}, $item->what ) ),
			ucwords( $item->status )
		);
	}
	echo '</ol>';

	return ob_get_clean();
}
add_shortcode( 'reimbursement-lisitng', __NAMESPACE__ . '\reimbursement_listing_shortcode' );

function get_items() {
	// TODO: Should somehow get sponsor invoices into this set of data?

	$items    = [];
	$messages = \Flamingo_Inbound_Message::find([
		'posts_per_page' => 999,
		'channel' => 'reimbursement-request',
		'post_status' => [ 'publish', 'approved', 'declined', 'paid' ],
	]);

	foreach ( $messages as $m ) {
		$status = 'Pending Review';
		switch ( get_post_status( $m->id ) ) {
			case 'publish':
				$status = 'Pending Review';
			break;
			case 'approved':
				$status = 'Pending Reimbursement';
				break;
			case 'declined':
			case 'paid':
				$status = ucwords( get_post_status( $m->id ) );
				break;
		}

		$items[] = (object) [
			'who'  => $m->fields['your-name'],
			'when' => get_post_field( 'post_date', $m->id ),
			'for'  => [ $m->fields['meetup'], $m->fields['date'] ],
			'what' => array_unique( array_filter( [
				$m->fields['category-one'],
				$m->fields['category-two'] ?? false, 
				$m->fields['category-three'] ?? false,
				$m->fields['category-four'] ?? false,
				$m->fields['category-five'] ?? false,
			] ) ),
			'cost' => array_sum( [
				$m->fields['cost-one'],
				$m->fields['cost-two'] ?? 0.00, 
				$m->fields['cost-three'] ?? 0.00,
				$m->fields['cost-four'] ?? 0.00,
				$m->fields['cost-five'] ?? 0.00,
			] ),
			'status' => $status,
		];

	}

	return $items;
}
