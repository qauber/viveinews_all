<?php
global $product, $woocommerce, $post;

//REMOVING DEFAULT TEMPLATING OF AUCTION PLUGIN
remove_action('woocommerce_single_product_summary', 'woocommerce_auction_bid', 25);

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
?>

<?php
do_action('woocommerce_before_single_product');

//set view for video-product
bingo_set_video_view($post->ID);

if (post_password_required()) {
    echo get_the_password_form();
    return;
}
?>
<style>
    .wb-banner-650 {
        
        line-height: 200px;
        text-align: center;
        width: auto;
    }
    .wb-banner-650 img {
        width: 100%;
        height: 100%;
    }
    .responsive-tabs {
        display: block;
        margin-bottom: 15px;
        margin-top: 10px !important;
        position: relative;
    }   
    .wb-left-menu {
        display: block;
        float:left;
        width: 256px;
        padding: 0 10px 0 0;
    }
    .project-list-post {
        margin-bottom: 30px;
        /*  margin-left: 256px; */
        position: relative;
    }
    .wb-myWidth-post {
        width: 678px;
    }
    .wb-ratings {
        float:right;
        padding: 0 10px;
    }
    h4.wb-title {
        font-size: 34px;
        color: #000000;
        margin-top: 0;
    }
</style>
<div id="mobile-menu-toggle2"><span></span></div>
<!--<div class="col-xs-12 col-sm-2 page-sidebar">
    <?php // get_sidebar(); ?>
</div>-->
<div class="col-xs-12 col-md-12 col-sm-12 w1000 one-video pr0">
    <?php
    if (is_user_logged_in()) {
        ?>
        <div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h4 class="wb-title"><?php echo mb_substr(stripcslashes($post->post_title), 0, 48); ?></h4>
            <?php do_action('woocommerce_before_single_product_summary'); ?>
            <?php do_action('woocommerce_after_single_product_summary'); ?>
            <?php
            if (is_super_admin()) {
                echo "Views: " . kama_postviews($post->ID);
            }
            ?>
            <meta itemprop="url" content="<?php the_permalink(); ?>" />

            <div class="wb_block-info-buy">To see detailed information pleasae click on Description Tab</div>
            <div class="wb-banner-650">
                <?php
                $option = get_option('wb-banner-block');
                $option = unserialize($option);
                echo htmlspecialchars_decode(wp_unslash($option[4]));
                ?>
            </div>

        </div>
        <?php
    } else {
        echo '<p>';
        echo '<b style="color: #000000;">This page is protected. Sign in to your account.</b>';
        echo '</p>';
        ?>
        <?php
    }
    ?>
</div>

<!-- banner blok right-block.php -->
<?php // get_template_part('right', 'block'); ?>
<!-- banner blok right-block.php -->

<?php do_action('woocommerce_after_single_product'); ?>