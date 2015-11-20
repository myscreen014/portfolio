var Admin = {

	_config: Array(),

	init: function() {

		Admin.modelSortable();
	},

	configInit: function(config) {
		Admin._config = config;
	},

	configGet: function(key) {
		return Admin._config[key];
	},

	modelSortable: function() {
		var model = null;
		$('table.sortable').sortable({
      		items: "tr",   		
      		placeholder: "ui-state-highlight",  
      		tolerance: 'pointer',
      		containment: "parent",
      		create: function() {
      			model = $(this).attr('data-model');
      		},
    		stop: function(event, ui){
    			var itemsIds = Array();
    			var items = $(this).find('tbody tr');
    			for (var i = 0; i < items.length ; i++) {
    				itemsIds.push($(items[i]).attr('data-item-id'));
    			};
    			$.ajax({
	  				url: Admin.configGet('route_reorder'),
	  				method: 'POST',
	  				data: {
	  					'_token'  : Admin.configGet('csrf_token'),
	  					'model'	  : model,
	  					'itemsIds': itemsIds
	  				}
	  			});
    		}
    	});
	},

	addToSerializedField: function(element, value) {
		var cleanValues = [];
		var cleanValue = '';
		var newValue = '';
		
		if ( $('#'+element).val()=='' ) {
			newValue = ''+value; 	
		} else {
			newValue = $('#'+element).val()+','+value;
		} 
		var newValues = newValue.split(',');
		for (var i=0; i<newValues.length; ++i) {
			if (!Admin.inArray(newValues[i], cleanValues)) {
				cleanValues.push(newValues[i]);
			} 
		}
		$('#'+element).val(cleanValues.join(','));
		return cleanValues;
	},

	removeFromSerializedField: function(element, value) {
		if ($('#'+element).val()=='') return;
		var values = $('#'+element).val().split(',');
		var newValues = [];
		for (var i=0; i < values.length; ++i) {
			if (values[i]!=value) newValues.push(values[i]);
		}
		$('#'+element).val(newValues.join(','));
		return newValues;
	},

	inArray: function(needle, haystack) {
		var key = '';
		if (typeof haystack=='string') {
			haystack = haystack.split(',');
		}
		for (key in haystack) {
			if (haystack[key] == needle) {
				return true;
			}
		}
		return false;
	},	

}