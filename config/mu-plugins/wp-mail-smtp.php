<?php
/**
 * Plugin Name: WP Mail SMTP Configuration
 * Description: Configure WordPress to use SMTP for emails
 * Version: 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Configure SMTP
function configure_smtp_settings($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'mailpit';
    $phpmailer->Port = 1025;
    $phpmailer->SMTPAuth = false;
    $phpmailer->SMTPAutoTLS = false;
    $phpmailer->SMTPSecure = '';
}
add_action('phpmailer_init', 'configure_smtp_settings'); 