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
    

    <div class="entry-content">
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
        <?php
        if (is_singular()) :
            the_content();
        else :
            the_excerpt();
            ?><?php if ('post' === get_post_type()) : ?>
                <footer class="entry-footer">
                    <div class="post-meta">
                        <!-- Debug Info -->
                        <pre style="display: none;">
                            Author: <?php var_dump(get_the_author()); ?>
                            Categories: <?php var_dump(get_the_category()); ?>
                            Tags: <?php var_dump(get_the_tags()); ?>
                        </pre>
                        <span class="author">
                            <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                            <?php echo esc_html__('By', 'wp-start-theme') . ' ' . get_the_author(); ?>
                        </span>
                        <span class="categories">
                            <?php the_category(', '); ?>
                        </span>
                        <span class="tags">
                            <?php the_tags('', ', '); ?>
                        </span>
                    </div>
                </footer>
            <?php endif; ?>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="read-more">
                <?php esc_html_e('Read More', 'wp-start-theme'); ?>
            </a>
        <?php
        endif;
        ?>
        
    </div>
</article>