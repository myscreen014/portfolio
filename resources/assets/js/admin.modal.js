$.extend(Admin, {

	Modal: {


		alert: function(title, content) {
			$('#modal-default').modal();
			$('#modal-default').find('.modal-title').html(title)
			$('#modal-default').find('.modal-body').html(content);
		}, 

		ajaxForm: function(params) {
			
			// preparing modal
			var modal = $('#modal-default');
			var modalTitle = modal.find('.modal-title');
			var modalBody = modal.find('.modal-body');
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
	  							},
	  							error: function(response) {
	  								console.log(response);
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