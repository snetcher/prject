<?php
/**
 * Template part for displaying posts
 *
 * @package WordPress
 * @subpackage WP_Start_Theme
 * @since 0.1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;

        if ('post' === get_post_type()) :
            ?>
            <div class="entry-meta">
                <?php
                $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
                if (get_the_time('U') !== get_the_modified_time('U')) {
                    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
                }

                $time_string = sprintf(
                    $time_string,
                    esc_attr(get_the_date(DATE_W3C)),
                    esc_html(get_the_date())
                );

                echo '<span class="posted-on">' . $time_string . '</span>';
                ?>
            </div>
        <?php endif; ?>
    </header>

    <?php wp_start_theme_post_thumbnail(); ?>

    <div class="entry-content">
        <?php
        if (is_singular()) :
            the_content();
        else :
            the_excerpt();
            ?>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="read-more">
                <?php esc_html_e('Read More', 'wp-start-theme'); ?>
            </a>
        <?php
        endif;
        ?>
    </div>

    <footer class="entry-footer">
        <?php
        $categories_list = get_the_category_list(esc_html__(', ', 'wp-start-theme'));
        if ($categories_list) {
            printf('<span class="cat-links">%s</span>', $categories_list);
        }

        $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'wp-start-theme'));
        if ($tags_list) {
            printf('<span class="tags-links">%s</span>', $tags_list);
        }
        ?>
    </footer>
</article> 