<?php if ( !is_active_sidebar( 'footer-sidebar-3' ) ) : ?>

	<div class="col-md-3 footer-grid footer-grid1">
		<h5><?php _e('No widget here', 'bingo') ?></h5>
	</div>

<?php else: ?>

	<div class="col-md-3 footer-grid footer-grid1">
		<?php dynamic_sidebar( 'footer-sidebar-3' ); ?>
	</div>

<?php endif; ?>