<?php
/**
 * The template for displaying comments
 *
 * @package WordPress
 * @subpackage WP_Start_Theme
 * @since 0.1.0
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ( '1' === $comments_number ) {
                printf(
                    /* translators: %s: Post title. */
                    esc_html__( 'One thought on &ldquo;%s&rdquo;', 'wp-start-theme' ),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: Number of comments, 2: Post title. */
                    esc_html( _n(
                        '%1$s thought on &ldquo;%2$s&rdquo;',
                        '%1$s thoughts on &ldquo;%2$s&rdquo;',
                        $comments_number,
                        'wp-start-theme'
                    ) ),
                    number_format_i18n( $comments_number ),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2>

        <ol class="commentlist">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 60,
                'callback'    => function($comment, $args, $depth) {
                    $GLOBALS['comment'] = $comment;
                    ?>
                    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                        <article class="comment-body">
                            <header class="comment-author">
                                <?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
                                <?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>
                            </header>

                            <div class="comment-meta">
                                <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                                    <?php
                                    printf( 
                                        '<time datetime="%1$s">%2$s</time>',
                                        get_comment_time( 'c' ),
                                        sprintf( 
                                            esc_html__( '%1$s at %2$s', 'wp-start-theme' ),
                                            get_comment_date(),
                                            get_comment_time()
                                        )
                                    );
                                    ?>
                                </a>
                            </div>

                            <div class="comment-content">
                                <?php comment_text(); ?>
                            </div>

                            <div class="reply">
                                <?php
                                comment_reply_link( array_merge( $args, array(
                                    'depth'     => $depth,
                                    'max_depth' => $args['max_depth'],
                                ) ) );

                                if ( get_edit_comment_link() ) {
                                    echo '<a class="comment-edit-link" href="' . get_edit_comment_link() . '">' . __('Edit', 'wp-start-theme') . '</a>';
                                }
                                ?>
                            </div>
                        </article>
                    </li>
                    <?php
                }
            ) );
            ?>
        </ol>

        <?php
        the_comments_navigation( array(
            'prev_text' => __( '← Older Comments', 'wp-start-theme' ),
            'next_text' => __( 'Newer Comments →', 'wp-start-theme' ),
        ) );
    endif;

    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'wp-start-theme' ); ?></p>
        <?php
    endif;

    comment_form( array(
        'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
        'title_reply_after'  => '</h2>',
    ) );
    ?>
</div> 