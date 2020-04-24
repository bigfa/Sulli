<?php

/**
 * The template file for displaying the comments and comment form for the
 * Twenty Twenty theme.
 *
 * @package Bigfa
 * @subpackage Sulli
 * @since 1.0.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if (post_password_required()) {
	return;
}

if ($comments) {
?>

	<div class="comments inner--content" id="comments">

		<?php
		$comments_number = absint(get_comments_number());
		?>

		<div class="comments-header section-inner small max-percentage">

			<h2 class="comment-reply-title">
				Comments
			</h2><!-- .comments-title -->

		</div><!-- .comments-header -->

		<div class="comments-inner section-inner thin max-percentage">
			<ul class="comment--list sulliComment--list">
				<?php
				wp_list_comments(
					array(
						//'walker'      => new TwentyTwenty_Walker_Comment(),
						'avatar_size' => 48,
						'style'       => 'ul',
						'callback' => 'sulli_comment'
					)
				);
				?>
			</ul>
		</div><!-- .comments-inner -->
	</div><!-- comments -->

	<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? 
	?>
		<nav id="comment-nav-below" class="comment--navigation sulli inner--content" role="navigation">
			<?php previous_comments_link('Older Comments'); ?>
			<?php next_comments_link('Newer Comments'); ?>
		</nav>
	<?php endif; // Check for comment navigation. 
	?>

<?php
}

if (comments_open() || pings_open()) {
	comment_form(
		array(
			'class_form'         => 'section-inner',
			'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h3>',
		)
	);
} elseif (is_single()) {

?>

	<div class="comment-respond" id="respond">

		<p class="comments-closed">评论已关闭</p>

	</div><!-- #respond -->

<?php
}
