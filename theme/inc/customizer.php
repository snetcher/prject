<?php
/**
 * Theme Customizer
 *
 * @package WordPress
 * @subpackage WP_Start_Theme
 * @since 0.1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wp_start_theme_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'wp_start_theme_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'wp_start_theme_customize_partial_blogdescription',
            )
        );
    }

    // Add Theme Colors Section
    $wp_customize->add_section(
        'wp_start_theme_colors',
        array(
            'title'    => __('Theme Colors', 'wp-start-theme'),
            'priority' => 30,
        )
    );

    // Primary Color Setting
    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => '#0073aa',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label'    => __('Primary Color', 'wp-start-theme'),
                'section'  => 'wp_start_theme_colors',
                'settings' => 'primary_color',
            )
        )
    );

    // Secondary Color Setting
    $wp_customize->add_setting(
        'secondary_color',
        array(
            'default'           => '#005177',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'secondary_color',
            array(
                'label'    => __('Secondary Color', 'wp-start-theme'),
                'section'  => 'wp_start_theme_colors',
                'settings' => 'secondary_color',
            )
        )
    );
}
add_action('customize_register', 'wp_start_theme_customize_register');

/**
 * Render the site title for the selective refresh partial.
 */
function wp_start_theme_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function wp_start_theme_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function wp_start_theme_customize_preview_js() {
    wp_enqueue_script('wp-start-theme-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), wp_get_theme()->get('Version'), true);
}
add_action('customize_preview_init', 'wp_start_theme_customize_preview_js'); 