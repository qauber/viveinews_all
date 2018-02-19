<?php 
    global $bingo_option_data;


?>

<!-- mail -->
	<div class="mail" id="mail">
		<div class="container">
                        <div class="maps-overlay" onClick="style.pointerEvents='none'"></div>
			<iframe class="animated wow fadeInDown" data-wow-delay="500ms" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyApEvriY5wfPNGaTAkdaSJLnj_uIBPP4eI&q=<?php echo urlencode($bingo_option_data['bingo-contact-location']); ?>" frameborder="0" style="border:0" allowfullscreen></iframe>
			<div class="col-md-6 mail-left animated wow fadeInLeft" data-wow-delay="500ms">
				<div class="banner-bottom-text">
					<h3>Mail</h3>
					<div class="banner-bottom-text-pos banner-bottom-text-posmail">
						<h3>Us</h3>
					</div>
				</div>
				<div class="bar1 bar-con bar-con1">
						<div class="bar3" data-percent="70"></div>
					</div>
			</div>
			<div class="col-md-6 mail-right animated wow fadeInLeft" data-wow-delay="700ms">
				<h3>Contact Info...</h3>
				<div class="mail-right-grid">
					<ul>
						<li><i class="glyphicon glyphicon-map-marker" aria-hidden="true"></i></li>
						<li><?php echo $bingo_option_data['bingo-contact-location']; ?></li>
					</ul>
					<ul>
						<li><i class="glyphicon glyphicon-send send" aria-hidden="true"></i></li>
						<li><a href="mailto:<?php echo $bingo_option_data['bingo-contact-email']; ?>"><?php echo $bingo_option_data['bingo-contact-email']; ?></a></li>
					</ul>
					<ul>
						<li><i class="glyphicon glyphicon-earphone call" aria-hidden="true"></i></li>
						<li><?php echo $bingo_option_data['bingo-contact-phone']; ?></li>
					</ul>
				</div>
			</div>
			<div class="clearfix"> </div>
			<div class="mail-grids animated wow fadeInUp" data-wow-delay="700ms">
				<?php echo do_shortcode('[contact-form-7 id="5911" title="Untitled"]'); ?>
			</div>
		</div>
	</div>
<!-- //mail -->