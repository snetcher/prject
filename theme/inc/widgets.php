<?php
/**
 * Custom widgets for the theme
 *
 * @package WordPress
 * @subpackage WP_Start_Theme
 * @since 0.1.0
 */

class WP_Start_Theme_Recent_Comments_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'wp_start_theme_recent_comments',
            __('Recent Comments (Theme)', 'wp-start-theme'),
            array('description' => __('Your site\'s most recent comments with cyberpunk style.', 'wp-start-theme'))
        );
    }

    public function widget($args, $instance) {
        // Check if comments are globally enabled
        if (!get_option('default_comment_status')) {
            return;
        }

        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Comments', 'wp-start-theme');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;

        $comments = get_comments(array(
            'number'      => $number,
            'status'      => 'approve',
            'post_status' => 'publish'
        ));

        if ($comments) {
            echo $args['before_widget'];
            
            if ($title) {
                echo $args['before_title'] . esc_html($title) . $args['after_title'];
            }
            ?>
            <ul>
                <?php
                foreach ($comments as $comment) {
                    $post_title = get_the_title($comment->comment_post_ID);
                    ?>
                    <li class="recentcomments">
                        <div class="comment-author">
                            <?php echo get_avatar($comment, 40); ?>
                            <span class="comment-author-name"><?php echo esc_html($comment->comment_author); ?></span>
                        </div>
                        <div class="comment-content">
                            <a href="<?php echo esc_url(get_comment_link($comment)); ?>">
                                <?php echo wp_trim_words($comment->comment_content, 10); ?>
                            </a>
                        </div>
                        <div class="comment-post">
                            <?php _e('on', 'wp-start-theme'); ?> 
                            <a href="<?php echo esc_url(get_permalink($comment->comment_post_ID)); ?>">
                                <?php echo esc_html($post_title); ?>
                            </a>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
            echo $args['after_widget'];
        }
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Comments', 'wp-start-theme');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp-start-theme'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of comments to show:', 'wp-start-theme'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;
        return $instance;
    }
}

// Register widget
function wp_start_theme_register_widgets() {
    register_widget('WP_Start_Theme_Recent_Comments_Widget');
}
add_action('widgets_init', 'wp_start_theme_register_widgets'); 