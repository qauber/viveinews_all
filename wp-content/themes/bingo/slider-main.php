<?php 

	global $bingo_option_data; 
	$shortcode_slider = $bingo_option_data['bingo-slider'];

?>

		<div class="home-slider">

			<?php echo do_shortcode($shortcode_slider); ?>

		</div> <!-- end .header-home-slider -->