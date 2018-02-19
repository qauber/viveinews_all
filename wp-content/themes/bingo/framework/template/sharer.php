<div class="post-share">
  <h6><?php _e('Share This Story', 'bingo'); ?></h6>

	<ul>
		<li><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>"><i class="fa fa-facebook-square"></i></a></li>
		<li><a href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>"><i class="fa fa-twitter-square"></i></a></li>
		<li><a href="https://plus.google.com/share?url=<?php the_permalink();?>"><i class="fa fa-google-plus-square"></i></a></li>
		<li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>"><i class="fa fa-linkedin-square"></i></a></li>
		<li><a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink();?>&media=<?php echo urlencode(get_the_title()); ?>"><i class="fa fa-pinterest-square"></i></a></li>
	</ul>
</div>