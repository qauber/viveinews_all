<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );
if ( ! empty( $tabs ) ) : 
?>

	<div style="clear:both">
		<ul class="nav nav-tabs" role="tablist">
			<?php foreach ( $tabs as $key => $tab ) :  
                                //if( $key == "reviews") continue;
                                if( $tab['title'] == "Vendor" ) continue;

                                ?>
                    
				<li role="presentation" >
					<a href="#tab-<?php echo $key ?>" data-toggle="tab"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
				</li>

			<?php endforeach; ?>
		</ul>

		<div class="tab-content">
			<?php foreach ( $tabs as $key => $tab ) : ?>

				<div class="tab-pane" role="tabpanel" id="tab-<?php echo $key ?>">
					<?php call_user_func( $tab['callback'], $key, $tab ) ?>
				</div>

			<?php endforeach; ?>
		</div>
	</div>

<?php endif; ?>