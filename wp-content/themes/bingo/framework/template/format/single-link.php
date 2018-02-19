<article <?php post_class('blog-post blog-post-single'); ?> id="post-<?php the_ID(); ?>">
  <div class="post-meta">
    <ul>
      <li><i class="fa fa-calendar"></i> <?php the_time(get_option('date_format')); ?></li>
      <li><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></li>
      <li><i class="fa fa-folder-open-o"></i> <?php the_category(' ,&nbsp; '); ?></li>

      <?php if (comments_open() && !post_password_required()) { ?>
      <li><i class="fa fa-comments-o"></i> <a href="#"><?php comments_popup_link('0 Comments', '1 Comment', '% Comments', ''); ?></a></li>
      <?php } ?>

      <?php if (current_user_can('edit_post', $post->ID)) { ?>
      <li><i class="fa fa-pencil"></i> <?php edit_post_link(__('Edit', 'bingo'), '', ''); ?></li>
      <?php } ?>
    </ul>
  </div>

  <div class="link">
    <i class="fa fa-link"></i>
    <?php echo do_shortcode(get_the_content()); ?>
  </div>

  <?php get_template_part( 'framework/template/sharer', '' ); ?>

  <div class="post-author">
    <?php
      $user_ID = get_the_author_meta('ID');
      $user_mail = get_the_author_meta('user_email');
    ?>
    <img src="<?php echo uou_get_avatar_url(get_the_author_meta( 'ID' ), 60); ?>" alt="" class="thumb">
    <h6><?php _e('About the Author', 'bingo'); ?></h6>
    <p><?php the_author_posts_link(); ?>, <?php printf( __( '%d posts created', 'bingo' ), count_user_posts( $user_ID ) ) ?>. <br> <a href="mailto:<?php echo $user_mail; ?>"><?php _e('Contact Author', 'bingo'); ?></a></p>
  </div>

  <?php get_template_part( 'framework/template/format/pages-pagination', '' ); ?>

  <div class="post-comments">
    <?php wp_reset_query(); comments_template('', true ); ?>
  </div>
</article>