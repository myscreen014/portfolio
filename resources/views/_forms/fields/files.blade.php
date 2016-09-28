
<div class="form-group">

	<label for="{{ $name }}">{{ $options['label'] }}</label>
	<input class="form-control" name="{{ $name }}_new" id="{{ $name }}_new" value="{{ Request::old($name.'_new') }}" type="hidden" />

	<div id="{{ $name }}" class="panel panel-default clearfix filebrowser dropzone">
		<div class="panel-heading text-right">
			<span class="label label-info">{!! trans('admin.file.label.count.short', array('count' => count($options['value']))) !!}</span>
		</div>
  		<div class="panel-body">
  			<ul id="{{ $name }}-files-container" class="files clearfix">
  				<p class="dz-message" style="{{ (isset($options['value']) && count($options['value'])>0) ? 'display: none' : '' }}">{{ trans('admin.global.message.upload_file_here') }}</p>
				@if (isset($options['value']))
					@forelse($options['value'] as $file)
						@include('_forms.fields.file', ['file' => $file])
					@empty
					@endforelse
				@endif
			</ul>
  		</div>
  		<div class="panel-footer" id="{{ $name }}-action-add-files">
  			{{ trans('admin.file.action.add') }}
  		</div>
	</div>
</div>

@section('javascript')

	@parent

	<script type="text/javascript">	
 		$(document).ready(function() {
			/* Sortable - JQuery UI */
			var heightInitContainer = null;
	    	var containerSortable = $( "#{{ $name }}-files-container").sortable({
	      		placeholder: "ui-state-highlight dz-details file col-md-6 col-lg-4",  
	      		items: "> li",   		
	      		tolerance: 'pointer',
	      		create: function() {
	      			/*heightInitContainer = $(this).height();
	      			$(this).height(heightInitContainer);*/
	      		},
	      		start: function(event, ui){
	      			//$(this).height(heightInitContainer);
	        		ui.placeholder.innerHeight(ui.item.innerHeight());
	    		},
	    		stop: function(event, ui){
	    			var filesIds = Array();
	    			var files = $( "#{{ $name }}-files-container" ).find('li');
	    			for (var i = 0; i < files.length ; i++) {
	    				filesIds.push($(files[i]).attr('data-file-id'));
	    			};
	    			$.ajax({
		  				url: Admin.configGet('route_models_reorder'),
		  				headers: {
                    		'X-CSRF-Token': Admin.configGet('csrf_token')
                    	},
		  				method: 'POST',
		  				data: {
		  					'_token' : Admin.configGet('csrf_token'),
		  					'model'	: "file",
		  					'itemsIds': filesIds
		  				}
		  			});
	    		}
	    	});

			/* Modal edit/delete/show */
			$('#{{ $name }}-files-container').on("click", '.modal-edit-open', function(event) {
				var button = $(this);
				var fileId = button.parents('li').attr('data-file-id');
				Admin.Modal.ajaxForm({
					'url' : $(this).attr('data-url-edit'),
					'title' : "{{ trans('admin.file.title.edit') }}",
					'messageSuccess': "{{ trans('admin.file.feedback.update.ok') }}",
					'messageError': "{{ trans('admin.file.feedback.update.error') }}",
					callbackSuccess: function() {
						refreshFile('{{ $name }}', fileId);
					}
				});
			});
			$('#{{ $name }}-files-container').on("click", '.modal-delete-open', function(event) {
				var button = $(this);
				var fileId = button.parents('li').attr('data-file-id');
				Admin.Modal.ajaxForm({
					'url' : $(this).attr('data-url-delete'),
					'title' : "{{ trans('admin.file.title.delete') }}",
					'messageSuccess': "{{ trans('admin.file.feedback.delete.ok') }}",
					'messageError': "{{ trans('admin.file.feedback.delete.error') }}",
					callbackSuccess: function() {
						Admin.removeFromSerializedField('{{ $name }}_new', fileId);
						button.parents('li').remove();
						refreshDropzone('{{ $name }}');
					}
				});
			});
			$('#{{ $name }}-files-container').on("click", '.modal-show-open', function(event) {
				Admin.Modal.picture($(this).attr('data-url-show'));
			});

	
			/* Upload files */
			Admin.Upload.init({
				field						: "{{ $name }}",
				fieldType					: "{{ $type }}",
				acceptedFiles				: "{{ $options['accepted_files'] }}",
				routeStore					: "{{ route('admin.files.store') }}",
				routeGetitemfilebrowser		: "{{ route('admin.files.getitemfilebrowser') }}",
				modelTable					: "{{ $options['model_table'] }}",
				modelField					: "{{ $options['model_field'] }}",
				modelId						: "{{ $options['model_id'] }}",
				clickable					: "#{{ $name }}-action-add-files",
				token						: "{{ csrf_token() }}",
				success						: function(file) {
					var fileId = file['id'];
			  		$.ajax({
		  				url: "{{ route('admin.files.getitemfilebrowser') }}",
		  				method: 'POST',
		  				data: {
		  					'_token' : "{{ csrf_token() }}",
		  					'file_id' : fileId
		  				},
		  				success: function(response) {
		  					Admin.addToSerializedField('{{ $name }}_new', fileId);
		  					$('#{{ $name }}-files-container').append(response);
		  					refreshDropzone('{{ $name }}');
		  				}
		  			});
				},
			});

			
			function refreshFile(fieldName, fileId) {
				$.ajax({
	  				url: "{{ route('admin.files.getitemfilebrowser') }}",
	  				method: 'POST',
	  				data: {
	  					'_token' : "{{ csrf_token() }}",
	  					'file_id' : fileId
	  				},
	  				success: function(response) {
	  					$('#'+fieldName+'-files-container').find('#preview-file-'+fileId).replaceWith(response);
	  					refreshDropzone('{{ $name }}');
	  				}
	  			});
			}

			function refreshDropzone(fieldName) {
				// Refresh sortable
				containerSortable.height('auto').sortable( "refresh" );
				heightInitContainer = containerSortable.height();

				// Refresh dropzone status (empty, count files, ...)
				var countFiles = $('#'+fieldName+'-files-container .dz-details').length;
				if (countFiles == 0) {
					$('#'+fieldName+'-files-container .dz-message').show();
				} else {
					
					$('#'+fieldName+'-files-container .dz-message').hide();
				}
				$('#{{ $name }} .panel-heading .count-value').html(countFiles);
			}
	
		});
	</script>

@stop
