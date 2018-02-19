<article <?php post_class('blog-post'); ?> id="post-<?php the_ID(); ?>">


	<h1 class="h4"><?php the_title(); ?></h1>

	<div class="post-meta">
		<ul>
			<li><i class="fa fa-calendar"></i> <?php the_time(get_option('date_format')); ?></li>
			<li><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></li>
			<li><i class="fa fa-folder-open-o"></i> <?php the_category('&nbsp;/&nbsp; '); ?></li>

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

			<?php $temp_id = get_the_ID(); ?>

			<figure class="article-preview-image">
				<?php echo_first_image( $temp_id ); ?>
			</figure>


			<?php

			the_excerpt();

	?>



	<a href="<?php the_permalink(); ?>" class="btn btn-default"><?php _e('Read More', 'bingo'); ?></a>
</article>





