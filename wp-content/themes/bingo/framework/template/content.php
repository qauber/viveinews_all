		<? $i = 1; ?>
        <?php if(have_posts()) : while(have_posts()) : the_post(); ?>

            <?php 

            	if( is_sticky() ){

            		get_template_part( 'framework/template/format/content', 'sticky' ); 

            	}else{

            		get_template_part('framework/template/format/content', get_post_format()); 

            	}

            ?>
            <?
			//echo ('x');
			if(($i%3) == 0){
				echo "<div class='clear'></div>";
			}
			$i++;
			?>

            <?php endwhile; else : ?>

            <article class="blog-post">

                <h2><?php _e( 'No Posts were Found!', 'bingo' ); ?></h2>

            </article>
        <?php endif; ?>

			<?php
				if ($wp_query->max_num_pages > 1) :
					wpc_pagination();
				endif;
			?>