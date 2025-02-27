<?php
/**
 * Plugin Name: WP Mail SMTP Configuration
 * Description: Configure WordPress to use SMTP for emails
 */

add_action('phpmailer_init', function($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'mailpit';
    $phpmailer->Port = 1025;
    $phpmailer->SMTPAuth = false;
    $phpmailer->SMTPAutoTLS = false;
    $phpmailer->SMTPSecure = '';

    // For debugging
    $phpmailer->SMTPDebug = 0;
});

// Optional: log all emails
add_action('wp_mail_failed', function($error) {
    error_log('WordPress Mail Error: ' . print_r($error, true));
}); 