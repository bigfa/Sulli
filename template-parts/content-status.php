<?php

/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bigfa
 * @subpackage Sulli
 * @since 1.0.0
 */

?>

<div class="inner--content post--area__status">
    <article class="card--status">
        <header class="card--status__header">
            <?php echo get_avatar(get_the_author_meta('ID'), 64); ?><div class="meta sulli"><?php echo get_the_date('Y-m-d'); ?></div>
        </header>
        <div class="card--status__content">
            <?php
            $content = get_post_field('post_content', get_the_ID());
            $content = preg_replace('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', '', $content);
            echo apply_filters('the_content', $content);
            //the_content(); 
            ?>
        </div>
        <?php echo get_post_images(get_the_ID()); ?>
    </article>
</div>
<?php
/**
 *  Output comments wrapper if it's a post, or if comments are open,
 * or if there's a comment number – and check for password.
 * */
if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required()) {
?>

    <div class="comments-wrapper section-inner container">

        <?php comments_template(); ?>

    </div><!-- .comments-wrapper -->

<?php
}
?>