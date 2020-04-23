<?php

/**
 * The template for displaying single posts and pages.
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

    <?php

    if (have_posts()) {

        while (have_posts()) {
            the_post();

            get_template_part('template-parts/content', 'status');
        }
    }

    ?>

</main>

<?php get_footer(); ?>