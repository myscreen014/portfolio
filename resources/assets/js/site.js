var Site = {

	_i18n: null,

	init: function(i18n) {
		Site._i18n = i18n['i18n'];
		Site.loading(false);
		$('a:not(.lightbox):not(.noloading):not(.wysiwyg a)').bind('click', function() {
			Site.loading(true);
		});
		Site.initLightbox(); 
 
		/* Mobile navigation */
		$('#nav-close-action').bind('click', function(event) {
			$('html').removeClass('open-nav');
			event.preventDefault;
			return false;
		});
		$('#nav-open-action').bind('click', function(event) {
			$('html').addClass('open-nav');
			event.preventDefault;
			return false;
		});

		if (Modernizr.touch || 'ontouchstart' in window) { 
   	 		$('html').addClass('touch');
		}
		
	},

	initLightbox: function() {
		$( '.lightbox' ).swipebox( {
			useCSS : true, // false will force the use of jQuery for animations
			useSVG : true, // false to force the use of png for buttons
			initialIndexOnArray : 0, // which image index to init when a array is passed
			hideCloseButtonOnMobile : false, // true will hide the close button on mobile devices
			hideBarsDelay : 3000, // delay before hiding bars on desktop
			videoMaxWidth : 1140, // videos max width
			beforeOpen: function() {}, // called before opening
			afterOpen: null, // called after opening
			afterClose: function() {}, // called after closing
			loopAtEnd: false // true will return to the first image after the last image is reached
		});
	},

	loading: function(show) {

		if (show) {
			$('.overlay.loading').fadeIn('fast');	
		} else {
			$('.overlay.loading').fadeOut('slow');
		}
		 
	}


};
