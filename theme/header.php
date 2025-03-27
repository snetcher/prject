<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package shopping-expert
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'shopping-expert' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container">
			<div class="site-header-inner">
				<div class="site-branding">
					<?php
					if ( has_custom_logo() ) :
						the_custom_logo();
					endif;
					?>
				</div><!-- .site-branding -->

				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<span class="menu-icon"></span>
				</button>

				<nav id="site-navigation" class="main-navigation">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
						)
					);
					?>
				</nav><!-- #site-navigation -->

				<div class="site-cta">
					<a href="#" class="btn btn-bordered btn-color-pink icon-pdf">Задати питання<svg class="filled" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.81282 12.6118L4.05025 13.8493L11.4749 6.42465L12.7123 7.66208L13.9497 6.42465L12.7123 5.18721L13.9497 3.94977L12.7123 2.71234L11.4749 3.94977L10.2374 2.71234L9 3.94977L10.2374 5.18721L2.81282 12.6118ZM6.52513 3.94977L7.76256 2.71234L9 3.94977L7.76256 5.18721L6.52513 3.94977ZM6.52513 3.94977L5.28769 5.18721L4.05025 3.94977L5.28769 2.71234L6.52513 3.94977ZM12.7123 10.137L13.9497 8.89952L12.7123 7.66208L11.4749 8.89952L12.7123 10.137ZM12.7123 10.137L11.4749 11.3744L12.7123 12.6118L13.9497 11.3744L12.7123 10.137Z" fill="#2d2d2c"></path></svg>    </a>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->