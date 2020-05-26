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

<main id="site-content" role="main">
	<?php if (TEXT_MODE) {
		get_template_part('template-parts/text');
	} else {
		get_template_part('template-parts/card');
	} ?>
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
