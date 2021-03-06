var Admin = {

	_config: Array(),
	_i18n: null,

	init: function(config, i18n) {
		Admin._config = config;
		Admin._i18n = i18n['i18n'];
		Admin.modelSortable();
		Admin.modelPublishable();
	},

	configGet: function(key) {
		return Admin._config[key];
	},

	modelPublishable: function() {
		$('[data-toggle="tooltip"]').tooltip();
		var table = $('table.publishable');
		var model = $(table).attr('data-model');
		table.find('tr').each(function() {
			var itemTr = $(this);
			var itemId = $(itemTr).attr('data-item-id');
			$(this).find('.publish a').bind('click', function(event) {
				$.ajax({
	  				url: Admin.configGet('route_models_publish'),
	  				method: 'POST',
	  				data: {
	  					'_token'  : Admin.configGet('csrf_token'),
	  					'model'	  : model,
	  					'itemId'  : itemId
	  				}, 
	  				beforeSend: function() {
	  					var action = itemTr.find('.publish a');
	  					if (itemTr.hasClass('publish-0')) {
							itemTr.addClass('publish-1').removeClass('publish-0');
							action.attr('data-original-title', Admin._i18n['global']['label']['publish']).tooltip('fixTitle').tooltip('show');;
						} else {
							itemTr.addClass('publish-0').removeClass('publish-1');
							action.attr('data-original-title', Admin._i18n['global']['label']['draft']).tooltip('fixTitle').tooltip('show');;
						}
	  				},
	  				success: function(publish) {
	  					Admin.highlightTableTr(itemTr);
	  				},
	  				error: function() {
	  					Admin.Modal.alert(
	  						Admin._i18n['global']['title']['error'],
	  						Admin._i18n['global']['message']['error'],
	  						'danger'
	  					);
	  				}
	  			});
				event.preventDefault();
	  			return false;
			})
		});
	},

	modelSortable: function() {
		var model = null;
		$('table.sortable').sortable({
			helper: function(e, ui) {
			    ui.children().each(function() {
			        $(this).width($(this).width());
			    });
			    return ui;
			},
      		items: "tbody > tr",   		
      		placeholder: "ui-state-highlight",  
      		tolerance: 'pointer',
      		containment: "parent",
      		create: function() {
      			$(this).find('> thead th').each(function() {
    				$(this).width($(this).width());
    			});
      			model = $(this).attr('data-model');
      		},
      		start: function(event, ui) {
      			$('.ui-state-highlight').innerHeight($(ui.item).innerHeight());
      		},
    		stop: function(event, ui){
    			var itemsIds = Array();
    			var items = $(this).find('tbody tr');
    			for (var i = 0; i < items.length ; i++) {
    				itemsIds.push($(items[i]).attr('data-item-id'));
    			};
    			$.ajax({
	  				url: Admin.configGet('route_models_reorder'),
	  				method: 'POST',
	  				data: {
	  					'_token'  : Admin.configGet('csrf_token'),
	  					'model'	  : model,
	  					'itemsIds': itemsIds
	  				},
	  				error: function() {
	  					Admin.Modal.alert(
	  						Admin._i18n['global']['title']['error'],
	  						Admin._i18n['global']['message']['error'],
	  						'danger'
	  					);
	  				}
	  			});
    		}
    	});
	},

	highlightTableTr: function(itemTr) {
		itemTr.addClass('hightlight');
		setTimeout(function() {
			itemTr.removeClass('hightlight')
		}, 1000)
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