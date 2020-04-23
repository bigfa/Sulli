<?php
/*
Template Name: Archive
*/
get_header();

?>
<div class="container inner--content">
    <?php
    $args = array(
        'posts_per_page' => -1,
        'post_type' => array('post'),
        'ignore_sticky_posts' => 1,
    );
    $the_query = new WP_Query($args);
    $year = 0;
    $mon = 0;
    $all = array();
    $output = '';
    $i = 0;
    while ($the_query->have_posts()) : $the_query->the_post();
        $i++;
        $year_tmp = get_the_time('Y');
        $mon_tmp = get_the_time('n');
        $y = $year;
        $m = $mon;
        // if ($year != $year_tmp && $year > 0) $output .= '</div>';
        if ($mon != $mon_tmp && $mon > 0) $output .= '</ul>';
        if ($year != $year_tmp) { // 输出年份      
            $year = $year_tmp;
            $all[$year] = array();
            $output .= '<h2 class="archive--title__year sulli">' . $year . '</h2>';
        }
        if ($mon != $mon_tmp) { // 输出月份 
            $i = 0;
            $commentnum = 0;
            $mon = $mon_tmp;
            $output .= '<h3 class="archive--title__month sulli">' . $year . ' - ' . $mon . '</h3>' . '<ul class="archive--list">';
        }
        //if($i < 6) :
        $output .= '<li class="archive--item"><a class="archive--itemTitle" href="' . get_permalink() . '">' . get_the_title() . '</a><div class="archive--itemMeta sulli">'  . get_the_date('Y-m-d');
        if (get_comments_number()) $output .= ' / ' . get_comments_number() . ' responses';
        $output .= '</div></li>';
        // endif;
        $commentnum = $commentnum + get_comments_number();
    endwhile;
    wp_reset_postdata();
    $output .= '</ul>';
    echo $output;      ?>
</div>
<?php get_footer(); ?>