<article <?php post_class('blog-post'); ?> id="post-<?php the_ID(); ?>">
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

  <div class="link">
    <i class="fa fa-link"></i>
    <?php echo do_shortcode(get_the_content()); ?>
  </div>
</article>