<?php
/**
 * The header for our theme
 *
 * @package WordPress
 * @subpackage WP_Start_Theme
 * @since 0.1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary">
        <?php esc_html_e('Skip to content', 'wp-start-theme'); ?>
    </a>

    <header class="site-header">
        <div class="site-header-inner">
            <div id="masthead">
                <div class="site-branding">
                    <?php
                    if (has_custom_logo()) :
                        the_custom_logo();
                    else :
                        ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                        <?php
                        $description = get_bloginfo('description', 'display');
                        if ($description || is_customize_preview()) :
                            ?>
                            <p class="site-description"><?php echo $description; ?></p>
                        <?php endif;
                    endif;
                    ?>
                </div>

                <nav id="site-navigation" class="main-navigation">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                        <svg viewBox="0 0 24 24">
                            <line x1="3" y1="12" x2="21" y2="12" />
                            <line x1="3" y1="6" x2="21" y2="6" />
                            <line x1="3" y1="18" x2="21" y2="18" />
                        </svg>
                        <?php esc_html_e('Menu', 'wp-start-theme'); ?>
                    </button>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                    ));
                    ?>
                </nav>
            </div>
        </div>
    </header>

    <script>
        // Menu close function
        function closeMenu() {
            const menuButton = document.querySelector('.menu-toggle');
            const mainNav = document.querySelector('.main-navigation');
            menuButton.setAttribute('aria-expanded', 'false');
            mainNav.classList.remove('is-active');
        }

        // Menu button click handler
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            const mainNav = document.querySelector('.main-navigation');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            mainNav.classList.toggle('is-active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            const menuButton = document.querySelector('.menu-toggle');
            const mainNav = document.querySelector('.main-navigation');
            const isMenuOpen = mainNav.classList.contains('is-active');
            
            if (isMenuOpen && !mainNav.contains(e.target) && !menuButton.contains(e.target)) {
                closeMenu();
            }
        });

        // Prevent closing when clicking inside menu
        document.querySelector('.main-navigation').addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Header hide/show on scroll
        let lastScroll = 0;
        const header = document.querySelector('.site-header');
        
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll <= 0) {
                header.classList.remove('is-hidden');
                return;
            }
            
            if (currentScroll > lastScroll && !header.classList.contains('is-hidden')) {
                // Scrolling down
                header.classList.add('is-hidden');
            } else if (currentScroll < lastScroll && header.classList.contains('is-hidden')) {
                // Scrolling up
                header.classList.remove('is-hidden');
            }
            
            lastScroll = currentScroll;
        });
    </script>

<?php wp_footer(); ?>
</body>
</html> 