!function(a){"use strict";function b(){var b=h.clientHeight,c=a.innerHeight;return b<c?c:b}function c(){return a.pageYOffset||h.scrollTop}function d(a){var b=0,c=0;do isNaN(a.offsetTop)||(b+=a.offsetTop),isNaN(a.offsetLeft)||(c+=a.offsetLeft);while(a=a.offsetParent);return{top:b,left:c}}function e(a,e){var f=a.offsetHeight,g=c(),h=g+b(),i=d(a).top,j=i+f,e=e||0;return i+f*e<=h&&j-f*e>=g}function f(a,b){for(var c in b)b.hasOwnProperty(c)&&(a[c]=b[c]);return a}function g(a,b){this.el=a,this.options=f(this.defaults,b),this._init()}var h=a.document.documentElement;g.prototype={defaults:{minDuration:0,maxDuration:0,viewportFactor:0},_init:function(){this.items=Array.prototype.slice.call(document.querySelectorAll("#"+this.el.id+" > li")),this.itemsCount=this.items.length,this.itemsRenderedCount=0,this.didScroll=!1;var b=this;jQuery(b.el).waitForImages({waitForAll:!0,finished:function(){return new Isotope(b.el,{itemSelector:"li",transitionDuration:0}),b.items.forEach(function(a,c){e(a)&&(b._checkTotalRendered(),jQuery(a).addClass("shown"))}),a.addEventListener("scroll",function(){b._onScrollFn()},!1),a.addEventListener("resize",function(){b._resizeHandler()},!1)}})},_onScrollFn:function(){var a=this;this.didScroll||(this.didScroll=!0,setTimeout(function(){a._scrollPage()},60))},_scrollPage:function(){var a=this;this.items.forEach(function(d,f){jQuery(d).hasClass("shown")||jQuery(d).hasClass("animate")||!e(d,a.options.viewportFactor)||setTimeout(function(){var e=c()+b()/2;if(a.el.style.WebkitPerspectiveOrigin="50% "+e+"px",a.el.style.MozPerspectiveOrigin="50% "+e+"px",a.el.style.perspectiveOrigin="50% "+e+"px",a._checkTotalRendered(),a.options.minDuration&&a.options.maxDuration){var f=Math.random()*(a.options.maxDuration-a.options.minDuration)+a.options.minDuration+"s";d.style.WebkitAnimationDuration=f,d.style.MozAnimationDuration=f,d.style.animationDuration=f}jQuery(d).addClass("animate")},25)}),this.didScroll=!1},_resizeHandler:function(){function a(){b._scrollPage(),b.resizeTimeout=null}var b=this;this.resizeTimeout&&clearTimeout(this.resizeTimeout),this.resizeTimeout=setTimeout(a,1e3)},_checkTotalRendered:function(){++this.itemsRenderedCount,this.itemsRenderedCount===this.itemsCount&&a.removeEventListener("scroll",this._onScrollFn)}},a.AnimOnScroll=g}(window);