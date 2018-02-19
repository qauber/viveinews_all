<?php
$option = get_option('wb-banner-block');
$option = unserialize($option);
?>
<div class="col-xs-12 col-sm-2 banner-div">
  <div class="wb-banner-block">
    <div class="col-sm-5 col-xs-12 no-hide wb-banner-200">
      <?php echo htmlspecialchars_decode(wp_unslash($option[0]));?>
    </div>
    <div class="col-sm-5  col-xs-12 no-hide wb-banner-200 wb-banner-mt">
      <?php echo htmlspecialchars_decode(wp_unslash($option[1]));?>
    </div>
    <div class="col-sm-5  col-xs-12 no-hide wb-banner-200 wb-banner-mt">
      <?php echo htmlspecialchars_decode(wp_unslash($option[2]));?>
    </div>
    <div class="col-sm-5  col-xs-12 no-hide wb-banner-200 wb-banner-mt">
       <?php echo htmlspecialchars_decode(wp_unslash($option[3]));?>
    </div>
    <div class="clear"></div>
  </div>
</div>