<?php 

global $bingo_option_data;

get_header(); 

?>

	<div id="page-content">
		<div class="page-content">
			<div class="container">
				<div class="row">
                    <div class="col-xs-3 page-sidebar">
						<?php get_sidebar(); ?>
					</div>
					<div class="col-xs-9">
                		<?php get_template_part( 'framework/template/content', '' ); ?>

					</div>

					
				</div>
			</div>
		</div>

		<!-- Our partner section -->
		<?php 

			if( $bingo_option_data['bingo-partners-on-off'] == true ){

				get_template_part( 'framework/template/partner', '' ); 

			}

		?>

		<?php get_template_part( 'framework/template/twitter-template', '' ); ?>


	</div> <!-- end #page-content -->

<?php get_footer(); ?>