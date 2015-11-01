
<div class="form-group clearfix">
	
	<label for="">{{ trans('admin.pages.field.files') }}</label>
	<input class="form-control" name="{{ $name }}" id="{{ $name }}" type="hidden" />

	<div class="panel panel-default clearfix filebrowser">
		@if (isset($options['value']))
			<table class="table table-condensed">
				<tbody>
					@foreach($options['value'] as $picture)
						<tr>
							<td>
								{{ url($picture->path) }}
							</td>
							<td class="actions">
								<a href="" class="btn btn-primary btn-xs">{{ trans('admin.global.action.edit') }}</a>
								<a href="" class="btn btn-default btn-xs">{{ trans('admin.global.action.view') }}</a>
							</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2">
							<div class="dropzone" id="myAwesomeDropzone"></div>
						</td>
					</tr>
				</tfoot>
			</table>
		
			
		@endif 
		
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
