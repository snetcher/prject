<?php
/**
 * Voice SMM functions and definitions
 */

if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

// Include theme options
require get_template_directory() . '/inc/theme-options.php';
require get_template_directory() . '/inc/social-icons.php';
require get_template_directory() . '/inc/polylang_init.php';

// Connecting theme styles and scripts
function voice_smm_styles() {
    wp_enqueue_style('theme-fonts', get_template_directory_uri() . '/assets/css/fonts.css', array(), _S_VERSION);
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/assets/css/theme.css', array(), _S_VERSION);
    wp_enqueue_script('navigation-js', get_template_directory_uri() . '/assets/js/navigation.js', array(), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'voice_smm_styles');

// Registering support for various WordPress features
function voice_smm_setup() {

    // Header support
    add_theme_support('title-tag');
    
    // Thumbnail support
    add_theme_support('post-thumbnails');
    
    // Support for wide images for Gutenberg
    add_theme_support('align-wide');
    
    // Custom logo support
    add_theme_support('custom-logo', array(
        'height'      => 56,
        'width'       => 136,
        'flex-height' => true,
        'flex-width'  => true,
        'unlink-homepage-logo' => false,
    ));
    
    // HTML5 support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    add_theme_support('editor-color-palette', [
        [
            'name'  => __('Pink', 'textdomain'),
            'slug'  => 'pink_color',
            'color' => '#E15197',
        ],
        [
            'name'  => __('Blue', 'textdomain'),
            'slug'  => 'blue_color',
            'color' => '#2799D6',
        ],
        [
            'name'  => __('Dark', 'textdomain'),
            'slug'  => 'dark_color',
            'color' => '#2D2D2C',
        ],
    ]);
    
    // Menu registration
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'voice-smm-theme'),
        'footer' => esc_html__('Footer Menu', 'voice-smm-theme'),
    ));
}
add_action('after_setup_theme', 'voice_smm_setup');

function voice_smm_load_theme_textdomain() {
    load_theme_textdomain('voice-smm-theme', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'voice_smm_load_theme_textdomain');
