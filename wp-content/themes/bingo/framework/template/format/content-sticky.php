<article <?php post_class('blog-post'); ?> id="post-<?php the_ID(); ?>">

    <div class="marker-ribbon">
        <div class="ribbon-banner">
            <div class="ribbon-text"><?php _e('Sticky', 'bingo'); ?></div>
        </div>
    </div>

  <?php if (has_post_thumbnail()) : ?>
		<?php
			$thumb_id = get_post_thumbnail_id();
			$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'blog-thumb', true);
			$thumb_url = $thumb_url_array[0];
		?>

		<a href="<?php the_permalink(); ?>"><img class="post-image" src="<?php echo $thumb_url; ?>"></a>
  <?php endif; ?>

  <h1 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

  <div class="post-meta">
    <ul>
      <li><i class="fa fa-calendar"></i> <?php the_time(get_option('date_format')); ?></li>
      <li><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></li>
      <li><i class="fa fa-folder-open-o"></i> <?php the_category(',&nbsp; '); ?></li>
      <?php if (comments_open() && !post_password_required()) { ?>
      <li><i class="fa fa-comments-o"></i> <a href="#"><?php comments_popup_link('0 Comments', '1 Comment', '% Comments', ''); ?></a></li>
      <?php } ?>
    </ul>
  </div>

  <p><?php the_excerpt(); ?></p>

  <a href="<?php the_permalink(); ?>" class="btn btn-default read-more"><?php _e('Read More', 'bingo'); ?></a>
</article>