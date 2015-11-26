var Site = {

	init: function() {
		Site.loading(false);
		$('a').bind('click', function() {
			Site.loading(true);
		})
	},

	loading: function(show) {

		if (show) {
			$('.overlay').fadeIn('fast');	
		} else {
			$('.overlay').fadeOut('fast');
		}
		 
	}


};
