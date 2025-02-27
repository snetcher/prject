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
                        </div>

                        <footer class="entry-footer">
                            <?php
                            $tags_list = get_the_tag_list('', ', ');
                            if ($tags_list) :
                            ?>
                                <span class="tags-links">
                                    <?php echo $tags_list; ?>
                                </span>
                            <?php endif; ?>
                        </footer>
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