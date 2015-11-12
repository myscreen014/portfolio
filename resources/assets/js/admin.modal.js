$.extend(Admin, {

	Modal: {

		_get: function(modaleName) {
			$('.'+modaleName+':not(.mother)').remove();
			var modal = $('.'+modaleName).clone().removeClass('mother');
			return modal;
		},

		showLoading: function() { 
			$('#modal-loading').modal('show');
		},

		hideLoading: function() {
			$('#modal-loading').modal('hide');
		},

		alert: function(title, message) {

			// preparing modal
			var modal = Admin.Modal._get('modal-default');
			var modalTitle = modal.find('.modal-title').html(title);
			var modalBody = modal.find('.modal-body').html(message);

			// display modal
			modal.modal();
		},

		filesUpload: function() {

			var modal = Admin.Modal._get('modal-files-upload');

			// display modal
			modal.modal(); 
			return modal;
		},

		picture: function(urlShow) {

			// preparing modal
			var modal = Admin.Modal._get('modal-default');
			var modalTitle = modal.find('.modal-title');
			var modalBody = modal.find('.modal-body').addClass('text-center');
			var modalFooter = modal.find('.modal-footer');

			$.ajax({
  				url: urlShow,
  				data: {},
  				success: function(response) {
  					var file = jQuery.parseJSON(response['values']);
  					var route = response['route'];
  					modalTitle.html(file['name']);
  					modalBody.html('<img src="'+route+'" />');	
  				}
  			});

  			// display modal
  			modal.modal();
		}, 

		ajaxForm: function(params) {

			// preparing modal
			var modal = Admin.Modal._get('modal-default');
			var modalTitle = modal.find('.modal-title');
			var modalBody = modal.find('.modal-body').removeClass('text-center');
			var modalFooter = modal.find('.modal-footer');
			modalTitle.html(params.title);

			// Ajax
			$.ajax({
  				url: params.url,
  				data: {},
  				success: function(form) {
  					form = $(form).clone();
  					button = form.find('button').remove();
  					if (button.attr('type') =='submit') {
  						button.bind('click', function(event) {
  							event.preventDefault();
  							$.ajax({
	  							url: form.attr('action'),
	  							method: (form.find('input[name=_method]')?form.find('input[name=_method]').val():form.attr('method')),
	  							data: form.serialize(),
	  							success: function(response, status) {
	  								modalBody.html('<div class="alert alert-success" role="alert">'+params.messageSuccess+'</div>');
	  								modalFooter.find('button[type=submit]').hide();
	  								if (typeof params.callbackSuccess != 'undefined') {
	  									params.callbackSuccess();	
	  								}
	  							},
	  							error: function(response) {
	  								modalBody.html('<div class="alert alert-danger" role="alert">'+params.messageError+'</div>');
	  								modalFooter.find('button[type=submit]').hide();
	  							},
	  						});
  						});
  					}
  					modalFooter.append(button);
  					modalBody.html(form);
  				}
  			});

			// display modal
			modal.modal();
		}
	}

});