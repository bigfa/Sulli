<section class="container post--list post--list__card">
    <?php while (have_posts()) {
        the_post(); ?>
        <article class="post">
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="meta sulli"><?php echo get_the_date('Y-m-d'); ?></div>
            <div class="snipper"><?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 220, "..."); ?></div>
            <div class="more"><a class="cute sulli" href="<?php the_permalink(); ?>">Readmore...</a></div>
        </article>
    <?php  } ?>
</section>