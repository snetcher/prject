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
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.querySelector('.menu-toggle');
        const navigation = document.querySelector('.main-navigation');
        
        // Функция закрытия меню
        function closeMenu() {
            navigation.classList.remove('is-active');
            menuToggle.setAttribute('aria-expanded', 'false');
        }
        
        // Обработчик клика по кнопке меню
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            
            if (isExpanded) {
                closeMenu();
            } else {
                navigation.classList.add('is-active');
                menuToggle.setAttribute('aria-expanded', 'true');
            }
        });
        
        // Закрытие меню при клике вне его
        document.addEventListener('click', function(e) {
            if (!navigation.contains(e.target)) {
                closeMenu();
            }
        });
        
        // Предотвращаем закрытие при клике по меню
        navigation.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
    </script>

<?php wp_footer(); ?>
</body>
</html> 