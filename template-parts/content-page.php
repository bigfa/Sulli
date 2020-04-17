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

<article id="post-<?php the_ID(); ?>">
    <header class="sulliArticle--header">
        <div class="sulliContainer">
            <h2 class="sulliArticle--title"><?php the_title(); ?></h2>
            <div class="sulliArticle--subTitle"><?php echo get_post_meta(get_the_ID(), '_subtitle', true); ?></div>
            <div class="sulliArticle--meta sulli "><?php echo get_the_date('Y-m-d'); ?></div>
        </div>
    </header>
    <div class="container">
        <div class="post--area sulliGrap">
            <?php the_content(); ?>
        </div>
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

</article><!-- .post -->