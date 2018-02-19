<?php
/**
 * Auction bid
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;
$current_user = wp_get_current_user();
/*
?>



<?php if(($product->is_closed() === FALSE ) and ($product->is_started() === TRUE )) : ?>

<div class="price">
	<p class="auction-condition"><?php echo apply_filters('conditiond_text', __( 'Item condition:', 'bingo' ), $product->product_type); ?><span class="curent-bid"> <?php echo $product->get_condition(); ?></span></p>

	<div class="auction-time" id="countdown"><?php echo apply_filters('time_text', __( 'Time left:', 'bingo' ), $product->product_type); ?>
		<div class="main-auction auction-time-countdown" data-time="<?php echo $product->get_seconds_remaining() ?>" data-auctionid="<?php echo $product->id ?>" data-format="<?php echo get_option( 'simple_auctions_countdown_format' ) ?>"></div>
	</div>


	<?php if ($product->auction_bid_count == 0){?>
	    <p class="auction-bid"><?php echo apply_filters('starting_bid_text', __( 'Starting bid:', 'bingo' )); ?> <span class="starting-bid amount"> <?php echo wc_price($product->get_curent_bid()); ?></span> </p>
	<?php } ?>

	<?php if ($product->auction_bid_count > 0){?>
	    <p class="auction-bid"><?php echo apply_filters('curent_bid_text', __( 'Current Price:', 'bingo' )); ?> <span class="curent-bid amount"> <?php echo wc_price($product->get_curent_bid()); ?></span> </p>
	<?php } ?>


	<p><?php _e('Buy Now','bingo'); ?> <span> <?php echo woocommerce_price($product->regular_price); ?></span></p>

</div>

	<div class='auction-ajax-change'>
		<div class="info">
		<?php //echo strtotime($product->get_auction_end_time());
			$now = time(); // or your date as well
            $your_date = strtotime($product->get_auction_end_time());
            $datediff = $your_date - $now;
		?>
			<p class="auction-end"><?php //echo apply_filters('time_left_text', __( 'Auction ends:', 'bingo' ), $product->product_type); ?> <!-- <span class="date-time"><?php //echo  date_i18n( get_option( 'date_format' ),  strtotime( $product->get_auction_end_time() ));  ?>  <?php //echo  date_i18n( get_option( 'time_format' ),  strtotime( $product->get_auction_end_time() ));  ?> </span><br /> -->
				<?php printf(__('Timezone: <span class="time-zone">%s</span>','bingo') , get_option('timezone_string') ? get_option('timezone_string') : __('UTC+','bingo').get_option('gmt_offset')) ?>
			</p>

			<?php if ($product->auction_bid_count == 0){?>
			    <!-- <p class="auction-bid"><?php //echo apply_filters('starting_bid_text', __( 'Starting bid:', 'bingo' )); ?> <span class="starting-bid amount"> <?php //echo wc_price($product->get_curent_bid()); ?></span> </p> -->
			<?php } ?>

			<?php if ($product->auction_bid_count > 0){?>
			    <!-- <p class="auction-bid"><?php //echo apply_filters('curent_bid_text', __( 'Current bid:', 'bingo' )); ?> <span class="curent-bid amount"> <?php //echo wc_price($product->get_curent_bid()); ?></span></p> -->
			<?php } ?>

			<?php if(($product->is_reserved() === TRUE) &&( $product->is_reserve_met() === FALSE )  ) : ?>
				<p class="reserve hold"><?php echo apply_filters('reserve_bid_text', __( "Reserve price has not been met", 'bingo' )); ?></p>
			<?php endif; ?>

			<?php if(($product->is_reserved() === TRUE) &&( $product->is_reserve_met() === TRUE )  ) : ?>
				<p class="reserve free"><?php echo apply_filters('reserve_met_bid_text', __( "Reserve price has been met", 'bingo' )); ?></p>
			<?php endif; ?>

			<?php if($product->auction_type == 'reverse' ) : ?>
				<p class="reverse"><?php echo apply_filters('reverse_auction_text', __( "This is reverse auction.", 'bingo' )); ?></p>
			<?php endif; ?>

			<span>
				<i class="fa fa-check-square"></i>
				<?php
					if($product->auction_bid_count){
						echo $product->auction_bid_count;
					}else{
						echo "0";
					}
					_e(' bids', 'bingo');
				?>
				</span>
			<span>
				<i class="fa fa-clock-o"></i>
				<?php
					if( $datediff > 0 ){
                        echo floor($datediff/(60*60*24)) . " ";
						_e('Days to go', 'bingo');
                    }else{
                        echo "Auction Expired";
                    }
				?>
			</span>

		</div>
		<?php do_action('woocommerce_before_bid_form'); ?>

		<div class="text-center">
			<form class="auction_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>">

				<?php do_action('woocommerce_before_bid_button'); ?>

				<input type="hidden" name="bid" value="<?php echo esc_attr( $product->id ); ?>" />
				<?php if($product->auction_type == 'reverse' ) : ?>
					<div class="quantity buttons_added" style="margin-bottom:10px">
						<input type="button" value="+" class="plus" />
						<input type="number" name="bid_value" value="<?php echo $product->bid_value() ?>" max="<?php echo $product->bid_value()  ?>"  step="any" size="<?php echo strlen($product->get_curent_bid())+2 ?>" title="bid"  class="input-text-bid qty bid text left">
						<input type="button" value="-" class="minus" />
					 	<button type="submit" class="bid_button alt btn btn-gray" style="padding:2px 15px"><i class="fa fa-check-square"></i><?php echo apply_filters('bid_text', __( 'Bid', 'bingo' ), $product->product_type); ?></button>
					 </div>
				<?php else : ?>
					<div class="quantity buttons_added" style="margin-bottom:10px">
					 	<input type="button" value="+" class="plus" />
						<input type="number" name="bid_value" value="<?php echo $product->bid_value()  ?>" min="<?php echo $product->bid_value()  ?>"  step="any" size="<?php echo strlen($product->get_curent_bid())+2 ?>" title="bid"  class="input-text-bid qty bid text left">
						<input type="button" value="-" class="minus" />
					</div>
			 	<button type="submit" class="bid_button alt btn btn-gray" style="padding:2px 15px"><i class="fa fa-check-square"></i><?php echo apply_filters('bid_text', __( 'Bid', 'bingo' ), $product->product_type); ?></button>
			 	<?php endif; ?>

			 	<input type="hidden" name="place-bid" value="<?php echo $product->id; ?>" />
				<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
				<?php do_action('woocommerce_after_bid_button'); ?>
			</form>
			<?php _e('or', 'bingo'); ?>
		</div>
		<?php do_action('woocommerce_after_bid_form'); ?>
	</div>

<?php elseif (($product->is_closed() === FALSE ) and ($product->is_started() === FALSE )):?>

	<div class="auction-time" id="countdown"><?php echo apply_filters('auction_starts_text', __( 'Auction starts in:', 'bingo' ), $product->product_type); ?>
		<div class="auction-time-countdown" data-time="<?php echo $product->get_seconds_to_auction() ?>" data-format="<?php echo get_option( 'simple_auctions_countdown_format' ) ?>"></div>
	</div>

	<p class="auction-end"><?php echo apply_filters('time_text', __( 'Auction start:', 'bingo' ), $product->product_type); ?><?php echo  date_i18n( get_option( 'date_format' ),  strtotime( $product->get_auction_start_time() ));  ?>  <?php echo  date_i18n( get_option( 'time_format' ),  strtotime( $product->get_auction_start_time() ));  ?></p>
	<p class="auction-end"><?php echo apply_filters('time_text', __( 'Auction ends:', 'bingo' ), $product->product_type); ?> <?php echo  date_i18n( get_option( 'date_format' ),  strtotime( $product->get_auction_end_time() ));  ?>  <?php echo  date_i18n( get_option( 'time_format' ),  strtotime( $product->get_auction_end_time() ));  ?> </p>

<?php endif;
*/ ?>
