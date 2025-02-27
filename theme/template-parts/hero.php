<?php
/**
 * Template part for displaying page hero
 */
?>

<section class="page-hero">
    <div class="hero-content">
        <?php if (is_singular()) : ?>
            <h1 class="hero-title"><?php single_post_title(); ?></h1>
            <div class="hero-meta">
                <?php if (is_singular('post')) : ?>
                    <span class="posted-on">
                        <?php echo get_the_date(); ?>
                    </span>
                    <span class="posted-by">
                        <?php echo get_the_author(); ?>
                    </span>
                    <?php
                    $categories_list = get_the_category_list(', ');
                    if ($categories_list) :
                    ?>
                        <span class="cat-links">
                            <?php echo $categories_list; ?>
                        </span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <h1 class="hero-title">
                <?php
                if (is_archive()) {
                    the_archive_title();
                } elseif (is_search()) {
                    printf(esc_html__('Поиск: %s', 'wp-start-theme'), '<span>' . get_search_query() . '</span>');
                } else {
                    the_title();
                }
                ?>
            </h1>
            <?php if (is_archive()) : ?>
                <div class="hero-meta">
                    <?php the_archive_description(); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section> 