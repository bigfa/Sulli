<?php

/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bigfa
 * @subpackage Sulli
 * @since 1.0.0
 */

?>
<footer id="site-footer" role="contentinfo" class="site--footer">
	<div class="container sulli u-flex">
		<div class="text">Just a <a href="https://fatesinger.com" target="_blank">bigfa</a> theme.</div>
		<?php if (UPYUN_LOGO) : ?><a href="https://www.upyun.com/" target=" _blank" class="upyun--link"><img src="<?php echo get_template_directory_uri() ?>/build/img/upyun.png" width=80></a><?php endif; ?>
	</div>
</footer>
</div>
</div>
<?php wp_footer(); ?>

</body>

</html>