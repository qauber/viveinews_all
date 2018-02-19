				<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

                      <?php get_template_part( 'framework/template/format/single', get_post_format()); ?>

                <?php endwhile; else : ?>
                    <article>
                      <h1 class="h4"><?php _e( 'No Posts were Found!', 'bingo' ); ?></h1>
                    </article>
                <?php endif; ?>