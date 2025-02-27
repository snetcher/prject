<?php
/**
 * Plugin Name: WordPress Plugins Manager
 * Description: Automatically manages WordPress plugins: removes default plugins, installs and activates required plugins, and configures permalink structure
 * Version: 0.1.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Plugin management function
function manage_default_plugins() {
    // Force remove unwanted plugins
    $plugins_to_remove = array(
        'akismet' => array(
            'file' => 'akismet/akismet.php',
            'directory' => WP_PLUGIN_DIR . '/akismet'
        ),
        'hello' => array(
            'file' => 'hello.php',
            'directory' => WP_PLUGIN_DIR . '/hello.php'
        )
    );

    foreach ($plugins_to_remove as $plugin_name => $plugin_info) {
        error_log("Processing plugin: {$plugin_name}");
        
        // First try WP-CLI deactivation
        $deactivate_command = "wp plugin deactivate {$plugin_name} --allow-root 2>&1";
        shell_exec($deactivate_command);
        
        // Then try WordPress function
        if (function_exists('deactivate_plugins')) {
            deactivate_plugins($plugin_info['file']);
        }
        
        // Remove files directly
        if (file_exists($plugin_info['directory'])) {
            error_log("Removing {$plugin_info['directory']}");
            if (is_dir($plugin_info['directory'])) {
                recursive_rmdir($plugin_info['directory']);
            } else {
                unlink($plugin_info['directory']);
            }
        }
        
        // Verify removal
        if (!file_exists($plugin_info['directory'])) {
            error_log("Successfully removed {$plugin_name}");
        } else {
            error_log("Failed to remove {$plugin_name}");
        }
    }

    // Set permalink structure
    error_log("Setting permalink structure...");
    $permalink_command = "wp rewrite structure '/%postname%/' --allow-root 2>&1";
    $permalink_output = shell_exec($permalink_command);
    error_log("Permalink output: " . $permalink_output);

    // Flush rewrite rules
    $flush_command = "wp rewrite flush --allow-root 2>&1";
    $flush_output = shell_exec($flush_command);
    error_log("Rewrite flush output: " . $flush_output);

    // List of plugins to install
    $plugins_to_install = array(
        'admin-site-enhancements' => 'Admin and Site Enhancements (ASE)',
        'updraftplus' => 'UpdraftPlus'
    );

    foreach ($plugins_to_install as $plugin_slug => $plugin_name) {
        error_log("Processing {$plugin_name} installation...");
        
        // Check if plugin is already installed
        $check_command = "wp plugin is-installed {$plugin_slug} --allow-root 2>&1";
        $is_installed = shell_exec($check_command);
        
        if (strpos($is_installed, 'Success') === false) {
            error_log("Installing {$plugin_name}...");
            
            // Install and activate in one command
            $install_command = "wp plugin install {$plugin_slug} --activate --allow-root 2>&1";
            $install_output = shell_exec($install_command);
            error_log("Install output for {$plugin_name}: " . $install_output);
            
            // Double check activation
            $check_active_command = "wp plugin is-active {$plugin_slug} --allow-root 2>&1";
            $is_active = shell_exec($check_active_command);
            
            if (strpos($is_active, 'Success') === false) {
                error_log("Forcing activation of {$plugin_name}...");
                $activate_command = "wp plugin activate {$plugin_slug} --allow-root 2>&1";
                $activate_output = shell_exec($activate_command);
                error_log("Activation output for {$plugin_name}: " . $activate_output);
            }
        } else {
            error_log("{$plugin_name} is already installed");
            
            // Make sure it's activated
            $activate_command = "wp plugin activate {$plugin_slug} --allow-root 2>&1";
            $activate_output = shell_exec($activate_command);
            error_log("Activate output for {$plugin_name}: " . $activate_output);
        }
    }
}

// Helper function to recursively remove directories
function recursive_rmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                $full_path = $dir . "/" . $object;
                if (is_dir($full_path)) {
                    recursive_rmdir($full_path);
                } else {
                    unlink($full_path);
                }
            }
        }
        rmdir($dir);
        return true;
    }
    return false;
}

// Add action after theme activation (usually happens during first installation)
add_action('after_switch_theme', 'manage_default_plugins');

// Also add action on plugin activation (our mu-plugin)
if (is_admin()) {
    add_action('init', 'manage_default_plugins');
}
