<?php
/**
 * The template for displaying all single posts
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
                            <footer class="entry-footer">
                            <div class="post-meta">
                                <span class="author">
                                    <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                                    <?php echo esc_html__('By', 'wp-start-theme') . ' ' . get_the_author(); ?>
                                </span>
                                <span class="categories">
                                    <?php the_category(', '); ?>
                                </span>
                                <?php
                                $tags_list = get_the_tag_list('', ', ');
                                if ($tags_list) :
                                ?>
                                    <span class="tags-links">
                                        <?php echo $tags_list; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </footer>
                        </div>
                    </article>

                    <?php
                    // Post navigation
                    the_post_navigation(
                        array(
                            'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'wp-start-theme') . '</span> <span class="nav-title">%title</span>',
                            'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'wp-start-theme') . '</span> <span class="nav-title">%title</span>',
                        )
                    );

                    // If comments are open or we have at least one comment, load up the comment template
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                </div>
                <?php get_sidebar(); ?>
            </div>
        </div>
    <?php endwhile; ?>
</main>

<?php
get_footer(); 