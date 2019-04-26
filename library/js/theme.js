
 (function($){   //Declare jQuery NameSpace

   $(window).scroll(function(){
    if ($(this).scrollTop() > 150) {
      $('.scrollup').fadeIn('slow');
      } else {
      $('.scrollup').fadeOut('slow');
  }
    }); 
      // function for scroll to top link to scroll to top
      $('.scrollup').click(function(){
      $("html, body").animate({ scrollTop: 0 }, 600);
      return false;
     });

   // enables Nivo on links   
     $(document).ready(function(){
      $('a.nivo').nivoLightbox({effect: 'fade' });
    });

    $(function () { // enable Boostrap popovers sitewide to any element with a data-toggle="popover" attribute
      $('[data-toggle="popover"]').popover()
    })

})(jQuery); //Close jQuery

// init wow.js to trigger animations
new WOW().init();