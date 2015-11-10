
<div class="form-group clearfix">

	
	<label for="">{{ trans('admin.pages.field.'.$name) }}</label>
	<input class="form-control" name="{{ $name }}_new" id="{{ $name }}_new" value="{{ Request::old($name.'_new') }}" type="hidden" />

	<div id="{{ $name }}" class="panel panel-default clearfix filebrowser dropzone">
  		<div class="panel-body">
  			<ul id="{{ $name }}-files-container" class="files clearfix">
				@if (isset($options['value']))
					@forelse($options['value'] as $file)

						<li id="preview-file-{{ $file->id }}" data-file-id="{{ $file->id }}" class="dz-details file col-md-6 col-lg-4 ">
							<div class="dz-details-inner clearfix">
								<span class="file-thumnails">
									<img src="{{ route('file', $file->id.'.filebrowser')}}" />
								</span>
								<span class="file-infos">
									<span class="file-summary">
										<strong class="file-name overflow">{{ $file->name }}</strong>
										<small class="file-type">{{ $file->type }}</small>
										<p>{{ $file->legend }}</p>
									</span>
									<span class="file-actions">
										<span class="btn-group">
											<button type="button" class="btn btn-primary btn-xs modal-edit-open" data-url-edit="{{ route('admin.files.edit', $file->id) }}"><i class="fa fa-pencil"></i></button>
											<button type="button" class="btn btn-danger btn-xs modal-delete-open" data-url-delete="{{ route('admin.files.delete', $file->id) }}"><i class="fa fa-trash-o"></i></button>
											<button type="button" class="btn btn-default btn-xs modal-show-open" data-url-show="{{ route('admin.files.show', $file->id) }}"><i class="fa fa-eye"></i></button>
										</span>
									</span>
								</span>
							</div>
						</li>

					@empty
						<p class="dz-message">{{ trans('admin.global.message.upload_file_here') }}</p>
					@endforelse
				@endif
			</ul>
  		</div>
	</div>
</div>

<div id="preview-template" style="display: none;">
	<li id="preview-file-%file_id" data-file-id="%file_id" class="dz-details file col-md-6 col-lg-4 ">
		<div class="dz-details-inner clearfix">
			<span class="file-thumnails">
				<img data-dz-thumbnail />
			</span>
			<span class="file-infos">
				<span class="file-summary">
					<strong class="file-name overflow">%file_name</strong>
					<small class="file-type">%file_type</small>
					<p></p>
				</span>
				<span class="file-actions">
					<span class="btn-group">
						<button type="button" class="btn btn-primary btn-xs modal-edit-open" data-url-edit="{{ route('admin.files.edit', '%file_id') }}"><i class="fa fa-pencil"></i></button>
						<button type="button" class="btn btn-danger btn-xs modal-delete-open" data-url-delete="{{ route('admin.files.delete', '%file_id') }}"><i class="fa fa-trash-o"></i></button>
						<button type="button" class="btn btn-default btn-xs modal-show-open" data-url-show="{{ route('admin.files.show', '%file_id') }}"><i class="fa fa-eye"></i></button>
					</span>
				</span>
			</span>
			<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
		</div>
	</li>
</div>





@section('javascript')

	@parent

	<script type="text/javascript">	

		/* Sortable - JQuery UI */
    	$( "#{{ $name }}-files-container" ).sortable({
      		placeholder: "ui-state-highlight dz-details file col-lg-4 col-md-6 ",
      		start: function(event, ui){
        		ui.placeholder.innerHeight(ui.item.innerHeight());
    		},
    		stop: function(event, ui){
    			var filesIds = Array();
    			var files = $( "#{{ $name }}-files-container" ).find('li');
    			for (var i = 0; i < files.length ; i++) {
    				filesIds.push($(files[i]).attr('data-file-id'));
    			};
    			$.ajax({
	  				url: "{{ route('admin.files.reorder') }}",
	  				method: 'POST',
	  				data: {
	  					'_token' : "{{ csrf_token() }}",
	  					'filesIds': filesIds
	  				},
	  				success: function(response) {
	  					console.log(response);
	  				}
	  			});
    		}

    	});

		/* Modal edit/delete/show */
		$('#{{ $name }}-files-container').on("click", '.modal-edit-open', function(event) {
			Admin.Modal.ajaxForm({
				'url' : $(this).attr('data-url-edit'),
				'title' : "{{ trans('admin.files.title.edit') }}",
				'messageSuccess': "{{ trans('admin.files.feedback.update.ok') }}",
				'messageError': "{{ trans('admin.files.feedback.update.error') }}",
			});
		});
		$('#{{ $name }}-files-container').on("click", '.modal-delete-open', function(event) {
			var button = $(this);
			Admin.Modal.ajaxForm({
				'url' : $(this).attr('data-url-delete'),
				'title' : "{{ trans('admin.files.title.delete') }}",
				'messageSuccess': "{{ trans('admin.files.feedback.delete.ok') }}",
				'messageError': "{{ trans('admin.files.feedback.delete.error') }}",
				'callbackSuccess': function() {
					button.parents('li').remove();
					if ($('#{{ $name }}-files-container .dz-details').length <= 0) {
						$('#{{ $name }} .dz-message').show();
					}
				}
			});
		});
		$('#{{ $name }}-files-container').on("click", '.modal-show-open', function(event) {
			Admin.Modal.picture($(this).attr('data-url-show'));
		});

		/* Dropzone */
		var previewTemplate = $('#preview-template');
		Dropzone.options.{{ $name }} = {
			dictDefaultMessage: "",
	  		paramName: "file", // The name that will be used to transfer the file
	  		maxFilesize: 5, // MB
	  		url: "{{ route('admin.files.store') }}",
	  		acceptedFiles: "{{ $options['dropzone_acceptedFiles'] }}",
	  		previewsContainer: '#{{ $name }}-files-container',
	  		previewTemplate: previewTemplate.html(),
		  	success: function(file, response) {
		  		if (response!==false) {
		  			var responseFile = response['file'];
		  			Admin.addToSerializedField('{{ $name }}_new', responseFile['id']);
		  			$(file.previewElement).html($(file.previewElement).html().replace(/%file_id/g, responseFile['id']));	
		  			$(file.previewElement).html($(file.previewElement).html().replace(/%file_name/g, responseFile['name']));	
		  			$(file.previewElement).html($(file.previewElement).html().replace(/%file_type/g, responseFile['type']));	
		  		}
		  	},
		  	init: function() {
			  	this.on("sending", function(file, xhr, formData) {
			   		formData.append("_token", "{{ csrf_token() }}");
			   		formData.append("model_table", "{{ $options['model_table'] }}");
			   		formData.append("model_field", "{{ $options['model_field'] }}");
			   		formData.append("model_id", "{{ $options['model_id'] }}");
			  	});
			  	this.on("addedfile", function(file) {
    				$('#{{ $name }} .dz-message').hide();
  				});
			}
		};
	</script>

@stop
