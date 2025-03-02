<?php
/**
 * Theme functions and definitions
 *
 * @package WordPress
 * @subpackage WP_Start_Theme
 * @since 0.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Custom template tags
require get_template_directory() . '/inc/template-tags.php';

// Customizer additions
require get_template_directory() . '/inc/customizer.php';

// Theme Setup
function wp_start_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add support for full and wide align images
    add_theme_support('align-wide');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'wp-start-theme'),
        'footer'  => __('Footer Menu', 'wp-start-theme'),
    ));
}
add_action('after_setup_theme', 'wp_start_theme_setup');

// Enqueue scripts and styles
function wp_start_theme_scripts() {
    // Google Fonts
    wp_enqueue_style('wp-start-theme-fonts', 'https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Rajdhani:wght@300;400;500;600;700&display=swap', array(), null);

    // Theme stylesheet
    wp_enqueue_style('wp-start-theme-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
    wp_enqueue_style('wp-start-theme-main-style', get_template_directory_uri() . '/assets/css/style.css', array('wp-start-theme-fonts'), wp_get_theme()->get('Version'));

    // Theme script
    wp_enqueue_script('wp-start-theme-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), wp_get_theme()->get('Version'), true);

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Скрипт для управления шапкой
    wp_enqueue_script('theme-header', get_template_directory_uri() . '/assets/js/header.js', array(), '1.0', true);

    // Скрипт для кнопки прокрутки вверх
    wp_enqueue_script('theme-back-to-top', get_template_directory_uri() . '/assets/js/back-to-top.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'wp_start_theme_scripts');

// Register widget areas
function wp_start_theme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'wp-start-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'wp-start-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget Area', 'wp-start-theme'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in your footer.', 'wp-start-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'wp_start_theme_widgets_init');

// Add post thumbnail function
if (!function_exists('wp_start_theme_post_thumbnail')) :
    function wp_start_theme_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div>
            <?php
        else :
            ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php the_post_thumbnail('post-thumbnail', array('alt' => the_title_attribute(array('echo' => false)))); ?>
            </a>
            <?php
        endif;
    }
endif; 