<?php
namespace WPAustralia\Reimbursements;
/**
 * Plugin Name: WP Australia Reimbursements
 * Description: Expands upon Contact Form 7 & Flamingo to add reimbursement flow/etc.
 */

if ( ! class_exists( 'WPCF7_Submission' ) ) return;
if ( ! defined( 'FLAMINGO_VERSION' ) ) return;

include __DIR__ . '/wpcf7.php'; // For contact form integrations.
include __DIR__ . '/flamingo.php'; // For admin integration.
include __DIR__ . '/xero.php'; // For Xero integration.
include __DIR__ . '/public-shortcode.php'; // To provide a public log of approved/paid reimbursement transactions
