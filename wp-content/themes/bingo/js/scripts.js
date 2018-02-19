/*!
 * imagesLoaded PACKAGED v3.1.8
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */



;(function($) {

"use strict";

var $body = $('body');
var $head = $('head');
var $mainWrapper = $('#main-wrapper');



// Mediaqueries
// ---------------------------------------------------------
var XS = window.matchMedia('(max-width:767px)');
var SM = window.matchMedia('(min-width:768px) and (max-width:991px)');
var MD = window.matchMedia('(min-width:992px) and (max-width:1199px)');
var LG = window.matchMedia('(min-width:1200px)');
var XXS = window.matchMedia('(max-width:480px)');
var SM_XS = window.matchMedia('(max-width:991px)');
var LG_MD = window.matchMedia('(min-width:992px)');



// Touch
// ---------------------------------------------------------
var dragging = false;

$body.on('touchmove', function() {
  dragging = true;
});

$body.on('touchstart', function() {
  dragging = false;
});



// Mobile Header
// ---------------------------------------------------------
$('#header').on('clickoutside touchendoutside', function () {
  $('#mobile-search-container, #mobile-menu-container').slideUp(250);
});



// Mobile Search Form
// ---------------------------------------------------------
var $searchForm = $('#header .header-search'),
  $mobileSearchContainer = $('#mobile-search-container');

function moveSearchForm(SM_XS) {
  if (SM_XS.matches) {
    $searchForm.appendTo($mobileSearchContainer);
  } else {
    $searchForm.appendTo($('#header .header-top-bar > .container').not($mobileSearchContainer));
    $mobileSearchContainer.removeAttr('style');
  }
}

moveSearchForm(SM_XS);
SM_XS.addListener(moveSearchForm);

$('#mobile-search-toggle').on('click', function (event) {
  event.preventDefault();

  $('#mobile-search-container').slideToggle(250);
});



// Mobile Primary Nav
// ---------------------------------------------------------
var $primaryNav = $('#header .primary-nav'),
  $mobileMenuContainer = $('#mobile-menu-container');

function mobilePrimaryNav(SM_XS) {
  if (SM_XS.matches) {
    $primaryNav.appendTo($mobileMenuContainer.children('.menu'));
  } else {
    $primaryNav.appendTo('#header .header-nav-bar nav');
    $mobileMenuContainer.removeAttr('style');
  }
}

mobilePrimaryNav(SM_XS);
SM_XS.addListener(mobilePrimaryNav);

$('#mobile-menu-toggle').on('click', function (event) {
  event.preventDefault();

  $mobileMenuContainer.slideToggle(250);
});



// Move Call to Action
// ---------------------------------------------------------
var $callToAction = $('#header .header-call-to-action');

function moveCallToAction(XS) {
  if (XS.matches) {
    $callToAction.insertBefore('#header .header-language');
  } else {
    $callToAction.insertBefore('#header .header-social');
  }
}

moveCallToAction(XS);
XS.addListener(moveCallToAction);



// Header Login/Register Toggle
// ---------------------------------------------------------
var $headerLoginRegister = $('#header .header-login, #header .header-register');

function headerLoginRegister(XS) {
  if (XS.matches) {
    $headerLoginRegister.appendTo($mobileMenuContainer.children('.login-register'));
  } else {
    $('#header .header-top-bar .container').first().prepend($headerLoginRegister);
    $headerLoginRegister.removeAttr('style');
    $mobileMenuContainer.find('.mobile-register-toggle, .mobile-login-toggle').removeClass('active');
  }
}

headerLoginRegister(XS);
XS.addListener(headerLoginRegister);

$headerLoginRegister.each(function () {
  var $this = $(this);

  if (!$this.hasClass('logout')) {
    $this.children('a').on('click', function (event) {
      event.preventDefault();
      $this.toggleClass('active');
    });
  }

  $this.on('clickoutside touchendoutside', function () {
    if ($this.hasClass('active')) { $this.removeClass('active'); }
  });
});

var $headerLoginClone = $('#header .header-login > .btn').clone(false).addClass('clone mobile-login-toggle'),
  $headerRegisterClone = $('#header .header-register > .btn').clone(false).addClass('clone mobile-register-toggle');

$mobileMenuContainer.children('.login-register').prepend($headerLoginClone, $headerRegisterClone);

$mobileMenuContainer.find('.mobile-login-toggle').on('click', function (event) {
  event.preventDefault();

  var $this = $(this),
    $container = $mobileMenuContainer.find('.header-login');

  if (!$this.hasClass('active')) {
    $mobileMenuContainer.find('.mobile-register-toggle').removeClass('active');
    $mobileMenuContainer.find('.header-register').slideUp(250);

    $container.slideDown(250);
    $this.addClass('active');
  } else {
    $container.slideUp(250);
    $this.removeClass('active');
  }
});

$mobileMenuContainer.find('.mobile-register-toggle').on('click', function (event) {
  event.preventDefault();

  var $this = $(this),
    $container = $mobileMenuContainer.find('.header-register');

  if (!$this.hasClass('active')) {
    $mobileMenuContainer.find('.mobile-login-toggle').removeClass('active');
    $mobileMenuContainer.find('.header-login').slideUp(250);

    $container.slideDown(250);
    $this.addClass('active');
  } else {
    $container.slideUp(250);
    $this.removeClass('active');
  }
});



// Header Language Toggle
// ---------------------------------------------------------
var $headerLanguageToggle = $('#header .header-language');

$headerLanguageToggle.children('a').on('click', function (event) {
  event.preventDefault();
  $(this).parent('.header-language').toggleClass('active');
});

$headerLanguageToggle.on('clickoutside touchendoutside', function () {
  if ($headerLanguageToggle.hasClass('active')) { $headerLanguageToggle.removeClass('active'); }
});



// Header Search Options Toggle
// ---------------------------------------------------------
var $headerSearchOptionsToggle = $('#header .header-search .toggle');

$headerSearchOptionsToggle.children('a').on('click', function (event) {
  event.preventDefault();
  $(this).parent('.toggle').toggleClass('active');
});

$headerSearchOptionsToggle.on('clickoutside touchendoutside', function () {
  if ($headerSearchOptionsToggle.hasClass('active')) { $headerSearchOptionsToggle.removeClass('active'); }
});

function headerSearchOptionsToggleCheckbox() {
  var $this = $(this),
    $li = $this.closest('li');

  if ($this.prop('checked')) {
    $li.addClass('active');
  } else {
    $li.removeClass('active');
  }
}

$headerSearchOptionsToggle.find('input[type="checkbox"]').each(headerSearchOptionsToggleCheckbox).on('change', headerSearchOptionsToggleCheckbox);



// Submenu Levels
// ---------------------------------------------------------
$('#header .primary-nav li.has-submenu').each(function () {
  $(this).append('<span class="submenu-arrow"></span>');
});

$('#header .header-nav-bar li.has-submenu > .submenu-arrow').on('click', function () {
  var $this = $(this),
    $thisLi = $this.parent('li');

  if (!$thisLi.hasClass('hover')) {
    $thisLi.siblings('li').removeClass('hover').find('.has-submenu').removeClass('hover');
    $thisLi.addClass('hover');
  } else {
    $thisLi.removeClass('hover').find('.has-submenu').removeClass('hover');
  }
});

$('#header .header-nav-bar').on('clickoutside touchendoutside', function () {
  if (!dragging) {
    $('#header .header-nav-bar li.has-submenu').removeClass('hover');
  }
});

function removeMenusHoverClass(SM_XS) {
  if (!SM_XS.matches) {
    $('#header .header-nav-bar li.has-submenu').removeClass('hover');
  }
}

removeMenusHoverClass(SM_XS);
SM_XS.addListener(removeMenusHoverClass);



// Responsive Tabs
// ---------------------------------------------------------
if ($.fn.responsiveTabs) {
  $('.responsive-tabs').responsiveTabs();
}



// Accordion
// ---------------------------------------------------------
$('.accordion').each(function () {

  $(this).find('ul > li > a').on('click', function (event) {
    event.preventDefault();

    var $this = $(this),
      $li = $this.parent('li'),
      $div = $this.siblings('div'),
      $siblings = $li.siblings('li').children('div');

    if (!$li.hasClass('active')) {
      $siblings.slideUp(250, function () {
        $(this).parent('li').removeClass('active');
      });

      $div.slideDown(250, function () {
        $li.addClass('active');
      });
    } else {
      $div.slideUp(250, function () {
        $li.removeClass('active');
      });
    }
  });

});



// Progress Bar
// ---------------------------------------------------------
$('.progress-bar').each(function () {

  var $this = $(this),
    progress = $this.data('progress');

  if (!$this.hasClass('no-animation')) {
    $this.one('inview', function () {
      $this.children('.progress-bar-inner').children('span').css('width', progress + '%');
    });
  } else {
    $this.children('.progress-bar-inner').children('span').css('width', progress + '%');
  }

  if ($this.hasClass('toggle')) {
    $this.children('.progress-bar-toggle').on('click', function (event) {
      event.preventDefault();

      if (!$this.hasClass('active')) {
        $this.children('.progress-bar-content').slideDown(250, function () {
          $this.addClass('active');
        });
      } else {
        $this.children('.progress-bar-content').slideUp(250, function () {
          $this.removeClass('active');
        });
      }
    });
  }

});



// Rating Toggle
// ---------------------------------------------------------
$('.rating-toggle').each(function () {

  var $this = $(this);

  $this.children('.toggle').on('click', function (event) {
    event.preventDefault();

    if (!$this.hasClass('active')) {
      $this.children('.rating-content').slideDown(250, function () {
        $this.addClass('active');
      });
    } else {
      $this.children('.rating-content').slideUp(250, function () {
        $this.removeClass('active');
      });
    }
  });

});



// Animated Counter
// ---------------------------------------------------------
$('.animated-counter').each(function () {
  var $this = $(this),
    $text = $this.children('span'),
    number = $this.data('number');

  $this.one('inview', function () {
    $({numberValue: 0}).animate({numberValue: number}, {
      duration: 2500,
      step: function () {
        $text.text(Math.ceil(this.numberValue));
      },
      complete: function () {
        $text.text(number);
      }
    });
  });
});



// Progress Circle
// ---------------------------------------------------------
$('.progress-circle').each(function () {

  var $this = $(this),
    progress = $this.data('progress'),
    html = '',
    angle;

  html += '<div class="loader"><div class="loader-bg"><div class="text">0%</div></div>';
  html += '<div class="spiner-holder-one animate-0-25-a"><div class="spiner-holder-two animate-0-25-b"><div class="loader-spiner"></div></div></div>';
  html += '<div class="spiner-holder-one animate-25-50-a"><div class="spiner-holder-two animate-25-50-b"><div class="loader-spiner"></div></div></div>';
  html += '<div class="spiner-holder-one animate-50-75-a"><div class="spiner-holder-two animate-50-75-b"><div class="loader-spiner"></div></div></div>';
  html += '<div class="spiner-holder-one animate-75-100-a"><div class="spiner-holder-two animate-75-100-b"><div class="loader-spiner"></div></div></div>';
  html += '</div>';

  $this.prepend(html);

  var setProgress = function(progress) {

    if (progress < 25) {
      angle = -90 + (progress / 100) * 360;

      $this.find('.animate-0-25-b').css('transform', 'rotate(' + angle + 'deg)');
    } else if (progress >= 25 && progress < 50) {
      angle = -90 + ((progress - 25) / 100) * 360;

      $this.find('.animate-0-25-b').css('transform', 'rotate(0deg)');
      $this.find('.animate-25-50-b').css('transform', 'rotate(' + angle + 'deg)');
    } else if (progress >= 50 && progress < 75) {
      angle = -90 + ((progress - 50) / 100) * 360;

      $this.find('.animate-25-50-b, .animate-0-25-b' ).css('transform', 'rotate(0deg)');
      $this.find('.animate-50-75-b').css('transform' , 'rotate(' + angle + 'deg)');
    } else if (progress >= 75 && progress <= 100) {
      angle = -90 + ((progress - 75) / 100) * 360;

      $this.find('.animate-50-75-b, .animate-25-50-b, .animate-0-25-b').css('transform', 'rotate(0deg)');
      $this.find('.animate-75-100-b').css('transform', 'rotate(' + angle + 'deg)');
    }

    $this.find('.text').html(progress + '%');
  }

  var clearProgress = function () {
    $this.find('.animate-75-100-b, .animate-50-75-b, .animate-25-50-b, .animate-0-25-b').css('transform', 'rotate(90deg)');
  }

  $this.one('inview', function () {
    for (var i = 0; i <= progress; i++) {
      (function(i) {
        setTimeout(function () {
          setProgress(i);
        }, i * 20);
      })(i);
    }
  });

});



// Alerts
// ---------------------------------------------------------
$('.alert').each(function () {

  var $this = $(this);

  $(this).find('.close').on('click', function (event) {
    event.preventDefault();

    $this.remove();
  });

});



// Responsive Videos
// ---------------------------------------------------------
if ($.fn.fitVids) {
  $('.fitvidsjs').fitVids();
}



// Our Partners Slider
// ---------------------------------------------------------
if ($.fn.flexslider) {
  $('.our-partners-slider').flexslider({
    pauseOnHover: true,
    controlNav: true,
    directionNav: false,
    slideshow: true,
    animationSpeed: 1000,
    animation: 'slide',
    animationLoop: false,
    itemWidth: 195,
    itemMargin: 0
  });
}




$('.project-list-tabs .tab-pane').each(function () {
  var $this = $(this);

  $this.children('.row').one('inview', function () {
   
   var $isotope;

   $this.children('.row').imagesLoaded( function(){
    $isotope = $this.children('.row').isotope({
        itemSelector: '.filter-item',
        containerStyle: null
      });
    });

    // var $isotope = $this.children('.row').isotope({
    //   itemSelector: '.filter-item',
    //   containerStyle: null
    // });

    $this.find('.filters a').on('click', function (event) {
      var $this = $(this);
      event.preventDefault();

      var filterValue = $this.attr('data-filter');
      $isotope.isotope({ filter: filterValue });

      $this.parent('li').addClass('active').siblings('li').removeClass('active');
    });
  });
});



// Header Home Slider
// ---------------------------------------------------------
$('.header-home-slider').find('.slides > li').each(function () {
  var $this = $(this),
    image = $this.data('image');

  $this.css('background-image', 'url(' + image + ')');
});

$('.header-home-slider').flexslider({
  pauseOnHover: true,
  pauseOnAction: true,
  controlNav: true,
  directionNav: false,
  slideshow: false,
  animationSpeed: 1000,
  animation: 'fade',
  animationLoop: false
});



// Twitter Feed Section
// ---------------------------------------------------------
if ($.fn.tweet) {
 $('.twitter-feed-section .tweets-container').each(function () {
  var $this = $(this),
      user = $this.data('user'),
      tweets = $this.data('tweets');

  $this.on('loaded', function () {
    if ($.fn.flexslider) {
      $this.flexslider({
        pauseOnHover: true,
        controlNav: false,
        directionNav: true,
        slideshow: true,
        animationSpeed: 500,
        animation: 'fade',
        animationLoop: false,
        selector: '.tweet_list > li',
        prevText: '&#xf106;',
        nextText: '&#xf107;',
        controlsContainer: $this.closest('.css-table')
      });
    }

    $this.parent().siblings('.twitter-logo').attr('href', '//twitter.com/' + user);

    $this.closest('.twitter-feed-section').removeClass('hide');
  });

  $this.tweet({
    username: user,
    modpath: './js/twitter/',
    count: tweets,
    loading_text: "Loading tweets...",
    template: "{text}{time}",
  });
 });
}

$('#wb-default-view').on('submit', function(e){
    e.preventDefault();
    
    var valid = valid_form();
    if(valid === false){
      	e.preventDefault();
      	e.stopPropagation();
        return false;
      }
    var formData = $(this).serialize();

//var formData = new FormData($(this)[0]);
    
    $.ajax({
       type: "POST", 
       url: ajax_object.ajaxurl,
       timeout: 3600000,
       data: {
            data_form: formData,
            dataType: 'json',
            action: "liveinews_default_view"
        },
       
       beforeSend: function(){ 
           $('#ajax-loader').show();
       },
       success: function( response ) {
           var resp = $.parseJSON(response);
            $('#ajax-loader').hide();
           if (resp.status == 'Success'){
               $('#message').html(resp.message);
               $('#message').show();
           }else{
               $('#message').html(resp.message);
               $('#message').show();
           }
           
           

       },
       
       
       }).fail(function ( data ) {
//       		
       });

    });
    
    $('#use_default_view').on('change', function(){
        if(this.checked) {
        
       $.ajax({
       type: "POST", 
       url: ajax_object.ajaxurl,
       timeout: 10000,
       data: {
            dataType: 'json',
            action: "liveinews_get_default_view"
        },
       
       beforeSend: function(){ 
           $('#use_default_ajax-loader').show();
       },
       success: function( response ) {
           console.log(response);
           var resp = $.parseJSON(response);
            $('#use_default_ajax-loader').hide();
           if (resp.status == 'success'){
               if(resp.name){
                   $('#title').val(resp.name + resp.datetime + '-' + resp.user_id);
               }else {
                   $('#title').val('video-news-' + resp.datetime + '-' + resp.user_id);
               }
               $('textarea[name=description]').html(resp.description);
               $('#category').val(resp['main-category']);
               $('#sub_category').attr('data-category-id', resp.category );
               $('#category').trigger('change');
               $('#add-location').val(resp.location);
               
               $('#use_default_message').html(resp.message);
               $('#use_default_message').show();
               console.log(resp);
           }else{
               $('#use_default_message').html(resp.message);
               $('#use_default_message').show();
           }
       },
       
       
       }).fail(function ( data ) {
       		console.log(data);
       });
       
       
        }
        
    });

    $('#view_settings').on('submit', function(e){
        e.preventDefault();

        // var valid = valid_form();
        // if(valid === false){
        //     e.preventDefault();
        //     e.stopPropagation();
        //     return false;
        // }
        var formData = $(this).serialize();

//var formData = new FormData($(this)[0]);

        $.ajax({
            type: "POST",
            url: ajax_object.ajaxurl,
            timeout: 3600000,
            data: {
                data_form: formData,
                dataType: 'json',
                action: "liveinews_view_settings"
            },

            beforeSend: function(){
                $('#ajax-loader').show();
            },
            success: function( response ) {
                var resp = $.parseJSON(response);
                $('#ajax-loader').hide();
                if (resp.status == 'Success'){
                    $('#message').html(resp.message);
                    $('#message').show();
                }else{
                    $('#message').html(resp.message);
                    $('#message').show();
                }



            },


        }).fail(function ( data ) {
//
        });

    });

    $('#view_settings_other_users').on('submit', function(e){
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: ajax_object.ajaxurl,
            timeout: 3600000,
            data: {
                data_form: formData,
                dataType: 'json',
                action: "liveinews_view_settings_other_users"
            },

            beforeSend: function(){
                $('#ajax-loader').show();
            },
            success: function( response ) {
                var resp = $.parseJSON(response);
                $('#ajax-loader').hide();
                if (resp.status == 'Success'){
                    $('#message').html(resp.message);
                    $('#message').show();
                }else{
                    $('#message').html(resp.message);
                    $('#message').show();
                }
            },
        }).fail(function ( data ) {
        });
    });


    
    $('#available').on('change', function(){
        
       var available_st;
       
       if (this.checked){
           available_st = 'available';
       }else{
           available_st = 'unavailable';
       }
       
       $.ajax({
       type: "POST", 
       url: ajax_object.ajaxurl,
       timeout: 10000,
       data: {
            dataType: 'json',
            action: "liveinews_set_available_status",
            available_status: available_st
        },
       
       beforeSend: function(){ 
           $('#available_ajax-loader').show();
       },
       success: function( response ) {
           var resp = $.parseJSON(response);
           
           $('#available_ajax-loader').hide();
            
           if (resp.status == 'success'){
               
               console.log(resp);
           }else{ // stay status if some errors
               if (available_st === 'available'){
                    $('#available').attr('checked', false); // Unchecks it
                }else{
                    $('#available').attr('checked', true); // checks it
                }
           }
       },
       
       
       }).fail(function ( data ) {
       		console.log(data);
                if ($('#available').checked){
                    $('#available').attr('checked', false); // Unchecks it
                }else{
                    $('#available').attr('checked', true); // Unchecks it
                }
       });
       
    });


}(jQuery));

jQuery(document).ready(function($){
    
   $('#category').trigger('change');
   $('#view_settings select.form-control').trigger('change');
   $('#view_settings_other_users select.form-control').trigger('change');

});
