
<div class="form-group clearfix">
	
	<label for="">{{ trans('admin.pages.field.files') }}</label>
	<input class="form-control" name="{{ $name }}_new" id="{{ $name }}_new" value="{{ Request::old($name.'_new') }}" type="hidden" />

	<div id="{{ $name }}" class="panel panel-default clearfix filebrowser dropzone">
  		<div class="panel-body">
  			<ul id="{{ $name }}-files-container" class="files clearfix">
				@if (isset($options['value']))
					@forelse($options['value'] as $file)

						<li id="preview-file-{{ $file->id }}" class="dz-details file thumbnail">
							<div class="dz-details-inner">
								<img src="{{ route('file', $file->id.'.filebrowser')}}" />
								<span class="file-actions">
									<span class="btn-group">
										<button type="button" class="btn btn-primary btn-xs modal-edit-open" data-url-edit="{{ route('admin.files.edit', $file->id) }}"><i class="fa fa-pencil"></i></button>
										<button type="button" class="btn btn-danger btn-xs modal-delete-open" data-url-delete="{{ route('admin.files.delete', $file->id) }}"><i class="fa fa-trash-o"></i></button>
										<button type="button" class="btn btn-default btn-xs modal-show-open" data-url-show="{{ route('admin.files.show', $file->id) }}"><i class="fa fa-eye"></i></button>
									</span>
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
			<img data-dz-thumbnail />
			<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
			<span class="file-actions ">
				<span class="btn-group">
					<button type="button" class="btn btn-primary btn-xs modal-edit-open" data-url-edit="{{ route('admin.files.edit', '%file_id') }}"><i class="fa fa-pencil"></i></button>
					<button type="button" class="btn btn-danger btn-xs modal-delete-open" data-url-delete="{{ route('admin.files.delete', '%file_id') }}"><i class="fa fa-trash-o"></i></button>
					<button type="button" class="btn btn-default btn-xs modal-show-open" data-url-show="{{ route('admin.files.show', '%file_id') }}"><i class="fa fa-eye"></i></button>
				</span>
			</span>
		</div>
	</li>
</div>





@section('javascript')

	<script type="text/javascript">	

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
					button.parents('li').hide();
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
	  		previewsContainer: '#{{ $name }}-files-container',
	  		previewTemplate: previewTemplate.html(),
		  	success: function(file, response) {
		  		if (response!==false) {
		  			Admin.addToSerializedField('{{ $name }}_new', response['file_id']);
		  			$(file.previewElement).html($(file.previewElement).html().replace(/%file_id/g, response['file_id']));	
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
