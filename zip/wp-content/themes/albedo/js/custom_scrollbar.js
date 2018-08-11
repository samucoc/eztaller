(function($){

  // enable custom scrollbar

  var $body = $("body"),
  isIE11 = isIE10 = false;

  isIE11 = !!window.MSInputMethodContext && !!document.documentMode;
  /*@cc_on
    if (/^10/.test(@_jscript_version)) {
      self.isIE10 = true;
    }
  @*/

  if( isIE11 || isIE10 ) {

  } else {
    $body.niceScroll({
      cursorwidth: 4,
      cursoropacitymin: 0.4,
      cursorcolor: '#60696e',
      cursorborder: 'none',
      cursorborderradius: 2,
      autohidemode: 'leave'
    });

    // resize NiceScroll on AJAX content
    $( document ).ajaxComplete(function() {
      $body.getNiceScroll().resize();
      $body.waitForImages({
				waitForAll: true,
				finished: function() {
          $body.getNiceScroll().resize();
        }
      });
    });

    // on window resize
    $(window).on('resize', function(){
      $body.getNiceScroll().resize();
    });

  }

})( window.jQuery );
