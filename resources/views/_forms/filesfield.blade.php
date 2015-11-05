
<div class="form-group clearfix">
	
	<label for="">{{ trans('admin.pages.field.files') }}</label>
	<input class="form-control" name="{{ $name }}_new" id="{{ $name }}_new" value="{{ Request::old($name.'_new') }}" type="hidden" />

	<div id="{{ $name }}" class="panel panel-default clearfix filebrowser dropzone">
  		<div class="panel-body">
  			<ul id="{{ $name }}-files-container" class="files clearfix">
				@if (isset($options['value']))
					@forelse($options['value'] as $picture)

						<li class="dz-details file thumbnail">
							<div class="dz-details-inner">
								<img src="{{ route('file', $picture->id.'.filebrowser')}}" />
								<span class="file-actions">
									<button type="button" class="btn btn-primary btn-xs modal-edit-open" data-url-edit="{{ route('admin.files.edit', $picture->id) }}">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="btn btn-default btn-xs modal-show-open"><i class="fa fa-eye"></i></button>
								</span>
							</div>
						</li>

					@empty
						<li class="dz-message">{{ trans('admin.global.message.upload_file_here') }}</li>
					@endforelse
				@endif
			</ul>
  		</div>
	</div>
	
</div>

<div id="preview-template" style="display: none;">
	<li class="dz-details file thumbnail">
		<div class="dz-details-inner">
			<img src="" />
			<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
			<span class="file-actions">
				<button type="button" class="btn btn-primary btn-xs modal-edit-open" data-url-edit="{{ route('admin.files.edit', '%s') }}">
					<i class="fa fa-pencil"></i>
				</button>
				<a href="" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a>
			</span>
		</div>
	</li>
</div>





@section('javascript')

	<script type="text/javascript">	

		/* Modal editing/show file */
		$('#{{ $name }}-files-container').on("click", '.modal-show-open', function(event) {
			Admin.alert('Mon titre', 'Mon contenu');
		});

		$('#{{ $name }}-files-container').on("click", '.modal-edit-open', function(event) {
			Admin.Modal.ajaxForm({
				'url' : $(this).attr('data-url-edit'),
				'title' : "{{ trans('admin.files.title.edit') }}",
				'messageSuccess': "{{ trans('admin.files.feedback.update.ok') }}",
				'messageError': "{{ trans('admin.files.feedback.update.error') }}",
			});
		});

		/* Dropzone */
		var previewTemplate = $('#preview-template');
		Dropzone.options.{{ $name }} = {
			dictDefaultMessage: "",
	  		paramName: "file", // The name that will be used to transfer the file
	  		maxFilesize: 5, // MB
	  		url: "{{ route('admin.files.store') }}",
	  		previewsContainer: '#{{ $name }}-files-container',
	  		previewTemplate: previewTemplate.html(),
	  		createImageThumbnails: false,
		  	success: function(file, response) {
		  		if (response!==false) {
		  			Admin.addToSerializedField('{{ $name }}_new', response['file_id']);
		  			$(file.previewElement).find('.modal-edit-open').attr(
		  				'data-url-edit',
		  				("{{ route('admin.files.edit', '%s') }}").replace("%s", response['file_id'])
		  			);
		  			$(file.previewElement).find('img').attr(
		  				'src', 
		  				("{{ route('file', '%s.filebrowser') }}").replace("%s", response['file_id'])
		  			);
		  		}
		  	},
		  	init: function() {
			  	this.on("sending", function(file, xhr, formData) {
			   		formData.append("_token", "{{ csrf_token() }}");
			   		formData.append("model_table", "{{ $options['model_table'] }}");
			   		formData.append("model_id", "{{ $options['model_id'] }}");
			  	});
			  	this.on("addedfile", function(file) {
    				$('#{{ $name }} .dz-message').hide();
  				});
			}
		};
	</script>

@stop
