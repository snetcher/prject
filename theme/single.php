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
                    // Навигация между постами
                    the_post_navigation(array(
                        'prev_text' => '← %title',
                        'next_text' => '%title →',
                    ));

                    // Если комментарии открыты или есть хотя бы один комментарий, загружаем шаблон комментариев
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