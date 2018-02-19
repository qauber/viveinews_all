	<?php global $bingo_option_data; ?>

		<?php if( isset($bingo_option_data['bingo-twitter-feed']) && $bingo_option_data['bingo-twitter-feed'] == 1 ) { ?>
			<div class="twitter-feed-section">
				<div class="container">
					<div class="css-table">
						<div class="css-table-cell">
							<div class="tweets-container flexslider" data-tweets="<?php echo isset($bingo_option_data['bingo-twitter-num-tweets'])?$bingo_option_data['bingo-twitter-num-tweets']:3; ?>" data-user="<?php echo isset($bingo_option_data['bingo-twitter-handle'])?$bingo_option_data['bingo-twitter-handle']:''; ?>"></div>
						</div>

						<a href="#" class="twitter-logo fa fa-twitter"></a>
					</div>
				</div>
			</div> <!-- end .twitter-feed-section -->
		<?php }//} ?>