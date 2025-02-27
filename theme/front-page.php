<?php
/**
 * The front page template file
 *
 * @package WordPress
 * @subpackage WP_Start_Theme
 * @since 0.1.0
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title"><?php bloginfo('name'); ?></h1>
            <?php if (get_bloginfo('description')) : ?>
                <div class="hero-meta"><?php bloginfo('description'); ?></div>
            <?php endif; ?>
        </div>
    </section>

    <div class="site-content-wrap">
        <div class="content-area">
            <div class="main-content">
                <?php
                if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        get_template_part('template-parts/content', get_post_type());
                    endwhile;

                    the_posts_navigation();
                else :
                    get_template_part('template-parts/content', 'none');
                endif;
                ?>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php
get_footer(); 