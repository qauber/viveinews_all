jQuery(document).ready(function($){

    $( "span.menu" ).click(function() {
            $( "ul.nav1" ).slideToggle( 300, function() {
            // Animation complete.
             });
    });
    
    

      $(document).ready(function(){
        $(".bar1 .bar").progress();
        $(".bar1 .bar2").progress();
        $(".bar1 .bar3").progress();
        
        $(".swipebox").swipebox();
        
      });
      
    
    $("#post-carousel").owlCarousel({
        navigation: true,
        navigationText: [
          "<i class='icon-chevron-left icon-white'></i>",
          "<i class='icon-chevron-right icon-white'></i>"
          ],
        autoPlay: 3000, //Set AutoPlay to 3 seconds

        items : 6,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3]

    });
    $("#post-carousel-top").owlCarousel({
        navigation: true,
        navigationText: [
          "<i class='icon-chevron-left icon-white'></i>",
          "<i class='icon-chevron-right icon-white'></i>"
          ],
        autoPlay: 3000, //Set AutoPlay to 3 seconds

        items : 6,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3]

    });

      $('#myTabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      });
      
      var date = new Date();
      
      setCookie ('UserActive', date.getTime(), new Date(date.valueOf() + 1000*1800*24), '/');



});

(function ( $ ) {
    $.fn.progress = function() {
          var percent = this.data("percent");
          this.css("width", percent+"%");
    };
  }( jQuery ));
  
  
  function edit_product(id_product){
    //alert('function in development');
    location.replace("/my-video-edit/?edit="+id_product);
 }
 
 
    function d(el) {
       return document.getElementById(el);
   }
   ifvisible.setIdleDuration(5);

   ifvisible.on('statusChanged', function (e) {
      console.log('status changed');
   });

   ifvisible.idle(function () {
       var userActive = getCookie('UserActive');
       setCookie ('UserActive', date.getTime(), new Date(date.valueOf() + 1000*1800*24), '/');
       
       
       
       console.log(userActive);
       console.log('Idle');
   });

   ifvisible.wakeup(function () {
       console.log('wakeup');
   });

   ifvisible.onEvery(0.5, function () {
       // Clock, as simple as it gets
       
   });
   
function setCookie (name, value, expires, path, domain, secure) {
      document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

function getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}