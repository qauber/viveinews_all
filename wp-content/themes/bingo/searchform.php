<form role="form search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<div class="form-group">
			<label class="screen-reader-text sr-only-focusable" for="s"><?php _e( 'Search for:', 'bingo' ); ?></label>
			<input type="text" class="form-control" value="<?php echo get_search_query(); ?>" name="s" id="s" />
			<input type="submit" id="searchsubmit" value="<?php _e( '&#xf002;', 'bingo' ); ?>" />
		</div>
	</div>
</form>