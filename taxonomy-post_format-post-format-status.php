<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bigfa
 * @subpackage Sulli
 * @since 1.0.0
 */

get_header();
?>

<main id="site-content" role="main" class="container ">
    <section class="card--list">
        <?php while (have_posts()) {

            the_post(); ?>
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
                <footer class="card--status__footer sulli"><a href="<?php the_permalink(); ?>">Replies <?php echo get_comments_number(); ?></a></footer>
            </article>
        <?php     } ?>
    </section>
    <div class="posts-nav container JiEun">
        <?php echo paginate_links(array(
            'prev_next'          => 0,
            'before_page_number' => '',
            'mid_size' => 2
        )); ?>
    </div>
</main>
<?php
get_footer();
