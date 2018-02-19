<?php

/***********************************************************************************************/
/* Prevent the direct loading of comments.php */
/***********************************************************************************************/
if (!empty($_SERVER['SCRIPT-FILENAME']) && basename($_SERVER['SCRIPT-FILENAME']) == 'comments.php') {
	die(__('You cannot access this page directly.', 'bingo'));
}

/***********************************************************************************************/
/* If the post is password protected then display text and return */
/***********************************************************************************************/
if (post_password_required()) : ?>
	<p>
		<?php
			_e( 'This post is password protected. Enter the password to view the comments.', 'bingo');
			return;
		?>
	</p>

<?php endif;

/***********************************************************************************************/
/* If we have comments to display, we display them */
/***********************************************************************************************/
if (have_comments()) : ?>

		<div class="title-lines-left">
		<h4><?php comments_number(__('Comments (0)', 'bingo'), __('Comments (1)', 'bingo'), __('Comments (%)', 'bingo')); ?></h4>
		</div>

		<ul class="comments">
			<?php wp_list_comments('callback=bingo_comments'); ?>
		</ul>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>

			<div class="comment-nav-section clearfix">

				<p class="fl"><?php previous_comments_link(__( '&larr; Older Comments', 'bingo')); ?></p>
				<p class="fr"><?php next_comments_link(__( 'Newer Comments &rarr;', 'bingo')); ?></p>

			</div> <!-- end comment-nav-section -->

		<?php endif; ?>

<?php
/***********************************************************************************************/
/* If we don't have comments and the comments are closed, display a text */
/***********************************************************************************************/

	elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
		<p><?php _e( 'Comments are colsed', 'bingo' ); ?></p>

<?php endif;

/***********************************************************************************************/
/* Display the comment form */
/***********************************************************************************************/
comment_form();

?>