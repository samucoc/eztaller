(function($){

	"use strict";

	window.themeFrontCore = {

		/**
			Constructor
		**/
		initialize: function() {

			var self = this;

			$(document).ready(function(){
				self.build();
				self.events();
			});

		},
		/**
			Build page elements, plugins init
		**/
		build: function() {

			var self = this;

			// create a temp div for scrolling header
			$('body').append('<div id="albedo-theme-temp-header"></div>');

			// setup layout
			this.setupLayout();

			// fix ie bugs
			this.fixIE();

			// Setup body classes
			this.setupDocumentClasses();

			// setup custom CSS
			this.setupCustomCSS();

			// Setup Top Bar, Header and Menus
			this.setupTopBar();
			this.setupResponsiveHeader();
			this.setupHeaderScroll();

			$(window).resize(function() {
				self.setupTopBar();
				self.setupResponsiveHeader();
				self.setupHeaderScroll();
			});

			// setup menu
			this.initMenu();

			// One Page Menu
			this.initOnePageMenu();

			// lazy loading for images
			this.initLazyLoading();

			// page preloader
			this.initPreloader();

			// Load inline SVG
			this.loadSVG();

			// Setup parallax
			this.setupParallax();

			// Setup post formats
			this.setupPostFormats();

			// Comments
			this.setupComments();

			// Setup custom inputs
			this.setupInputForms();

			// Lazy YouTube videos
			this.setupVideos();

			// Contact form sender
			this.bindContactForm();

			// Widgets tweaks
			this.setupWidgets();

			// AJAX Search
			this.setupAJAXSearch();

			// Setup Footer
			this.setupFooter();

			// Setup WooCommerce
			this.setupWooCommerce();

			// Append hacks for bad brwsers
			this.initHacks();

		},
		/**
			Set page events
		**/
		events: function() {

			var self = this;

			// Skip section
			$('.skip-section-link').css('cursor', 'pointer').click( function() {

				var offset = $('#header-menu-wrapper').hasClass('scroll-menu') ? $(this).parents('.pb-section, .vc_row').next().offset().top - $('#header-menu-wrapper').outerHeight() : $(this).parents('.pb-section, .vc_row').next().offset().top - 20;

				$('html, body').animate({
					scrollTop: offset
				}, 800);

				return false;
			});

			// Submit a form
			$('.form-builder-submit').each( function() {

				$(this).on('click', function() {
					$(this).parents('form').submit();
					return false;
				});

			});

			// Post likes
			$('#content').on('click', '#like-post, .post-likes a', function() {

				var $elem = $(this),
				id = $elem.data('post-id');

				$elem.toggleClass( 'activated clicked' );

				var vote = $elem.hasClass('clicked');

				setTimeout( function() { $elem.removeClass( 'activated' ) }, 1000 );

				$.ajax({
					url: wprotoEngineVars.ajaxurl,
					type: "POST",
					data: {
						'action' : 'wplab_albedo_like_post',
						'post_id' : id,
						'vote' : vote
					},
					success: function( answer ) {

						if( vote == true ) {
							$.cookie( 'post_id_' + id + '_liked', vote, { path: '/', expires: 365 });
						} else {
							$.cookie( 'post_id_' + id + '_liked', null, { path: '/', expires: 365 });
						}

						$elem.find('span').html( answer );

					}
				});

				return false;
			});

			// AJAX pagination
			$('.ajax-pagination-link').click( function() {
				var $link = $(this);
				if( $link.attr('disabled') == 'disabled' ) return false;

				var targetId = $link.data('target-id');
				var $target = $( targetId );
				var data = $link.data();
				var action = $link.data('action');

				$.ajax({
					url: wprotoEngineVars.ajaxurl,
					type: "POST",
					dataType : 'json',
					data: {
						'action' : action,
						'data' : data
					},
					beforeSend: function() {
						$link.attr('disabled', 'disabled').addClass('active');
						$target.fadeTo( 200, '0.5' );
					},
					success: function( response ) {

						$link.data( 'current-page', response.current_page );
						$link.data( 'next-page', response.next_page );

						if( response.next_page > $link.data('max-pages') || self.stringToBoolean( response.hide_link ) ) {
							$link.parents('.ajax-pagination').remove();
						}

						if( response.html ) {

							$target.append( response.html );

							self.setupPostFormats();
							self.setupVideos();
							//self.setupLightbox();

							// re-load added lazy images
							self.bLazy.revalidate();

							self.loadSVG();

						}

						$link.removeAttr('disabled').removeClass('active');
						$target.fadeTo( 200, '1' );

					}
				});

				return false;
			});

			// Demo stand
			$('#demo-panel .open-close').click( function() {
				$('body, #demo-panel, #demo-overlay').toggleClass('demo-panel-opened');
			});
			$('#demo-panel .demos a').hover( function() {
				$('#demo-panel .demos a').addClass('fade');
				$(this).addClass('current');
			}, function() {
				$('#demo-panel .demos a').removeClass('fade');
				$(this).removeClass('current');
			});
			$('#demo-overlay').click( function() {
				$('body, #demo-panel, #demo-overlay').removeClass('demo-panel-opened');
			});

		},
		/**************************************************************************************************************************************************/
		/** setup layout **/
		setupLayout: function() {
			if( $('body').hasClass('sidebar-left_right') ) {

				if( $(window).width() <= 995 ) {
					$("#sidebar").before($("#content"));
				} else {
					$("#content").before($("#sidebar"));
				}

			}
		},
		/** init preloader **/
		initPreloader: function() {

			var self = this;

			// Close preloader
			$(window).load(function() {

				if( $('body.preloader').length ) {

					$('body').waitForImages({
						waitForAll: true,
						finished: function() {

							$('#preloader').fadeOut( 1200, function() {
								$('body.preloader').removeClass('preloader');
								$(this).remove();
								$('#wrap').css('opacity', '1');
								// Setup animations
								self.setupAnimations();
							});

							setTimeout( function() {
								$('#demo-panel .buttons').css('left', '-50px');
							}, 3000 );

						}
					});

					if( self.isIE ) {
						$('#preloader').remove();
						$('#wrap').css('opacity', '1');
						$('body').removeClass('preloader');
						self.setupAnimations();
					}

				} else {

					self.setupAnimations();

					setTimeout( function() {
						$('#demo-panel .buttons').css('left', '-50px');
					}, 3000 );

				}
			});

		},
		/** fix IE bugs **/
		fixIE: function() {
			$('iframe').each(function() {
				var url = $(this).attr("src");
				if( typeof url !== typeof undefined && url !== false ) {

					if (url.indexOf("?") > 0) {
						$(this).attr({
							"src" : url + "&wmode=transparent",
							"wmode" : "opaque"
						});
					} else {
						$(this).attr({
							"src" : url + "?wmode=transparent",
							"wmode" : "opaque"
						});
					}

				}
			});
		},
		/** setup documents classes **/
		setupDocumentClasses: function() {

			var self = this;

			$('html').removeClass('no-js');

			// Detect mobile browser
			if( (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) || (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.platform)) ) {
				$('html').addClass('mobile');
			}

			// Detect MAC
			if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Mac') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
				$('html').addClass('mac');
			}

			// Detect IE
			self.isIE = document.documentMode || /Edge/.test(navigator.userAgent);
			self.isIE11 = !!window.MSInputMethodContext && !!document.documentMode;
			self.isIE10 = false;
			/*@cc_on
				if (/^10/.test(@_jscript_version)) {
					self.isIE10 = true;
				}
			@*/
			if( self.isIE ) {
				$('body').addClass('ie');
				if( self.isIE11 ) {
					$('body').addClass('ie11');
				} else if( self.isIE10 ) {
					$('body').addClass('ie10');
				}
			}

			// fix menu bug
			if( $('body').hasClass('single-docs') ) {
				$('li.menu-item-object-docs').addClass('current-menu-item');
			}

		},
		/** custom CSS for theme elements **/
		setupCustomCSS: function() {

			$('*[data-custom-css]').not('.albedo-custom-css-added').each( function() {
				var $elem = $(this);
				$('head').append('<!-- auto generated custom css by element / shortcode --><style type="text/css" id="albedo-custom-css-id-' + $elem.attr('id') + '">' + $(this).data('custom-css') + '</style>');
				$elem.addClass('albedo-custom-css-added')
			});

		},
		/** setup Top Bar **/
		setupTopBar: function() {

			var self = this,
			$topBar = $('#top-bar'),
			$topBars = $('.top-bar'),
			$wpAdminBar = $('#wpadminbar'),
			$tempDiv = $('#albedo-theme-temp-header'),
			topBarScrollEnabled = $topBar.hasClass('sticky'),
			wpAdminBarHeight = $wpAdminBar.length ? $wpAdminBar.outerHeight() : 0,
			windowWidth = $(window).width(),
			responsiveBreak = parseInt( $topBar.data('responsive') );

			// if responsive
			if( windowWidth <= responsiveBreak ) {
				$topBars.addClass( 'responsive');
			} else {
				$topBars.removeClass( 'responsive');
			}

			// clone top bar
			if( topBarScrollEnabled && ! $('#top-bar-clone').length ) {
				var $topBarCloned = $topBar.clone();
				$topBarCloned.attr('id', 'top-bar-clone').addClass('menu-item-cloned').appendTo( $tempDiv );
			}

			var $topBarCloned = $('#top-bar-clone');

			// hide on mobiles if needed
			if( $topBar.hasClass('mobile-hidden') && windowWidth <= responsiveBreak ) {
				$topBar.hide();
				$topBarCloned.hide();
			} else {
				$topBar.show();
			}

			// on scroll
			$(window).scroll( function() {
				var scrollOffset = $(window).scrollTop();

				if( topBarScrollEnabled && windowWidth > 600 ) {
					$topBarCloned.css({ 'position' : 'fixed', 'left' : 0, 'right' : 0});

					if( windowWidth > responsiveBreak ) {
						$topBarCloned.css({ 'top' : wpAdminBarHeight, 'display' : 'block' });
					} else if( windowWidth <= responsiveBreak && $topBar.hasClass('mobile-sticky-off') ) {
						$topBarCloned.hide();
					} else {
						$topBarCloned.css({ 'top' : wpAdminBarHeight, 'display' : 'block' });
					}

				} else if( topBarScrollEnabled && windowWidth < 600 ) {
					$topBarCloned.css({ 'position' : 'fixed', 'left' : 0, 'right' : 0});

					if( scrollOffset > wpAdminBarHeight && ! $topBar.hasClass('mobile-sticky-off') ) {
						$topBarCloned.css({ 'top' : 0, 'display' : 'block' });
					} else {
						$topBarCloned.hide();
					}

				}

				// hide on mobiles if needed
				if( $topBar.hasClass('mobile-hidden') && windowWidth <= responsiveBreak ) {
					$topBar.hide();
					$topBarCloned.hide();
				} else {
					$topBar.show();
				}

			});

		},
		/** setup Header and Menus **/
		setupResponsiveHeader: function() {

			var $headerWrapper = $('.header-menu-wrapper');

			$headerWrapper.each( function() {
				var $elem = $(this),
				responsiveBreak = $elem.data( 'responsive'),
				screenWidth = $(window).width();

				// make header responsive
				if( screenWidth <= responsiveBreak ) {
					$elem.removeClass( 'responsive-mode-off').addClass( 'responsive-mode-on');
				} else {
					$elem.removeClass( 'responsive-mode-on').addClass( 'responsive-mode-off');
				}

			});

		},
		setupHeaderScroll: function() {

			// elements
			var $headerMenu = $('#header-menu'),
			$headerWrapper = $('#header-menu-wrapper'),
			$topBar = $('#top-bar'),
			$wpAdminBar = $('#wpadminbar'),
			$tempDiv = $('#albedo-theme-temp-header'),
			// properties
			topBarHeight = $topBar.length ? parseInt( $topBar.outerHeight() ) : 0,
			wpAdminBarHeight = $wpAdminBar.length ? parseInt( $wpAdminBar.outerHeight() ) : 0,
			wpAdminBarFixed = $wpAdminBar.length && $wpAdminBar.css('position') == 'fixed',

			menuNormalHeight = parseInt( $headerWrapper.data('menu-height') ),
			menuScrolledHeight = parseInt( $headerWrapper.data('menu-scrolled-height') ),

			menuScrollEnabled = $headerWrapper.hasClass( 'scroll-menu'),
			topBarScrollEnabled = $topBar.hasClass( 'sticky'),

			menuResponsiveBreak = $headerWrapper.data( 'responsive'),
			topBarResponsiveBreak = $topBar.data( 'responsive'),

			screenWidth = $(window).width(),
			menuScrollOffset = wpAdminBarFixed ? wpAdminBarHeight : 0,
			menuStickyTopPos = wpAdminBarFixed ? wpAdminBarHeight : 0;

			// get menu scroll offset
			if( $topBar.length && $topBar.hasClass( 'sticky') ) {

				if( screenWidth <= 600 && $topBar.hasClass('mobile-sticky-off') ) {
					menuScrollOffset = wpAdminBarHeight + topBarHeight;
					menuStickyTopPos = 0;
				} else if( screenWidth <= 600 && $topBar.hasClass('mobile-sticky-on') ) {
					menuScrollOffset = wpAdminBarHeight;
					menuStickyTopPos = topBarHeight;
				} else if ( screenWidth <= topBarResponsiveBreak && $topBar.hasClass('mobile-sticky-off') ) {
					menuScrollOffset = topBarHeight;
					menuStickyTopPos = wpAdminBarHeight;
				} else if ( screenWidth <= topBarResponsiveBreak && $topBar.hasClass('mobile-sticky-on') ) {
					menuScrollOffset = 0;
					menuStickyTopPos = topBarHeight + wpAdminBarHeight;
				} else if( screenWidth > topBarResponsiveBreak ) {
					menuScrollOffset = 0;
					menuStickyTopPos = wpAdminBarHeight + topBarHeight;
				}

			} else if( $topBar.length && $topBar.hasClass( 'normal') ) {
				menuScrollOffset = wpAdminBarFixed ? wpAdminBarHeight : 0,
				menuStickyTopPos = wpAdminBarFixed ? wpAdminBarHeight : 0;
			}

			if( screenWidth <= menuResponsiveBreak && $headerWrapper.hasClass('mobile-scroll-off') ) {
				menuScrollEnabled = false;
				$('#header-menu-wrapper-clone').remove();
			}

			// if scroll enabled
			if( menuScrollEnabled ) {

				// clone elements
				if( menuScrollEnabled && ! $('#header-menu-wrapper-clone').length ) {
					var $headerCloned = $headerWrapper.clone();
					$headerCloned.attr('id', 'header-menu-wrapper-clone').addClass('menu-item-cloned').appendTo( $tempDiv );
				}

				var $headerWrapperClone = $('#header-menu-wrapper-clone'),
				$headerMenuClone = $headerWrapperClone.find('.header-menu');

				$headerWrapperClone.css({ 'position' : 'fixed', 'left' : 0, 'right' : 0, 'top' : 0});

				$(window).scroll( function() {
					var scrollOffset = $(window).scrollTop();

					if( scrollOffset > menuScrollOffset ) {

						$headerMenuClone.css('height', menuScrolledHeight );
						$headerWrapperClone.css({ 'top': menuStickyTopPos, 'display' : 'block' }).addClass('scrolled');
						$headerWrapper.css('opacity', '0');

					} else {

						$headerMenuClone.css('height', menuNormalHeight );
						$headerWrapperClone.removeClass('scrolled').hide();
						$headerWrapper.css('opacity', '1');

					}

				});

			}

		},
		/** setup menu **/
		initMenu: function() {

			var self = this;

			// Primary / mobile menu toggler
			$('.menu-item-has-children').append('<a href="javascript:;" class="mobile-submenu-toggler"></a>');

			$('.mobile-submenu-toggler').click( function() {
				$(this).toggleClass('open');
				$(this).parent().find('.sub-menu:first, .mega-menu:first').not('.mega-menu-row').toggle('fast');
				return false;
			});

			$('body').on( 'click', '.menu-toggler', function() {

				var $link = $(this),
				isOverlayMenu = $link.parents('.header-menu').hasClass('minimal-overlay-menu');

				$link.toggleClass('open');

				if( isOverlayMenu ) {
					$('body').addClass('minimal-overlay-menu');
					$('#side-minimal-menu').toggleClass('open');
				} else {
					$('.menu-layout-item').toggleClass('open');
				}

				return false;
			});

			$(document).mouseup(function (e) {
				var $menuElems = $('.menu-layout-item, .menu-toggler, .menu-search-toggle, .header-menu .item-search .widget-holder, .header-cart-toggle, .header-menu .item-cart .widget-holder');

				if (!$menuElems.is(e.target) && $menuElems.has(e.target).length === 0) {
					$menuElems.removeClass('open');
				}

				var $sideMenuElemes = $('.side-overlay-toggle, #side-overlay-menu .widget-holder, #side-minimal-menu .side-menu-content');
				if (!$sideMenuElemes.is(e.target) && $sideMenuElemes.has(e.target).length === 0) {
					$('body').removeClass('side-overlay-menu').removeClass('minimal-overlay-menu');
					$sideMenuElemes.removeClass('open');
				}

			});

			// Menu search widget
			$('.menu-search-toggle').click( function() {
				var $this = $(this);
				$this.toggleClass('open');
				$this.next('.widget-holder').toggleClass('open');
				setTimeout( function() {
					$this.next('.widget-holder').find('input').focus();
				}, 350);
				return false;
			});

			// Header cart widget
			$('.header-cart-toggle').click( function() {
				var $this = $(this);
				$this.toggleClass('open');
				$this.next('.widget-holder').toggleClass('open');
				return false;
			});

			// Side menu toggler
			$('.side-overlay-toggle').click( function() {
				$(this).toggleClass('open');
				$('body').toggleClass('side-overlay-menu');
				self.bLazy.revalidate();
				return false;
			});

		},
		/** One Page Menu **/
		initOnePageMenu: function() {

			if( $('body').hasClass('one-page-navigation') ) {

				// on menu link click
				$('.header-menu a').click( function() {

					var $link = $(this),
					url = $link.attr('href');

					// is one page link
					if( url.indexOf( '#!/') !== -1 ) {

						var linkParts = url.split('#!/'),
						sectionID = linkParts[1],
						$section = $('#' + sectionID );

						if( $section.length ) {

							$('html, body').animate({
								scrollTop: parseInt( $section.offset().top - wprotoEngineVars.onepageScrollOffeset )
							}, 800, function(){
								$('.header-menu li').removeClass('current-menu-item');
								var menuId = $link.parent().attr('id'),
								menuIdNum = parseInt( menuId.match(/\d+$/)[0] );
								$('.header-menu li.menu-item-' + menuIdNum).addClass('current-menu-item');
								//$link.parent().addClass('current-menu-item');

								// Add hash (#) to URL when done scrolling (default click behavior)
								window.location.hash = '#!/' + sectionID;
							});

							return false;

						}

					}

				});

				var hash = window.location.hash;
				// if page URL contains one-page hash
				if( hash.indexOf( '#!/') !== -1 ) {

					var linkParts = hash.split('#!/'),
					sectionID = linkParts[1],
					$section = $('#' + sectionID );

					if( $section.length ) {

						setTimeout( function() {

							$('html, body').animate({
								scrollTop: parseInt( $section.offset().top - wprotoEngineVars.onepageScrollOffeset )
							}, 800, function(){

								$('.header-menu li').removeClass('current-menu-item');

								$('.header-menu a').each(function() {

									if( $(this).attr('href').indexOf( hash ) !== -1 ) {
										$(this).parent().addClass('current-menu-item');
									}

								});

								// Add hash (#) to URL when done scrolling (default click behavior)
								window.location.hash = '#!/' + sectionID;

							});

						}, 1000);

						return false;

					}

				}

			}

		},
		/** lazy loading **/
		initLazyLoading: function() {

			var self = this;

			self.bLazy = new Blazy({
				loadInvisible: true,
				src: 'data-lazy-src',
				success: function( element ){

					if( self.isIE ) {
						setTimeout(function() {
							$masonry.isotope('layout');
						}, 500);
					}

					$(element).parent().addClass('blazy-loaded');

				}
			});

		},
		/** animations **/
		setupAnimations: function() {

			var self = this;

			if( $('body').hasClass('anim-on') ) {

				var animMobile = $('body').hasClass('anim-mobile-on');

					var wow = new WOW({
					boxClass:     'wow',
					animateClass: 'animated',
					offset:       0,
					mobile:       animMobile,
					live:         true,
					callback:     function( box ) {

						var $box = $(box);

						if( $box.hasClass('animationProgressBar') ) {
							var w = $box.data('width');
							$box.width( w );
						} else if( $box.hasClass('animationNuminate') ) {
							$box.each( function() {
								var $item = $(this),
								to = $item.data('to');

								$item.numinate({ format: '%counter%', from: 1, to: to, runningInterval: 2000, stepUnit: 5});
							});
						} else if( $box.hasClass('typed') ) {
							$box.each( function() {
								var $item = $(this),
								speed = $item.data('typed-speed'),
								delay = $item.data('typed-delay'),
								text = $item.html();

								$item.html('').typed({
									strings: [text],
									typeSpeed: speed,
									contentType: 'html',
									showCursor: false,
									startDelay: delay,
									callback: function() {
										$item.addClass('typed-ended');
									}
								});
							});

						} else if( $box.hasClass('odometer') ) {

							$box.each( function() {

								$(this).text( $(this).data('to') );

							});

						}
					}

				});

				wow.init();

				if( self.isMobile && !animMobile ) {
					self.animRollback();
				}

			} else {

				self.animRollback();

			}

			if( $('.skrollr').length ) {
				window.wplab_albedo_skrollr = skrollr.init({forceHeight: false});
				if (window.wplab_albedo_skrollr.isMobile()) {
					window.wplab_albedo_skrollr.destroy();
				}
			}

		},
		/** rollback for animations **/
		animRollback: function() {
			$('.wow, .typed').css('opacity', '1');

			$('.animationNuminate').each( function() {
				$(this).html( $(this).data('to') );
			});

			$('.animationProgressBar').each( function() {
				var w = $(this).data('width');
				$(this).width( w );
			});

			$('.odometer').each( function() {
				$(this).text( $(this).data('to') );
			});

		},
		/** load inline SVG **/
		loadSVG: function() {

				$('img.image-svg').each(function(){
					var $img = $(this),
					imgID = $img.attr('id'),
					imgClass = $img.attr('class'),
					imgURL = $img.attr('src'),
					$imgParent = $img.parent(),
					imgParentId = $imgParent.attr('id'),
					customColor = $imgParent.data('svg-color'),
					extension = imgURL.replace(/^.*\./, '');

					extension = extension.toLowerCase();

					if( extension == 'svg' ) {

							$.get(imgURL, function(data) {
									// Get the SVG tag, ignore the rest
									var $svg = $(data).find('svg');

									// Add replaced image's ID to the new SVG
									if(typeof imgID !== undefined) {
										$svg = $svg.attr('id', imgID);
									}

									// Add replaced image's classes to the new SVG
									if(typeof imgClass !== undefined) {
										$svg = $svg.attr('class', imgClass+' replaced-svg');
									}

									// Remove any invalid XML tags as per http://validator.w3.org
									$svg = $svg.removeAttr('xmlns:a');

									// Check if the viewport is set, else we gonna set it if we can.
									if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
										$svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'));
									}

									// Colorify
									if( customColor !== undefined ) {
										$imgParent.append('<style>#' + imgParentId + ' svg path, #' + imgParentId + ' svg rect, #' + imgParentId + ' svg polygon { fill: ' + customColor + '}</style>');
									}

									// Replace image with new SVG
									$img.replaceWith($svg);

							}, 'xml');

					}

				});

		},
		/** setup parallax **/
		setupParallax: function() {

			$('.prev-next-posts-wrapper.style-thumb_title .parallax-scene, .wrapper404 .parallax-scene').each( function() {
				$(this).parallax({
					invertX: false,
					invertY: false
				});
			});

		},
		/** add some styles to post formats **/
		setupPostFormats: function() {

			// Select first word of every paragraph in post format chat
			$('article.format-chat .content-text-wrapper p').each( function(){
				var text_splited = $(this).text().split(" ");
				$(this).html("<strong>"+text_splited.shift()+"</strong> "+text_splited.join(" "));
			});

			//$('article iframe').wrap('<div class="iframe=wrapper"></div>');

			$('article, li.article').fitVids();

			// gallery post format
			$('.single .post-gallery-carousel').each( function() {

				// vars
				var $elem = $(this),
				id = $elem.attr('id'),
				options = {
					pagination: '#' + id + ' .swiper-pagination',
					paginationClickable: true,
					spaceBetween: 40,
					autoHeight: true,
					centeredSlides: true,
					coverflow: {
						slideShadows: false
					},
					flip: {
						slideShadows: false
					},
					cube: {
						slideShadows: false,
						shadow: false
					},
					fade: {
						crossFade: true
					}
				};

				// autoplay
				$.extend(options, { autoplay: $elem.data('autoplay') });
				$.extend(options, { autoplayStopOnLast: window.themeFrontCore.stringToBoolean($elem.data('autoplay-stop-on-last')) });
				$.extend(options, { autoplayDisableOnInteraction: window.themeFrontCore.stringToBoolean($elem.data('autoplay-disable-on-interaction')) });

				var slidesPerView = $elem.data('slides-per-view');

				if( slidesPerView !== '' ) {

					// slides per view
					$.extend(options, {
						slidesPerView: slidesPerView,
						breakpoints: {
							992: {
								slidesPerView: $elem.data('slides-per-view-medium'),
							},
							767: {
								slidesPerView: $elem.data('slides-per-view-small'),
								autoHeight: true
							}
						}
					});

					// initial slide
					$.extend(options, { initialSlide: $elem.data('initial-slide') });

				} else {
					// slider effect
					var effect = $elem.data('effect');
					$.extend(options, { effect: effect } );
					$elem.addClass('slider-effect-' + effect );
					// loop
					$.extend(options, { loop: window.themeFrontCore.stringToBoolean( $elem.data('loop') ) });
				}

				// run the swiper
				setTimeout( function() {
					var swiper = new Swiper('#' + id + ' .swiper-container', options );
				}, 800);

			});

		},
		/** style comments **/
		setupComments: function() {

			$('#comments.with-avatars ul.children').prev('.comment-body').addClass('has-children');
			$('#comments.with-avatars .has-children').parent().addClass('comments-thread-expanded');

		},
		/** custom inputs in forms **/
		setupInputForms: function() {

			if( $('body').hasClass('no-custom-input') == false ) {
				// Custom Selectbox
				$("select").dropdown({
					mobile: true
				});

				// Custom checkbox
				$("input[type=radio], input[type=checkbox]").checkbox().change(function() {
					var $input = $(this);
					if( $input.is('[onclick]') ) {
						setTimeout( function() {
							$input.click();
						}, 100 );
					}
				});
			}

			$('.form-builder-item').each( function() {
				var $elem = $(this),
				$label = $elem.find('label');

				$label.find('sup').remove();

				if( $.trim( $label.text()) == "" ) {
					$label.remove();
				}
			});

		},
		/** lazy YouTube videos **/
		setupVideos: function() {

			$('body.single article.format-video iframe').each( function() {
				$(this).parents('p').addClass('responsive-video-contaner');
			});

		},
		/** send a contact form **/
		bindContactForm: function() {

			if( window.fwForm ) {

					fwForm.initAjaxSubmit({
						selector: 'form.fw_form_fw_form',
						onErrors: function( elements, data ) {

						// Frontend
						jQuery.each(data.errors, function (inputName, message) {
							message = '<p class="form-error">{message}</p>'
								.replace('{message}', message);

							var $input = elements.$form.find('[name="' + inputName + '"]').last();

							if (!$input.length) {
								// maybe input name has array format, try to find by prefix: name[
								$input = elements.$form.find('[name^="'+ inputName +'["]').last();
							}

							if ($input.length) {
								// error message under input
								$input.parents('.form-builder-item').append(message);
							} else {
								// if input not found, show message in form
								elements.$form.prepend(message);
							}
						});

						if (typeof Recaptcha != 'undefined') Recaptcha.reload();
						if (typeof grecaptcha != 'undefined') grecaptcha.reset();

					},
					onSuccess: function (elements, ajaxData) {
						if ( $('body').hasClass('wp-admin') ) {
							fwForm.backend.showFlashMessages(
								fwForm.backend.renderFlashMessages(ajaxData.flash_messages)
							);
						} else {
							var html = fwForm.frontend.renderFlashMessages(ajaxData.flash_messages);

							if (!html.length) {
								html = '<p>Success</p>';
							}

							elements.$form.fadeOut(function(){
								elements.$form.html(html).fadeIn();
							});

							// prevent multiple submit
							elements.$form.on('submit', function(e){ e.preventDefault(); e.stopPropagation(); });

							var redirectURL = $.trim( elements.$form.parent().data('redirect-url') );
							if( redirectURL != '' ) {
								window.location = redirectURL;
							}
						}
					},
					loading: function( elements, show ) {
						// do nothing
					}
				});

			}

		},
		/** some tweaks for widgets **/
		setupWidgets: function() {

			var self = this;

			/**
				Style tweak for MailChimp widget
			**/
			$('.widget_mc4wp_form_widget').each( function() {

				$(this).find('input[type=submit]').wrap('<span class="submit-wrapper"></span>');

			});

			$('.aside').each( function() {

				if( $( this ).hasClass( 'scroll-last-widget') ) {
					self.checkStickyWidget( $('.aside .widget:last-of-type') );
					$(window).scroll(function() {
						self.checkStickyWidget( $('.aside .widget:last-of-type') );
					});
					$(window).resize(function() {
						self.checkStickyWidget( $('.aside .widget:last-of-type') );
					});
				}

			});

		},
		setupAJAXSearch: function() {

			var $ajaxForms = $('.ajax-search-form');
			if( $ajaxForms.length ) {

				$ajaxForms.each( function() {
					var $input = $(this).find('input[name=s]');
					$input.devbridgeAutocomplete({
						serviceUrl: wprotoEngineVars.ajaxurl,
						type: 'POST',
						noCache: true,
						dataType: 'json',
						minChars: $input.data('min-chars'),
						showNoSuggestionNotice: true,
						noSuggestionNotice: wprotoEngineVars.ajaxNoResults,
						groupBy: 'category',
						params: {
							'action' : 'wplab_albedo_ajax_search'
						},
						onSearchStart: function( query) {
							$input.addClass('in-ajax-progress');
						},
						onSearchComplete: function ( query, suggestions ) {
							$input.removeClass('in-ajax-progress');
						},
						onSelect: function( suggestion) {
							window.location = suggestion.data.link;
						}
					});
				});

			}

		},
		/** setup footer **/
		setupFooter: function() {

			$('#gotop, .gotop-link').click( function() {
				$("html, body").animate({ scrollTop: 0 }, "slow");
				return false;
			});

		},
		/** setup WooCommerce **/
		setupWooCommerce: function() {

			// WooCommerce update variations
			$('.single-product').on( 'click', '.reset_variations', function() {
				$('.variations select').dropdown("update");
			});

		},
		/** init hacks for bad browsers **/
		initHacks: function() {

			// fix WeDocs print
			$('.wedocs-print-article').off('click').on('click', function() {
				window.print();
				return false;
			})

		},
		/** check for sticky widget **/
		checkStickyWidget: function( $elem ) {

			if( $(window).width() < 992 ) {
				$elem.trigger("sticky_kit:detach");
				$elem.parent('aside').css('min-height', '1px');
			} else {

				$elem.parent('aside').css( 'min-height', $('#content').height() + 'px' );
				$elem.stick_in_parent({
					recalc_every: 1,
					offset_top: parseInt( wprotoEngineVars.scrollLastWidgetOffset )
				});

			}

		},
		/**************************************************************************************************************************
			Utils
		**************************************************************************************************************************/
		/**
			Check for mobile device
		**/
		isMobile: function() {
			return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test( navigator.userAgent );
		},
		/**
			Check email address
		**/
		isValidEmailAddress: function( emailAddress ) {
			var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
			return pattern.test( emailAddress );
		},
		preloadImages: function(arrayOfImages) {
			$(arrayOfImages).each(function(){
					$('<img/>')[0].src = this;
			});
		},
		createPreloaderDivs: function( n ) {
			var arr = [];
			var i = 0;
			for (i = 1; i <= n; i++) {
				arr.push('<div></div>');
			}
			return arr;
		},
		stringToBoolean: function(string){

			switch(string){
				case "true": case "yes": case "1": return true;
				case "false": case "no": case "0": case null: case '': return false;
				default: return Boolean(string);
			}

		}

	}

	window.themeFrontCore.initialize();

})( window.jQuery );
