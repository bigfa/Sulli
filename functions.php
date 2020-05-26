<?php
define('SULLI_VERSION', '1.0.0');


include 'modules/config.php';
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function sulli_theme_support()
{

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    // Set post thumbnail size.
    set_post_thumbnail_size(625, 400);

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');


    add_theme_support('post-formats', array('status'));




    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'script',
            'style',
        )
    );

    /*
     * Adds `async` and `defer` support for scripts registered or enqueued
     * by the theme.
     */
    //$loader = new TwentyTwenty_Script_Loader();
    //add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );

    add_filter('wp_calculate_image_srcset', '__return_false');
}

add_action('after_setup_theme', 'sulli_theme_support');

/**
 * Register and Enqueue Styles.
 */
function sulli_register_styles()
{

    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style('sulli-style', get_template_directory_uri() . '/build/css/app.css', array(), $theme_version);
}

add_action('wp_enqueue_scripts', 'sulli_register_styles');

/**
 * Register and Enqueue Scripts.
 */
function sulli_register_scripts()
{

    $theme_version = wp_get_theme()->get('Version');

    if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_script('sulli-js', get_template_directory_uri() . '/build/js/app.js', array('jquery'), $theme_version, true);
    wp_script_add_data('sulli-js', 'async', true);
    wp_localize_script('sulli-js', 'SULLI', array(
        'ajax_url'   => admin_url('admin-ajax.php'),
        'order' => get_option('comment_order'),
        'formpostion' => 'bottom', //默认为bottom，如果你的表单在顶部则设置为top。
    ));
}

add_action('wp_enqueue_scripts', 'sulli_register_scripts');

/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function sulli_menus()
{

    $locations = array(
        'primary' => '主题菜单',
    );

    register_nav_menus($locations);
}

add_action('init', 'sulli_menus');

/**
 * Comments
 */
/**
 * Check if the specified comment is written by the author of the post commented on.
 *
 * @param object $comment Comment data.
 *
 * @return bool
 */
function sulli_is_comment_by_post_author($comment = null)
{

    if (is_object($comment) && $comment->user_id > 0) {

        $user = get_userdata($comment->user_id);
        $post = get_post($comment->comment_post_ID);

        if (!empty($user) && !empty($post)) {

            return $comment->user_id === $post->post_author;
        }
    }
    return false;
}

/**
 * Filter comment reply link to not JS scroll.
 * Filter the comment reply link to add a class indicating it should not use JS slow-scroll, as it
 * makes it scroll to the wrong position on the page.
 *
 * @param string $link Link to the top of the page.
 *
 * @return string $link Link to the top of the page.
 */
function sulli_filter_comment_reply_link($link)
{

    $link = str_replace('class=\'', 'class=\'do-not-scroll ', $link);
    return $link;
}

//add_filter( 'comment_reply_link', 'twentytwenty_filter_comment_reply_link' );

/**
 * Classes
 */
/**
 * Add No-JS Class.
 * If we're missing JavaScript support, the HTML element will have a no-js class.
 */
function sulli_no_js_class()
{

?>
    <script>
        document.documentElement.className = document.documentElement.className.replace('no-js', 'js');
    </script>
    <?php

}

add_action('wp_head', 'sulli_no_js_class');

function aladdin_get_background_image($post_id, $width = null, $height = null)
{
    if (has_post_thumbnail($post_id)) {
        $timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
        $output       = $timthumb_src[0];
    } elseif (get_post_meta($post_id, '_banner', true)) {
        $output = get_post_meta($post_id, '_banner', true);
    } else {
        $content         = get_post_field('post_content', $post_id);
        $defaltthubmnail = DEFAULT_THUMBNAIL;
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if ($n > 0) {
            $output = $strResult[1][0];
        } else {
            $output = $defaltthubmnail;
        }
    }
    if (UPYUN && $width && $height) {
        $output = $output . '!/both/' . $width . 'x' . $height;
    } elseif (QINIU && $width && $height) {
        $output = $output . '?imageView2/1/w/' . $width . '/h/' . $height;
    }

    $result = $output;

    return $result;
}


function sulli_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    switch ($comment->comment_type):
        case 'pingback':
        case 'trackback':
    ?>
            <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <div class="pingback-content"><?php comment_author_link(); ?></div>
            <?php
            break;
        default:
            global $post;
            ?>
            <li class="comment sulliComment" itemtype="http://schema.org/Comment" data-id="<?php comment_ID() ?>" itemscope="" itemprop="comment">
                <div id="comment-<?php comment_ID() ?>" class="sulliComment--block">
                    <div class="sulliComment--info">
                        <img height=48 width=48 alt="<?php echo $comment->comment_author; ?>的头像" aria-label="<?php echo $comment->comment_author; ?>的头像" src="<?php echo get_avatar_url($comment, array('size' => 48)); ?>" class="avatar" />
                        <span class="sulliComment--author" itemprop="author"><?php echo get_comment_author_link(); ?></span>
                    </div>
                    <div class="sulliComment--content" itemprop="description">
                        <?php comment_text(); ?>
                    </div>
                    <div class="sulliComment--footer">
                        <?php echo '<span class="comment-reply-link u-cursorPointer" onclick="return addComment.moveForm(\'comment-' . $comment->comment_ID . '\', \'' . $comment->comment_ID . '\', \'respond\', \'' . $post->ID . '\')">reply</span>'; ?> · <span class="comment--time sulli comment-time" itemprop="datePublished" datetime="<?php echo get_comment_date('c'); ?>"><?php echo get_comment_date('M d,Y'); ?></span>
                    </div>
                </div>
            <?php
            break;
    endswitch;
}


if (!function_exists('fa_ajax_comment_err')) :

    function fa_ajax_comment_err($a)
    {
        header('HTTP/1.0 500 Internal Server Error');
        header('Content-Type: text/plain;charset=UTF-8');
        echo $a;
        exit;
    }

endif;

if (!function_exists('fa_ajax_comment_callback')) :

    function fa_ajax_comment_callback()
    {
        $comment = wp_handle_comment_submission(wp_unslash($_POST));
        if (is_wp_error($comment)) {
            $data = $comment->get_error_data();
            if (!empty($data)) {
                fa_ajax_comment_err($comment->get_error_message());
            } else {
                exit;
            }
        }
        $user = wp_get_current_user();
        do_action('set_comment_cookies', $comment, $user);
        $GLOBALS['comment'] = $comment; //根据你的评论结构自行修改，如使用默认主题则无需修改
            ?>
            <li class="comment sulliComment">
                <article class="sulliComment--block">
                    <div class="sulliComment--info">
                        <?php echo get_avatar($comment, $size = '48') ?>

                        <span class="sulliComment--author">
                            <?php echo get_comment_author_link(); ?>
                        </span>
                    </div>
                    <div class="sulliComment--content">
                        <?php comment_text(); ?>
                    </div>
                    <div class="sulliComment--footer">
                        <span class="comment--time sulli comment-time"><?php echo get_comment_date(); ?></span>
                    </div>
                </article>
            </li>
    <?php die();
    }

endif;

add_action('wp_ajax_nopriv_ajax_comment', 'fa_ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'fa_ajax_comment_callback');


function sulli_hide_status($query)
{
    if ($query->is_home() && $query->is_main_query()) {
        $tax_query = [
            [
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => array('post-format-status'),
                'operator' => 'NOT IN',
            ]
        ];
        $query->set('tax_query', $tax_query);
    }
    return $query;
}
add_action('pre_get_posts', 'sulli_hide_status');

function get_post_images($post_id = null)
{
    if (!UPYUN) return;
    global  $post;
    $content         = get_post_field('post_content', $post_id);
    $output = '<div class="card--statusImage--list">';
    preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
    $n = count($strResult[1]);
    if ($n > 0) {
        foreach ($strResult[1] as $key => $value) {
            $output .= '<img src="' . $value . '!/both/150x150" data-original="' . $value . '" class="card--statusImage--thumb"  data-action="zoom" >';
        }
    }
    $output .= '</div>';

    return $output;
}

function sulli_body_class($classes, $class)
{
    if (TEXT_MODE) $classes[] = 'is-textMode';

    return $classes;
}

add_filter('body_class', 'sulli_body_class', 10, 2);
