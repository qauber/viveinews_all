<!-- footer -->
	<div class="footer animated wow bounceInDown" data-wow-delay="600ms">
		<div class="container">
			<div class="footer-grids">
                            <?php
                                $count_products = wp_count_posts('product');
                                $register_users = count_users();
                            ?> 
                            
                            
                            
                            <?php
                                global $bingo_option_data;
                                ?>

                                        <?php get_sidebar('footer1'); ?>

                                        <?php get_sidebar('footer2'); ?>

                                        <?php get_sidebar('footer3'); ?>

                                        <?php get_sidebar('footer4'); ?>
                            <div class="col-md-3 footer-grid footer-grid1 footer-counters">
                                
                                <div class="col-md-6 text-center">
                                    <h2><?php echo $count_products->publish; ?> <br>video</h2>
                                </div>
                                
                                <div class="col-md-6 text-center">
                                    <h2><?php echo($register_users['total_users']); ?> <br> users</h2>
                                </div>
                                
                            </div>
                            
				<div class="clearfix"> </div>
				<div class="footer-grid2-pos animated wow bounceIn" data-wow-delay="800ms">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/footer-photo.png" alt=" " class="img-responsive" />
				</div>
			</div>
		</div>
	</div>
	<div class="footer-copy animated wow bounceInUp" data-wow-delay="600ms">
		<div class="container">
			<p><?php echo $bingo_option_data['footer-editor-text']; ?></p>
		</div>
	</div>
<!-- //footer -->			

<?php wp_footer(); ?>
					
	</body>
</html>