<?php get_header(); ?>


	<div id="page-content">
		<div class="page-content">
			<div class="container">
				<div class="row">
                <div class="col-sm-4 page-sidebar">

						<?php get_sidebar(); ?>

					</div>
					<div class="col-sm-8">

						<?php get_template_part('framework/template/content', 'single'); ?>

					</div>

				</div>
			</div>
		</div>
	</div> <!-- end #page-content -->





<?php get_footer(); ?>