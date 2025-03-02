<?php
/**
 * Plugin Name: Auto Install Required Plugins
 * Description: Automatically installs and activates required plugins
 * Version: 1.0
 * Author: Your Name
 */

// Prevent direct access
if (!defined('ABSPATH')) exit;

// Include WordPress plugin functions
require_once(ABSPATH . 'wp-admin/includes/plugin.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/misc.php');
require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
require_once(ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php');
require_once(ABSPATH . 'wp-admin/includes/plugin-install.php');

/**
 * Remove unwanted plugins
 */
function remove_unwanted_plugins() {
    // Only run on admin pages
    if (!is_admin()) return;

    // List of plugins to remove
    $plugins_to_remove = array(
        'hello.php' => 'Hello Dolly',
        'akismet/akismet.php' => 'Akismet'
    );

    foreach ($plugins_to_remove as $plugin_file => $plugin_name) {
        if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_file)) {
            // Deactivate if active
            if (is_plugin_active($plugin_file)) {
                deactivate_plugins($plugin_file);
                error_log("Deactivated {$plugin_name}");
            }

            // Delete plugin files
            $deleted = delete_plugins(array($plugin_file));
            if ($deleted) {
                error_log("Successfully removed {$plugin_name}");
            } else {
                error_log("Failed to remove {$plugin_name}");
            }
        }
    }
}

/**
 * Install and activate required plugins
 */
function install_and_activate_plugins() {
    // Only run on admin pages
    if (!is_admin()) return;

    // First remove unwanted plugins
    remove_unwanted_plugins();

    // List of required plugins with their download URLs
    $plugins = array(
        'admin-site-enhancements' => array(
            'name' => 'Admin and Site Enhancements (ASE)',
            'url' => 'https://downloads.wordpress.org/plugin/admin-site-enhancements.latest-stable.zip',
            'file' => 'admin-site-enhancements/admin-site-enhancements.php'
        ),
        'updraftplus' => array(
            'name' => 'UpdraftPlus',
            'url' => 'https://downloads.wordpress.org/plugin/updraftplus.latest-stable.zip',
            'file' => 'updraftplus/updraftplus.php'
        ),
        'advanced-custom-fields' => array(
            'name' => 'Advanced Custom Fields',
            'url' => 'https://downloads.wordpress.org/plugin/advanced-custom-fields.latest-stable.zip',
            'file' => 'advanced-custom-fields/acf.php'
        )
    );

    foreach ($plugins as $slug => $plugin) {
        // Check if plugin is already installed and activated
        if (!is_plugin_active($plugin['file'])) {
            // Check if plugin directory exists
            $plugin_dir = WP_PLUGIN_DIR . '/' . dirname($plugin['file']);
            
            if (!file_exists($plugin_dir)) {
                // Install the plugin
                $upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
                $installed = $upgrader->install($plugin['url']);

                if (!is_wp_error($installed) && $installed) {
                    error_log("Successfully installed {$plugin['name']}");
                    // Activate the plugin
                    $activated = activate_plugin($plugin['file']);
                    if (is_wp_error($activated)) {
                        error_log("Failed to activate {$plugin['name']}: " . $activated->get_error_message());
                    } else {
                        error_log("Successfully activated {$plugin['name']}");
                    }
                } else {
                    error_log("Failed to install {$plugin['name']}");
                }
            } else {
                // Plugin exists but not activated
                $activated = activate_plugin($plugin['file']);
                if (is_wp_error($activated)) {
                    error_log("Failed to activate {$plugin['name']}: " . $activated->get_error_message());
                } else {
                    error_log("Successfully activated {$plugin['name']}");
                }
            }
        }
    }
}

// Run on admin init with lower priority to ensure all required functions are loaded
add_action('admin_init', 'install_and_activate_plugins', 20);

/**
 * Check plugin status and display admin notice
 */
function check_plugins_status() {
    // Only run on admin pages
    if (!is_admin()) return;

    $messages = array();

    // Check for plugins to remove
    $plugins_to_remove = array(
        'hello.php' => 'Hello Dolly',
        'akismet/akismet.php' => 'Akismet'
    );

    foreach ($plugins_to_remove as $plugin_file => $plugin_name) {
        if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_file)) {
            $messages[] = "Removing {$plugin_name}...";
        }
    }

    // Check for plugins to install
    $required_plugins = array(
        'admin-site-enhancements/admin-site-enhancements.php' => 'Admin and Site Enhancements (ASE)',
        'updraftplus/updraftplus.php' => 'UpdraftPlus',
        'advanced-custom-fields/acf.php' => 'Advanced Custom Fields'
    );

    foreach ($required_plugins as $plugin_path => $plugin_name) {
        if (!is_plugin_active($plugin_path)) {
            $messages[] = "Installing and activating {$plugin_name}...";
        }
    }

    if (!empty($messages)) {
        add_action('admin_notices', function() use ($messages) {
            ?>
            <div class="notice notice-info">
                <p><strong>Plugin Management:</strong></p>
                <ul>
                    <?php foreach ($messages as $message): ?>
                        <li><?php echo $message; ?></li>
                    <?php endforeach; ?>
                </ul>
                <p>Please wait while the changes are being applied...</p>
            </div>
            <?php
        });
    }
}

// Check plugins status
add_action('admin_init', 'check_plugins_status', 10);
