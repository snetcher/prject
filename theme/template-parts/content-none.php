<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package WordPress
 * @subpackage WP_Start_Theme
 * @since 0.1.0
 */
?>

<section class="no-results not-found">
    <header class="entry-header">
        <h1 class="entry-title"><?php esc_html_e('Nothing Found', 'wp-start-theme'); ?></h1>
    </header>

    <div class="entry-content">
        <?php
        if (is_home() && current_user_can('publish_posts')) :
            printf(
                '<p>' . wp_kses(
                    /* translators: 1: link to WP admin new post page. */
                    __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'wp-start-theme'),
                    array(
                        'a' => array(
                            'href' => array(),
                        ),
                    )
                ) . '</p>',
                esc_url(admin_url('post-new.php'))
            );
        elseif (is_search()) :
            ?>
            <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wp-start-theme'); ?></p>
            <?php
            get_search_form();
        else :
            ?>
            <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'wp-start-theme'); ?></p>
            <?php
            get_search_form();
        endif;
        ?>
    </div>
</section> 