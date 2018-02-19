<article <?php post_class('blog-post'); ?> id="post-<?php the_ID(); ?>">


	<h1 class="h4"><?php the_title(); ?></h1>

	<div class="post-meta">
		<ul>
			<li><i class="fa fa-calendar"></i> <?php the_time(get_option('date_format')); ?></li>
			<li><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></li>
			<li><i class="fa fa-folder-open-o"></i> <?php the_category(' &nbsp;/&nbsp; '); ?></li>

			<?php if (has_tag()) : ?>

				<li><i class="fa fa-tag"></i> <?php the_tags('', ',', ''); ?></li>

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


		<?php

			$gallery_atts = array(
				'post_parent' => $post->ID,
				'post_mime_type' => 'image'
			);
			$gallery_images = get_children($gallery_atts);

			if (!empty($gallery_images)) {
				$gallery_count = count($gallery_images);
				$first_image = array_shift($gallery_images);
				$display_first_image = wp_get_attachment_image($first_image->ID);

				?>

			<figure class="article-preview-image">
				<a href="<?php the_permalink(); ?>"><?php echo $display_first_image; ?></a>
			</figure>

			<p><strong><?php printf( _n('This gallery contains %s photo.', 'This gallery contains %s photos.', $gallery_count, 'bingo'), $gallery_count); ?></strong></p>

			<?php }

			the_excerpt();

	?>



	<a href="<?php the_permalink(); ?>" class="btn btn-default"><?php _e('Read More', 'bingo'); ?></a>
</article>





