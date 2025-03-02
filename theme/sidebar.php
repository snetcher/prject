<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage WP_Start_Theme
 * @since 0.1.0
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area">
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside> 