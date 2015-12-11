var Site = {

	i18n: null,

	init: function(i18n) {
		Site.i18n = i18n['i18n'];
		Site.loading(false);
		$('a:not(.lightbox)').bind('click', function() {
			Site.loading(true);
		});
		Site.initLightbox();
	},

	trans: function(slug) {
		var _i18n = slug.toLowerCase().split('.');
		_i18n.shift();
		var value = Site.i18n;
		for (var i = 0; i < _i18n.length; i++) {
			value = value[_i18n[i]];
		};
		return value;
	},

	initLightbox: function() {
		$(".lightbox").fancybox({
			'padding': 		0,
			'tpl': {
        		closeBtn	: '<a title="" class="fancybox-item fancybox-close" href="javascript:;"><span>'+Site.i18n['lightbox']['action']['close']+'</span></a>',
        		next     	: '<a title="" class="fancybox-nav fancybox-next" href="javascript:;"><span>'+Site.i18n['lightbox']['action']['next']+'</span></a>',
				prev     	: '<a title="" class="fancybox-nav fancybox-prev" href="javascript:;"><span>'+Site.i18n['lightbox']['action']['prev']+'</span></a>'
    		},
    		'helpers':  {
		        title : {
		            type : 'over'
		        }
		    },
		    beforeLoad: function() {
		    	if ($(this.element).attr('data-caption-title').length>0) {
					this.title = '<span class="caption-title">'+$(this.element).attr('data-caption-title')+'</span>';	
		    	}
		    	if ($(this.element).attr('data-caption-legend').length>0) {
					this.title += '<span class="caption-legend"> - '+$(this.element).attr('data-caption-legend')+'</span>';	
		    	}
        	}
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
