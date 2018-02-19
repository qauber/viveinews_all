<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
	?>
	<div class="thumbnails <?php echo 'columns-' . $columns; ?>">
		<div class="our-partners-slider-container">
			<div class="">
				<div class="product-thumbnail-slider flexslider">
					<ul class="slides">

						<?php

						foreach ( $attachment_ids as $attachment_id ) {

							$classes = array( 'zoom' );

							if ( $loop == 0 || $loop % $columns == 0 )
								$classes[] = 'first';

							if ( ( $loop + 1 ) % $columns == 0 )
								$classes[] = 'last';

							$image_link = wp_get_attachment_url( $attachment_id );

							// echo $image_link;
							// echo $attachment_id;

							if ( ! $image_link )
								continue;

							$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
							$image_class = esc_attr( implode( ' ', $classes ) );
							$image_title = esc_attr( get_the_title( $attachment_id ) ); ?>


							<li>
								<a href="<?php echo $image_link; ?>" class="<?php echo $classes; ?>" title="<?php echo $image_title; ?>" data-rel="prettyPhoto[product-gallery]">
									<div class="css-table">
										<div class="css-table-cell">
											<img class="image attachment-shop_thumbnail" src="<?php echo $image_link; ?>" alt="<?php echo $image_title; ?>">
										</div>
									</div>
								</a>
							</li>			


							<?php

							// echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );

							$loop++;
						}

					?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<?php
}
