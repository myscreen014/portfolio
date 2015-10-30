<div class="form-group clearfix">
	<label for="">{{ trans('admin.pages.field.files') }}</label>

	<input class="form-control" name="{{ $name }}" id="{{ $name }}" />
	
	<div class="panel panel-default clearfix">
		@if (isset($options['value']))
			@foreach($options['value'] as $picture)
				<img src="{{ url($picture->path) }}" />
			@endforeach
		@endif 
		<div class="dropzone clearfix form-control" id="myAwesomeDropzone"></div>
	</div>
</div>


@section('javascript')

	<script type="text/javascript">	
		Dropzone.options.myAwesomeDropzone = {
			dictDefaultMessage: "{{ trans('admin.global.message.upload_file_here') }}",
	  		paramName: "file", // The name that will be used to transfer the file
	  		maxFilesize: 2, // MB
	  		url: "{{ route('admin.files.store') }}",
		  	success: function(file, response) {
		  		if (response!==false) {
		  			Admin.addToSerializedField('{{ $name }}', response['file_id']);
		  		}
		  	},
		  	init: function() {
			  	this.on("sending", function(file, xhr, formData) {
			   		formData.append("_token", "{{ csrf_token() }}");
			   		formData.append("model_table", "{{ $options['model_table'] }}");
			   		formData.append("model_id", "{{ $options['model_id'] }}");
			  	});
			  	this.on("addedfile", function(file, xhr, formData) {
			  		$('.dz-default').hide();
			  	});
			}
		};
	</script>

@stop
