
<div class="form-group clearfix">
	
	<label for="">{{ trans('admin.pages.field.files') }}</label>
	<input class="form-control" name="{{ $name }}_new" id="{{ $name }}_new" value="{{ Request::old($name.'_new') }}" type="hidden" />

	<div id="dropzone" class="panel panel-default clearfix filebrowser dropzone">
  		<div class="panel-body">
  			<ul id="files-container" class="files clearfix">
				@if (isset($options['value']))
					@foreach($options['value'] as $picture)
						<li class="dz-details file">
							<img class="thumbnail file-thumbnail" src="{{ route('file', $picture->id.'.filebrowser')}}" />
							<span class="file-actions">
								<a href="" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
	  							<a href="" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a>
							</span>
						</li>
					@endforeach
				@endif
			</ul>
  		</div>
	</div>
	
</div>

<div id="preview-template" style="display: none;">
	<li class="dz-details file">
  		<img data-dz-thumbnail class="thumbnail" />
  		<span class="file-actions">
			<a href="" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
			<a href="" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a>
		</span>
  	</li>
</div>

@section('javascript')

	<script type="text/javascript">	
		
		var previewTemplate = $('#preview-template');

		Dropzone.options.dropzone = {
			dictDefaultMessage: '',
	  		paramName: "file", // The name that will be used to transfer the file
	  		maxFilesize: 5, // MB
	  		url: "{{ route('admin.files.store') }}",
	  		previewsContainer: '#files-container',
	  		previewTemplate: previewTemplate.html(),
	  		createImageThumbnails: false,
		  	success: function(file, response) {
		  		if (response!==false) {
		  			Admin.addToSerializedField('{{ $name }}_new', response['file_id']);
		  			$(file.previewElement).find('img').attr(
		  				'src', 
		  				("{{ route('file', '%s') }}").replace("%s", response['file_id'])
		  			);
		  		}
		  	},
		  	init: function() {
			  	this.on("sending", function(file, xhr, formData) {
			   		formData.append("_token", "{{ csrf_token() }}");
			   		formData.append("model_table", "{{ $options['model_table'] }}");
			   		formData.append("model_id", "{{ $options['model_id'] }}");
			  	});
			}
		};
	</script>

@stop
