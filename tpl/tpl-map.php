<?php
/*
Template Name: Map
*/
get_header();

//wp_enqueue_script('map');
//wp_enqueue_script('map-lu');

?>
<div class="u-backgroundGrayLightest">
    <div class="container">
        <header class="mapHeader">
            <h2 class="mapHeader--title JiEun" itemprop="headline">Travel FootPrint</h2>
        </header>
    </div>
</div>
<div class="container">
    <?php marker_pro_init(); ?>
</div>
<?php get_footer(); ?>