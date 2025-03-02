<?php
/**
 * The template for displaying all pages
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while (have_posts()) :
        the_post();
        get_template_part('template-parts/hero');
        ?>
        <div class="site-content-wrap">
            <div class="content-area">
                <div class="main-content">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </article>
                </div>
                <?php get_sidebar(); ?>
            </div>
        </div>
    <?php endwhile; ?>
</main>

<?php
get_footer(); 