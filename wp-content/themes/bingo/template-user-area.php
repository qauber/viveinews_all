<?php

/*
Template Name: User area
*/


        
get_header('userarea');

global $woocommerce, $product, $post;

$user_id = get_current_user_id();
if ($user_id) {
    $default_view_ser = get_user_meta($user_id, 'view_settings', true);
}else{
    $default_view_ser = get_option('view_settings_other_users');
}
parse_str($default_view_ser, $default_view_settings);



?>

<div id="page">

	<div id="headline" class="container">
        <?php include(locate_template('framework/template/userarea_templates/userarea-headline.php')); ?>

	</div>

	<div id="intr" class="container">
		<div class="row-fluid">
            <?php include(locate_template('framework/template/userarea_templates/userarea-scroller.php')); ?>
		
		<div class="search span3"><div class="offset1">
                <?php echo do_shortcode( '[yith_woocommerce_ajax_search]'); ?>
		</div></div>
		</div>
	</div>

	<div id="content" class="container">

		<div id="main" class="row-fluid">
			<div id="main-left" class="span8">
				<div id="slider" class="clearfix">
					<div id="slide-left" class="flexslider span8">
						<?php include(locate_template('framework/template/userarea_templates/userarea-main_area.php')); ?>
					</div>

					<div id="slide-right" class="span4">
                        <?php include(locate_template('framework/template/userarea_templates/userarea-right_slider.php')); ?>


					</div>
				</div>
				
				<div id="home-top">
<!--                    --><?php //get_template_part('framework/template/userarea_templates/userarea-top_side', '') ?>
                    <?php include(locate_template('framework/template/userarea_templates/userarea-top_side.php')); ?>
				</div>
				
				<div id="home-middle" class="clearfix">
                    <?php include(locate_template('framework/template/userarea_templates/userarea-left_side.php')); ?>
                    <?php include(locate_template('framework/template/userarea_templates/userarea-right_side.php')); ?>
				</div>

				<div id="home-bottom" class="clearfix">
                    <?php include(locate_template('framework/template/userarea_templates/userarea-bottom_side.php')); ?>
				</div>

			</div><!-- #main-left -->

		<div id="sidebar" class="span4">

			<div id="tabwidget" class="widget tab-container"> 
				<ul id="tabnav" class="clearfix"> 
                    <?php
                        $tab2 = $default_view_settings['sub_category_tab2'] ? $default_view_settings['sub_category_tab2'] : $default_view_settings['category_tab2'];
                        $tab3 = $default_view_settings['sub_category_tab3'] ? $default_view_settings['sub_category_tab3'] : $default_view_settings['category_tab3'];
                    ?>
					<li><h3><a href="#tab1" class="selected"><img src="<?php echo get_template_directory_uri() ?>/img/userarea/view-white-bg.png" alt="Popular">Popular</a></h3></li>
					<li><h3><a href="#tab2"><img src="<?php echo get_template_directory_uri() ?>/img/userarea/time-white.png" alt="Recent"><?php echo get_product_cat_name($tab2); ?></a></h3></li>
				    <li><h3><a href="#tab3"><img src="<?php echo get_template_directory_uri() ?>/img/userarea/time-white.png" alt="Comments"><?php echo get_product_cat_name($tab3); ?></a></h3></li>
				</ul>

			<div id="tab-content">
			
                <div id="tab1" style="display: block; ">

                    <?php include(locate_template('framework/template/userarea_templates/userarea-top-rated.php')); ?>
                    <div class="holder clearfix"></div>
                    <div class="clear"></div>

                <!-- End most viewed post -->
                </div><!-- /#tab1 -->

                <div id="tab2" style="display: none;">

                    <?php include(locate_template('framework/template/userarea_templates/userarea-tab2.php')); ?>

                </div><!-- /#tab2 -->

                <div id="tab3" style="display: none; ">

                    <?php include(locate_template('framework/template/userarea_templates/userarea-tab3.php')); ?>

                </div><!-- /#tab2 -->
	
			</div><!-- /#tab-content -->

			</div><!-- /#tab-widget --> 

			<div class="widget widget_latestpost">
                <?php include(locate_template('framework/template/userarea_templates/userarea-sidebar_recent.php')); ?>
			</div>


            <?php include(locate_template('framework/template/userarea_templates/userarea-sidebar_block.php')); ?>

            <div class="widget widget_latestpost">
                <?php include(locate_template('framework/template/userarea_templates/userarea-sidebar_block2.php')); ?>
            </div>

<!--			<div class="video-box widget row-fluid">-->
<!--				<h3 class="title"><span style="background-color: #;color: #;">Videos Gallery</span></h3>		-->
<!--				<iframe width="369" height="188" src="http://www.youtube.com/embed/pkRB5xC1Cw8" frameborder="0" allowfullscreen></iframe>-->
<!--				<ul>-->
<!--					<li>-->
<!--					<a href="#" title="Permalink to Lectus non rutrum pulvinar urna leo dignissim lorem" rel="bookmark">-->
<!--					<img width="225" height="136" src="http://placehold.it/225x136" alt="" />-->
<!--					</a>-->
<!--					</li>-->
<!--						-->
<!--					<li>-->
<!--					<a href="#" title="Permalink to Vestibulum volutpat tortor libero sodales leo mauris ut lectus" rel="bookmark">-->
<!--					<img width="225" height="136" src="http://placehold.it/225x136" alt="" />-->
<!--					</a>-->
<!--					</li>-->
<!--						-->
<!--					<li>-->
<!--					<a href="#" title="Permalink to Vivamus ultrices luctus nunc sem sit amet interdum consectetuer" rel="bookmark">-->
<!--					<img width="225" height="136" src="http://placehold.it/225x136" alt="" />-->
<!--					</a>-->
<!--					</li>-->
<!--					-->
<!--					<li>-->
<!--					<a href="#" title="Permalink to Phasellus scelerisque massa molestie iaculis lectus pulvinar" rel="bookmark">-->
<!--					<img width="225" height="136" src="http://placehold.it/225x136" alt="" />-->
<!--					</a>-->
<!--					</li>-->
<!--				</ul>-->
<!--        	</div>-->


        				
		</div><!-- sidebar -->
		
		<div class="clearfix"></div>

		<div id="gallery">
            <?php include(locate_template('framework/template/userarea_templates/userarea-main_bottom_gallery.php')); ?>
		</div>

		</div><!-- #main -->

		</div><!-- #content -->


</div><!-- #wrapper -->

<?php get_footer(); ?>