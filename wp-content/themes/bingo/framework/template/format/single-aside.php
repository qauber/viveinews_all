<article <?php post_class('blog-post'); ?> id="post-<?php the_ID(); ?>">

	<?php if (has_post_thumbnail()) : ?>

		<?php
			$thumb_id = get_post_thumbnail_id();
			$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
			$thumb_url = $thumb_url_array[0];
		?>

		<a href="<?php the_permalink(); ?>"><img class="image" src="<?php echo $thumb_url; ?>"></a>


	<?php endif; ?>

	<h1 class="h4"><?php the_title(); ?></h1>

	<div class="post-meta">
		<ul>
			<li><i class="fa fa-calendar"></i> <?php the_time(get_option('date_format')); ?></li>
			<li><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></li>
			<li><i class="fa fa-folder-open-o"></i> <?php the_category(' &nbsp;/&nbsp; '); ?></li>

			<?php if (has_tag()) : ?>

				<li><i class="fa fa-tag"></i> <?php the_tags('', ',' ,''); ?></li>

			<?php endif; ?>
			<li><i class="fa fa-comment-o"></i>
			<?php
					// Only show the comments link if comments are allowed and it's not password protected
					if (comments_open() && !post_password_required()) {
						comments_popup_link('0 Comments', '1 Comment', '% Comments', '');
					}
			?>

			</li>
		</ul>
	</div>

	<div class="content">
		<?php echo do_shortcode(get_the_content()); ?>
	</div>

	<!-- for social sharer -->
	<?php get_template_part( 'framework/template/sharer', '' ); ?>

	<?php

		$user_ID = get_the_author_meta('ID');
		$user_mail = get_the_author_meta('user_email');
		// $count = custom_get_user_posts_count($user_ID, array('post_type' =>'post','post_status'=> 'publish'));

	?>

	<div class="about-author">
		<img src="<?php echo uou_get_avatar_url(get_the_author_meta( 'ID' ), 60); ?>" alt="" class="thumb">
		<h6><?php _e('About the Author', 'bingo'); ?></h6>
		<p><?php the_author_posts_link(); ?>, <?php printf( __( '%d posts created', 'bingo' ), count_user_posts( $user_ID ) ) ?></p>
		<p><a href="mailto:<?php echo $user_mail; ?>"><?php _e('Contact Author', 'bingo'); ?></a></p>
	</div>

	<?php get_template_part( 'framework/template/format/pages-pagination', '' ); ?>

	<div class="comments-section">

		<?php wp_reset_query(); comments_template('', true ); ?>

	</div>
</article>




