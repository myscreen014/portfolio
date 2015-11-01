
<div class="form-group clearfix">
	
	<label for="">{{ trans('admin.pages.field.files') }}</label>
	<input class="form-control" name="{{ $name }}-new" id="{{ $name }}-new" value="" type="text" />

	<div class="panel panel-default clearfix filebrowser">
		<div class="panel-heading dropzone" id="myAwesomeDropzone"></div>
  		<div class="panel-body">
  			<ul id="previewsContainer" class="files">
				@if (isset($options['value']))
					@foreach($options['value'] as $picture)
						<li class="dz-details">
							<img class="thumbnail" src="{{ route('file', $picture->id.'.filebrowser')}}" />
						</li>
					@endforeach
				@endif 
			</ul>
  		</div>
	</div>
	
</div>

<div id="preview-template" style="display: none;">
	<li class="dz-details">
  		<img data-dz-thumbnail class="thumbnail" />
  	</li>
</div>



@section('javascript')

	<script type="text/javascript">	
		
		var previewTemplate = $('#preview-template');

		Dropzone.options.myAwesomeDropzone = {
			dictDefaultMessage: "{{ trans('admin.global.message.upload_file_here') }}",
	  		paramName: "file", // The name that will be used to transfer the file
	  		maxFilesize: 2, // MB
	  		url: "{{ route('admin.files.store') }}",
	  		previewsContainer: '#previewsContainer',
	  		previewTemplate: previewTemplate.html(),
	  		createImageThumbnails: false,
		  	success: function(file, response) {
		  		if (response!==false) {
		  			Admin.addToSerializedField('{{ $name }}-new', response['file_id']);
		  			$(file.previewElement).find('img').attr('src', '/file/'+response['file_id']);
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
