(function ($) {
    "use strict";
       

    /* affix the navbar after scroll below header */
    function navStick ($) {
        if($('#nav').length){
            /* smooth scrolling for scroll to top */
            $('.scroll-top').click(function(){
                alert('asfaf');
              $('body,html').animate({scrollTop:100},1000);
            })
        };
    };

    $(window).scroll(function () {
        if ($(window).scrollTop() >= 1) {
            $(".navbar").addClass("affix");
        }else {
            $(".navbar").removeClass("affix");
        }
    });

    /* smooth scrolling for nav sections */
    $('#nav .navbar-nav li>a').click(function(){
      var link = $(this).attr('href');
      var posi = $(link).offset().top;
      $('body,html').animate({scrollTop:posi},700);
    });

    /* highlight the top nav as scrolling occurs */
    $('body').scrollspy({ target: '#nav', offset: 100})

    /* satisfied client */
    $(document).ready(function() {
      $("#logo").owlCarousel({
        navigation : false, // Show next and prev buttons
        slideSpeed : 100,
        paginationSpeed : 200,
        items : 3,
        responsive: true,
        autoPlay : true,
        responsive: true,
        itemsTablet: [768,2],
        itemsTabletSmall: false,
        itemsMobile : [479,1],
        singleItem : false,
        responsiveRefreshRate : 200,
        responsiveBaseWidth: window,
        pagination:false
      });
    });

    // wow activator
    function wowActivator () {
        new WOW().init();
    }

    /*=================================*/
    /* PRE LOADER  */
    /*=================================*/    
    $(window).load(function() {
        $('.loader').delay(100).fadeOut('slow');
        $('.preloader').delay(500).fadeOut('slow');
        $('body').delay(500).css({
            'overflow': 'visible'
        });
    })

    /* scroll top */
    $(".scroll-top").click(function(e){
        $("html, body").animate({ scrollTop: "0" }, 900 );
          return false;     
    });
    


    })(jQuery);


 /*=================================*/
    /* wow animations
    /*=================================*/

    var wow = new WOW(
            {
                boxClass:     'wow',      // animated element css class (default is wow)
                animateClass: 'animated', // animation css class (default is animated)
                offset:       100,          // distance to the element when triggering the animation (default is 0)
                mobile:       true,       // trigger animations on mobile devices (default is true)
                live:         true,       // act on asynchronously loaded content (default is true)
                callback:     function(box) {
                  // the callback is fired every time an animation is started
                  // the argument that is passed in is the DOM node being animated
                }
            }
        );
        wow.init();



