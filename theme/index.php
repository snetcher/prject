<?php
/**
 * The main template file
 *
 * @package WordPress
 * @subpackage WP_Start_Theme
 * @since 0.1.0
 */

get_header();
?>

<?php if (have_posts()) : ?>
    <?php if (is_home() && !is_front_page()) : ?>
        <section class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title"><?php single_post_title(); ?></h1>
                <?php if (get_the_excerpt()) : ?>
                    <div class="hero-meta"><?php echo get_the_excerpt(); ?></div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>

<div class="site-content-wrap">
    <div class="content-area">
        <div class="main-content">
            <main id="primary" class="site-main">
                <?php
                if (have_posts()) :
                    /* Start the Loop */
                    while (have_posts()) :
                        the_post();
                        get_template_part('template-parts/content', get_post_type());
                    endwhile;

                    the_posts_navigation();
                else :
                    get_template_part('template-parts/content', 'none');
                endif;
                ?>
            </main>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?> 