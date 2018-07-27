"use strict";

(function($){

	var Core;
	(function (Core) {
		var Slider = (function () {
			function Slider() {
				// Durations
				this.durations = {
					auto: $('.photo-fullscreen-gallery').data('autoplay-time'),
					slide: $('html').hasClass('no-cssmask') ? 0 : $('.photo-fullscreen-gallery').data('slide-time')
				};
				// DOM
				this.dom = {
					wrapper: null,
					container: null,
					project: null,
					current: null,
					next: null,
					arrow: null,
					pagination: null
				};
				// Misc stuff
				this.length = 0;
				this.current = 0;
				this.next = 0;
				this.isAuto = true;
				this.working = false;
				this.dom.wrapper = $('.photo-fullscreen-gallery');
				this.dom.project = this.dom.wrapper.find('.photo');
				this.dom.arrows = this.dom.wrapper.find('.arrows');
				this.dom.arrow = this.dom.wrapper.find('.arrow');
				this.dom.arrowPrev = this.dom.wrapper.find('.arrow.previous');
				this.dom.arrowNext = this.dom.wrapper.find('.arrow.next');
				this.dom.pagination = this.dom.wrapper.find('.pagination-link');
				this.length = this.dom.project.length;
				this.init();
				this.events();
				this.auto = setInterval(this.updateNext.bind(this), this.durations.auto);
			}
			/**
			 * Set initial z-indexes & get current project
			 */
			Slider.prototype.init = function () {
				this.dom.project.css('z-index', 10);
				this.dom.current = $(this.dom.project[this.current]);
				this.dom.next = $(this.dom.project[this.current + 1]);
				this.dom.current.css('z-index', 30);
				this.dom.next.css('z-index', 20);
				this.dom.pagination.eq(0).addClass('current');
				this.dom.project.eq(0).addClass('current-slide');
				this.processThumbs();
			};
			Slider.prototype.clear = function () {
				this.dom.arrow.off('click');
				if (this.isAuto)
					clearInterval(this.auto);
			};
			/**
			 * Initialize events
			 */
			Slider.prototype.events = function () {
				var self = this;
				this.dom.arrow.on('click', function () {
					if (self.working)
						return;
					self.processBtn($(this));
					self.processThumbs();
				});
				this.dom.pagination.on('click', function () {
					if (self.working)
						return;
					self.processPagination($(this));
					self.processThumbs();
				});
			};
			Slider.prototype.processBtn = function (btn) {
				if (this.isAuto) {
					this.isAuto = false;
					clearInterval(this.auto);
				}
				if (btn.hasClass('next'))
					this.updateNext();
				if (btn.hasClass('previous'))
					this.updatePrevious();
			};
			Slider.prototype.processPagination = function (link) {
				if (this.isAuto) {
					this.isAuto = false;
					clearInterval(this.auto);
				}

				var index = this.dom.pagination.index( link );
				this.next = index % this.length;
				this.process();
			};
			Slider.prototype.processThumbs = function() {
				if( this.dom.arrows.hasClass('style-thumbs') ) {

					var prevIndex = this.next - 1,
					nextIndex = this.next + 1;

					if( prevIndex < 0 ) {
						prevIndex = this.length - 1;
					}

					if( nextIndex > this.length ) {
						nextIndex = (this.current + 1) % this.length;
					}

					this.dom.arrowPrev.css('background-image', $(this.dom.project[ prevIndex ]).css('background-image'));
					this.dom.arrowNext.css('background-image', $(this.dom.project[ nextIndex ]).css('background-image'));
				}
			};
			/**
			 * Update next global index
			 */
			Slider.prototype.updateNext = function () {
				this.next = (this.current + 1) % this.length;
				this.process();
			};
			/**
			 * Update next global index
			 */
			Slider.prototype.updatePrevious = function () {
				this.next--;
				if (this.next < 0)
					this.next = this.length - 1;
				this.process();
			};
			/**
			 * Process, calculate and switch beetween slides
			 */
			Slider.prototype.process = function () {
				var self = this;
				this.working = true;
				this.dom.next = $(this.dom.project[this.next]);
				this.dom.current.css('z-index', 30);
				self.dom.next.css('z-index', 20);
				// Hide current
				this.dom.current.addClass('move');
				this.dom.pagination.removeClass('current');
				this.dom.pagination.eq( this.next ).addClass('current');
				setTimeout(function () {
					self.dom.current.css('z-index', 10);
					self.dom.next.css('z-index', 30);
					self.dom.current.removeClass('move');
					self.dom.current = self.dom.next;
					self.dom.project.removeClass('current-slide');
					self.dom.current.addClass('current-slide');
					self.current = self.next;
					self.working = false;
				}, this.durations.slide);
			};
			return Slider;
		}());
		Core.Slider = Slider;
	})(Core || (Core = {}));

	window.albedo_portfolio_full_screen_photos_init = function() {
		$('.photo-fullscreen-gallery').waitForImages({
			waitForAll: true,
			finished: function() {
				new Core.Slider();
			}
		});
	}

	window.albedo_portfolio_full_screen_photos_init();

})( window.jQuery );
