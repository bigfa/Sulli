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
        <header class="archive-header archive-header__author">
            <?php
            the_post();
            echo get_avatar(get_the_author_meta('ID'), 72);
            the_author();
            ?>
        </header>
        <?php
        /*
				 * Since we called the_post() above, we need
				 * to rewind the loop back to the beginning.
				 * That way we can run the loop properly, in full.
				 */
        rewind_posts();
        ?>
        <?php while (have_posts()) {
            the_post(); ?>
            <article class="card--item">
                <div class="card--content">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="meta sulli"><?php echo get_the_date('Y-m-d'); ?></div>
                </div>
                <a href="<?php the_permalink(); ?>" class="card--image"><img src="<?php echo aladdin_get_background_image(get_the_ID(), 300, 200); ?>"></a>
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
