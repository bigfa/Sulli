<?php

/**
 * The search template file
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

<main id="site-content" role="main">
    <section class="container post--list">
        <?php while (have_posts()) {

            the_post(); ?>
            <article class="post">
                <a href="<?php the_permalink(); ?>" class="image--link"><img src="<?php echo aladdin_get_background_image(get_the_ID(), 625, 400); ?>"></a>

                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="meta sulli"><?php echo get_the_date('Y-m-d'); ?></div>
            </article>


        <?php     } ?>
    </section>
    <div class="posts-nav container sulli">
        <?php echo paginate_links(array(
            'prev_next'          => 0,
            'before_page_number' => '',
            'mid_size' => 2
        )); ?>
    </div>
</main>
<?php
get_footer();
