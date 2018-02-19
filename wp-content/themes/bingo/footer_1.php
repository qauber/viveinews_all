			<footer id="footer">
            <div class="white-div"></div>
				<div class="container">
					<div class="row">
<!--div style="display: inline-block;float: left;width: 15%; color: #fff;padding-left: 20px;"><?php
global $bingo_option_data;
echo $bingo_option_data['footer-editor-text'];
?>
</div-->
<style>#footer ._col-sm-6 {width:42% !important;} </style>
						<?php get_sidebar('footer1'); ?>

						<?php get_sidebar('footer2'); ?>

					<!--	<?php get_sidebar('footer3'); ?>

						<?php get_sidebar('footer4'); ?> -->

					</div>
				</div>

				<div class="footer-copyright">
					<div class="container">
						<p>
							<?php

								//global $bingo_option_data;
								//echo $bingo_option_data['footer-editor-text'];
							?>
						</p>

						<?php if($bingo_option_data['bingo-share-button']){ ?>
							<ul class="footer-social">
						
								<?php if($bingo_option_data['bingo-facebook-link']){ ?>
									<li><a href="<?php echo $bingo_option_data['bingo-facebook-link']; ?>" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
								<?php } ?>

								<?php if($bingo_option_data['bingo-twitter-link']){ ?>
									<li><a href="<?php echo $bingo_option_data['bingo-twitter-link']; ?>" target="_blank"><i class="fa fa-twitter-square"></i></a></li>
								<?php } ?>
								
								<?php if($bingo_option_data['bingo-google-link']){ ?>
									<li><a href="<?php echo $bingo_option_data['bingo-google-link']; ?>" target="_blank"><i class="fa fa-google-plus-square"></i></a></li>
								<?php } ?>

								<?php if($bingo_option_data['bingo-linkedin-link']){ ?>
									<li><a href="<?php echo $bingo_option_data['bingo-linkedin-link']; ?>" target="_blank"><i class="fa fa-linkedin-square"></i></a></li>
								<?php } ?>

								<?php if($bingo_option_data['bingo-pinterest-link']){ ?>
									<li><a href="<?php echo $bingo_option_data['bingo-pinterest-link']; ?>" target="_blank"><i class="fa fa-pinterest-square"></i></a></li>
								<?php } ?>
								
							</ul> <!-- end .header-social -->
						<?php } ?>
					</div>
				</div>
			</footer> <!-- end #footer -->

		<!-- <a href="#" class="btn btn-default fa fa-arrow-up" id="back-to-top"></a> -->

		</div> <!-- end #main-wrapper -->

		<?php wp_footer(); ?>
        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
$('#footer .col-md-6:last').append($('.footer-social'));
$('#footer .col-md-6:last h5').remove();
$('.header-login').addClass('wrap');
$('.header-register').addClass('wrap');
$('.wrap').wrapAll('<div class="wrapAll"></div>');
$('#menu-home-menu').append($('.wrapAll'));
$('.header-register').on('click', function(){
    $(this).toggleClass('active');
    $('.header-register div').toggle();
});
$('.login').on('click', function(){
$('.header-login div').toggle();
});
$('.header-login a i, .header-register a i').remove();
$('.header-language a span').text('ENGLISH');
$('.header-language').on('click', function(){
$('.header-language ul').toggle();
});
$('.header-language').insertAfter($('#header .logo'));
$('.footer-social i.fa-twitter-square').removeClass('fa-twitter-square').addClass('fa-twitter');
$('.footer-social i.fa-facebook-square').removeClass('fa-facebook-square').addClass('fa-facebook');
$('.footer-social i.fa-google-plus-square').removeClass('fa-google-plus-square').addClass('fa-google-plus');
$('.footer-social i.fa-linkedin-square').removeClass('fa-linkedin-square').addClass('fa-linkedin');
$('.footer-social i.fa-pinterest-square').removeClass('fa-pinterest-square').addClass('fa-pinterest');
$('#footer .col-xs-12:last h5').remove();
$('#footer .col-xs-12:last').append($('.footer-social'));
if($( document ).width()<768){
$('#footer .col-xs-12:last').append($('.footer-social'));
$('#footer .col-xs-12:last h5').remove();
}
var url = document.location.href; 
if(!url.indexOf('http://news.for-test1ng.tk/?cat')){
    var string = $('.breadcrumbs .current').text();
    var newString = string.substr(20,(string.length)); 
    string = $('.breadcrumbs .current').text(newString);
} else if(!url.indexOf('http://news.for-test1ng.tk/?product_cat')){
    var string = $('.breadcrumbs .current').text();
    var newString = string.substr(12,(string.length)); 
    string = $('.breadcrumbs .current').text(newString);
}
$('.products').wrap('<div class="col-xs-9"></div>');
$('.products .page-sidebar').insertBefore($('.products').parent());
$('.products').parent().removeClass('col-xs-9').addClass('col-xs-12 w1000 pr0');
$('.breadcrumbs').wrap('<div class="col-xs-12"></div>');
$('.woocommerce-main-image').append($('.post-meta+p>iframe'));
$('.woocommerce-main-image img').remove();
$('.post-meta+p').clone().appendTo($('.woocommerce-main-image'));
//$('.responsive-tabs .nav li:eq(1)').remove();
$('#tab-additional_information>h2').remove();
$('.woocommerce-main-image').removeAttr('href');
$('#tab-additional_information>table').appendTo($('.woocommerce-main-image'));
var htmlA = $('.woocommerce-main-image').html();
$('.woocommerce-main-image').replaceWith('<div class="big-thumb"></div>');
$('.big-thumb').html(htmlA);
$('.post-meta>li:first>a').appendTo('.posted');
//$('<span class="by">by </span>').insertBefore($('.posted a'));
$('.posted').insertAfter('.big-thumb iframe');
$('.summary+div h4').addClass('title-big').insertBefore($('.project-post'));
$('.post-meta li:first, .summary ,.tab-pane>div>div>h2  ,.tab-pane>h2').remove();
$('.fa-check-square').removeClass('fa-check-square').addClass('fa-gavel');
//$('.single-product .title-big, .single-product .project-post, .single-product .page-sidebar').wrapAll('<div class="project-list-post"></div>');
//$('.project-list-post').append('<div class="clear"></div>');
$('.submit').addClass('read-more');
$('.woocommerce-page .quantity .plus').attr('value','');
$('.woocommerce-page .quantity .minus').attr('value','');
$('.bid_button i, .unique-buy i,.bid-item p i').remove();

    if($( document ).width()<768){
        //$('.single-product').find('.page-sidebar').removeClass('page-sidebar no-hide');
        /*$('.page-sidebar').css({
            //display:"none",
            //left:'-200px',
            //position:'absolute'
        });*/
        $('.wb-left-menu').css({
            display:"none",
            left:'-200px',
            position:'absolute'
        });
    }
/* side menu pop up ===============  */

    $( window ).resize(function() {
         if($( document ).width()>=768){
            $('.page-sidebar')
                .css({display: "block"})
                .removeClass('sideStyle');
         }else{
            $('.page-sidebar')
                .css({display: "none"});
         }
    });

    $('#mobile-menu-toggle2').on('click',function(){
        
        if(!$('.page-sidebar').hasClass('sideStyle')){
            $('.page-sidebar').fadeIn().addClass('sideStyle');
        } else if($('.page-sidebar').hasClass('sideStyle')){
            $('.page-sidebar')
            .fadeOut()
            .removeClass('sideStyle');
        }
    });

/* side menu pop up ===============  */

    $('#mobile-menu-toggle3').on('click',function(){
        if(!$('.wb-left-menu').hasClass('sideStyle')){
            $('.wb-left-menu').animate({
                 left:'52px',
                 top:'0px'
            },500).css({
                display:"block"
            }).addClass('sideStyle');
        } else if($('.wb-left-menu').hasClass('sideStyle')){
            $('.wb-left-menu').fadeOut().removeClass('sideStyle');
            }
    });
if($( document ).width()<1239){
    $('.col-xs-12').removeClass('myWidth myWidthSL');
    $('.filter-item').removeClass('col-lg-4');
}
function myAcc(){
    location.href='/my-account/';
}
$('.header-register').unbind();
$('.header-register a').attr('onclick','myAcc()');
$('[title=comment]').append($('#comm'));
$('[title=comment]').mouseover(function(){
    $('#comm').show();
});
$('[title=comment]').mouseout(function(){
     $('#comm').hide();
    });
$('.blog-post .col-lg-6').removeClass('col-sm- col-xs- col-md-').addClass('col-sm-6 col-xs-12');
$('.page-id-93 .col-sm-9').removeClass('col-sm-9').addClass('col-xs-12');
$('.logged-in-as').next().next().text('SEND').addClass('my-send');
$('.stat_display').removeClass('wrap').insertAfter($('.content'));
$('#tab_ul li a').removeAttr('href');
$('.single-product .nav-tabs li:first').addClass('active');
$('.tab-content #tab-description').addClass('active');
   if($( window ).width()<992){
        $('<li class="menu-item menu-item-type-custom menu-item-object-custom"></li>').insertAfter('#menu-top-menu li:last-child');
        $('.b-menu').appendTo('#menu-top-menu li:last-child').find('.wb-menu-list').text('Setting').addClass('sett');
    }
    $('.sett').one('click',function(){
        $(this).next().css({
            'position':'static'
        });
        $(this).next().children().toggle();
    });  
$('#menu-top-menu>.menu-item>a').each(function(){
        votes = $('strong',this).html();
        $(this).html(votes);
});    

function shine (el){
    $('.menu-item').find('a').removeAttr('id','active-cat');
    $('#menu-top-menu>li').removeClass('m-active');
    $(el).attr('id','active-cat');
}
/* ================= */
var activeLink = function(isAjax){
    var url = location.href.replace(/page(\/[0-9]\/)/i,'');
    $('.sub-menu').css('padding-left','10px');
    if(isAjax)
        $('#menu-top-menu>li').removeClass('m-active');
    $('.menu-item').find('a').removeAttr('id','active-cat');
    $('.menu a').each(function(){
      
        if(url == $(this).attr('href')){
            $(this).attr('id','active-cat');
            var url_arr = location.href.split("/");
            if(url_arr[5].length && url_arr[5] != "page"){
                $('#active-cat').parents().show();
            }
        }
        if((location.href.indexOf('contact') != -1) && (location.href.indexOf($(this).attr('href')) != -1)){ 
            $(this).attr('id','active-cat');
        }
    });
}
activeLink(true);
/* ================= */
/* new ajax load ================= */
var ajaxContent = function(href, addEntry, bottomMenu){
    $.ajax({
        type: 'GET',
        url: href,
        beforeSend: function(){
             $('.w1000').html('').append('<img id="pre-load" src="/wp-content/themes/bingo/img/ajax-loader.gif">');
        },
        success: function(data) {
        	//console.log();
            $('title').text($(data).filter("title").eq(0).text());
            $('.w1000').html($(data).find(".w1000").html());
            if($(data).find(".page-title").length){
            	$('.w1000').prepend( "<h1 class='h4'>"+$(data).find(".page-title").text()+"</h1>" );
            }
            if($(data).find(".woocommerce-pagination").length){
              $('.woocommerce-pagination').remove();
              $( '<nav class="woocommerce-pagination">' + $(data).find(".woocommerce-pagination").html() + '</nav>').insertAfter('.banner-div');
            }
            if(bottomMenu)
                $('html, body').animate({scrollTop: 150},500);
            if(addEntry == true) {
                history.pushState(null, null, href); 
            }
            activeLink(true);
        }
    });
}
window.addEventListener("load", function(e) {
    setTimeout(function() {
        window.addEventListener("popstate", function(e) {
            ajaxContent(location.pathname, false);
        }, false);
    }, 0);
}, false);
/* end new ajax load ============= */
    
function rem_class(){
  $('.row').removeClass('row');
  $('.single-product').removeClass('single-product');
  $('.w1000').removeClass('one-video');
  $('.woocommerce-pagination').remove();
}

$('.menu>li>a').on('click',function(e){
	var href =  $(this).attr('href');
	if(href != "http://liveinews.com/contact/"){
    e.preventDefault();
    rem_class();
    $('.title-big').hide();
    //$('.sub-menu').css('padding-left','10px');
    $(this).next().slideToggle();
    ajaxContent(href, true, true);
	}   
});
    
$('.menu>li>.sub-menu>li>a').on('click',function(e){
    e.stopPropagation();
    e.preventDefault();
    rem_class();
    $('.title-big').hide();
    $(this).next().slideDown();
    var href =  $(this).attr('href');
    ajaxContent(href, true, false);    
});

$('.menu>li>.sub-menu>li>.sub-menu>li>a').on('click',function(e){
    e.stopPropagation();
    e.preventDefault();
    rem_class();
    $('.title-big').hide();
    //$('.sub-menu').css('padding-left','10px');
    $(this).next().slideDown();
    var href =  $(this).attr('href');
    ajaxContent(href, true, false);   
});

$('.beforeW1000').insertBefore('.w1000');
if($('.page-title').length > 0) {
	$('.w1000').first().prepend( "<h1 class='h4'>"+$('.container').find(".page-title").text()+"</h1>" );
}
</script>
<?php
$user_status = get_user_meta($user_ID,'user_type', true);
if($user_status == "user") {
?>
<script>
    $('#menu-top-menu>#menu-item-2451').remove();
</script>
<?php
}
?>
	</body>
</html>