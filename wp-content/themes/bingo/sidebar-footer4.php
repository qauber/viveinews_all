<?php if ( !is_active_sidebar( 'footer-sidebar-4' ) ) : ?>

<!--	<div class="col-md-3 footer-grid">
		<h5><?php _e('No widget here', 'bingo') ?></h5>
	</div>-->

<?php else: ?>

	<div class="col-md-3 footer-grid">
		<?php dynamic_sidebar( 'footer-sidebar-4' ); ?>
	</div>

<?php endif; ?>