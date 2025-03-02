<?php
/**
 * Plugin Name: ACF Custom Repeater
 * Plugin URI: https://yourwebsite.com/acf-custom-repeater
 * Description: Custom repeater field type for Advanced Custom Fields that works with the free version.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * License: GPL2
 * Text Domain: acf-custom-repeater
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/debug.log');

// Define plugin constants
define('ACFCR_PATH', plugin_dir_path(__FILE__));
define('ACFCR_URL', plugin_dir_url(__FILE__));
define('ACFCR_VERSION', time()); // Use timestamp for development

// Check if ACF is active
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (!is_plugin_active('advanced-custom-fields/acf.php') && !is_plugin_active('advanced-custom-fields-pro/acf.php')) {
    add_action('admin_notices', function() {
        ?>
        <div class="notice notice-error">
            <p><?php _e('ACF Custom Repeater requires Advanced Custom Fields plugin to be installed and activated.', 'acf-custom-repeater'); ?></p>
        </div>
        <?php
    });
    return;
}

// Debug info
add_action('admin_notices', function() {
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'acf-field-group') {
        error_log('ACF Custom Repeater - Debug Info:');
        error_log('ACFCR_PATH: ' . ACFCR_PATH);
        error_log('ACFCR_URL: ' . ACFCR_URL);
        error_log('Plugin File: ' . __FILE__);
        error_log('ACF exists: ' . (class_exists('acf') ? 'yes' : 'no'));
        if (class_exists('acf')) {
            error_log('ACF version: ' . acf()->version);
        }
        ?>
        <div class="notice notice-info is-dismissible">
            <p><strong>ACF Custom Repeater Debug Info:</strong></p>
            <p>ACFCR_PATH: <?php echo ACFCR_PATH; ?></p>
            <p>ACFCR_URL: <?php echo ACFCR_URL; ?></p>
            <p>Plugin File: <?php echo __FILE__; ?></p>
            <p>ACF exists: <?php echo class_exists('acf') ? 'yes' : 'no'; ?></p>
            <?php if (class_exists('acf')): ?>
                <p>ACF version: <?php echo acf()->version; ?></p>
            <?php endif; ?>
            <p>Script URL: <?php echo ACFCR_URL . 'js/acf-custom-repeater.js'; ?></p>
            <p>Style URL: <?php echo ACFCR_URL . 'css/acf-custom-repeater.css'; ?></p>
            <script>
            console.log('ACF Custom Repeater - Debug script loaded');
            jQuery(document).ready(function($) {
                console.log('ACF Custom Repeater - Document ready');
                console.log('ACF exists:', typeof acf !== 'undefined');
                if (typeof acf !== 'undefined') {
                    console.log('ACF version:', acf.version);
                }
                console.log('jQuery version:', $.fn.jquery);
            });
            </script>
        </div>
        <?php
    }
});

// Include the field type class
function acfcr_include_field_type() {
    if (!class_exists('acf_field')) {
        error_log('ACF Custom Repeater - acf_field class not found');
        return;
    }
    
    if (!class_exists('ACFCR_Custom_Repeater_Field')) {
        error_log('ACF Custom Repeater - Including field type class');
        require_once ACFCR_PATH . 'includes/class-acf-custom-repeater-field.php';
    }
}
add_action('acf/include_field_types', 'acfcr_include_field_type');

// Enqueue admin assets
function acfcr_admin_enqueue_scripts() {
    $screen = get_current_screen();
    error_log('ACF Custom Repeater - Current screen: ' . print_r($screen, true));
    
    // Only enqueue on ACF field group pages
    if (!$screen || !in_array($screen->id, array('acf-field-group', 'acf-field-group-category'))) {
        error_log('ACF Custom Repeater - Skipping script enqueue for screen: ' . $screen->id);
        return;
    }
    
    error_log('ACF Custom Repeater - Enqueuing scripts');
    
    // Register & include CSS
    wp_register_style('acf-custom-repeater', ACFCR_URL . 'css/acf-custom-repeater.css', array('acf-input'), ACFCR_VERSION);
    wp_enqueue_style('acf-custom-repeater');
    
    // Register & include JS
    wp_register_script('acf-custom-repeater', ACFCR_URL . 'js/acf-custom-repeater.js', array('acf-input', 'jquery-ui-sortable'), ACFCR_VERSION, true);
    wp_enqueue_script('acf-custom-repeater');
    
    // Add inline script for debugging
    wp_add_inline_script('acf-custom-repeater', 'console.log("ACF Custom Repeater - Inline script loaded");', 'before');
    
    // Add script data
    wp_localize_script('acf-custom-repeater', 'acfcr_data', array(
        'plugin_url' => ACFCR_URL,
        'version' => ACFCR_VERSION,
        'debug' => true
    ));
    
    error_log('ACF Custom Repeater - Scripts enqueued');
}
add_action('admin_enqueue_scripts', 'acfcr_admin_enqueue_scripts');