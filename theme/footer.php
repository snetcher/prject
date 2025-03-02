<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage WP_Start_Theme
 * @since 0.1.0
 */
?>

    <footer id="colophon" class="site-footer">
        <div class="site-info">
            <?php if (is_active_sidebar('footer-1')) : ?>
                <div class="footer-widgets">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
            <?php endif; ?>

            <nav class="footer-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_id'        => 'footer-menu',
                    'depth'          => 1,
                ));
                ?>
            </nav>

            <div class="site-credits">
                <a href="<?php echo esc_url(__('https://wordpress.org/', 'wp-start-theme')); ?>">
                    <?php printf(esc_html__('Proudly powered by %s', 'wp-start-theme'), 'WordPress'); ?>
                </a>
                <span class="sep"> | </span>
                <?php printf(esc_html__('Theme: %1$s', 'wp-start-theme'), 'WP Start Theme'); ?>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html> 