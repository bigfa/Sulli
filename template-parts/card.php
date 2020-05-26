<section class="container post--list">
    <?php while (have_posts()) {
        the_post(); ?>
        <article class="post">
            <a href="<?php the_permalink(); ?>" class="image--link"><img src="<?php echo aladdin_get_background_image(get_the_ID(), 625, 400); ?>"></a>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="meta sulli"><?php echo get_the_date('Y-m-d'); ?></div>
        </article>
    <?php  } ?>
</section>